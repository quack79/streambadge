<?php

namespace TwitchApiClass;

class twitchWrapper
{
    private const CLIENT_ID = '9mkmqucsg7qqo1o76d7ldc7rx1igsa';
    private const CLIENT_SECRET = 'REMOVED';
    private const ACCESS_CODE = 'REMOVED'; // Authorization code
    private const REDIRECT_URI = 'https://quack.me/streambadge/'; // Your applications redirect URI
    private const TOKEN_FILENAME = 'accesstoken.txt'; // Change this name. It is the file your token will be stored in

    private const URI = 'https://api.twitch.tv'; // DO NOT CHANGE
    private const TWITCH_OUATH_URI = 'https://id.twitch.tv/oauth2'; // DO NOT CHANGE

    private string $access_token = '';
    private string $refresh_token = '';
    private string $expires_dt = '';
    private array $call_data;
    private array $stream_data = [];

    public function __construct()
    {
        $this->getTokensFromFile();
    }

    public function accessCodeUrl(string $scope = "user:edit+user:read:email"): string
    {
        return self::TWITCH_OUATH_URI . "/authorize?response_type=code&client_id=" . self::CLIENT_ID . "&redirect_uri=" . self::REDIRECT_URI . "&scope=$scope";
    }

    public function doCurl(string $url, string $type = 'GET', array $headers = [], array $post_fields = [], int $con_timeout = 5, int $timeout = 20): array
    {
        $crl = curl_init($url);
        if ($type === 'POST') {
            curl_setopt($crl, CURLOPT_POST, true);
            if (!empty($post_fields)) {
                curl_setopt($crl, CURLOPT_POSTFIELDS, $post_fields);
            }
        }
        if (!empty($headers)) {
            curl_setopt($crl, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($crl, CURLOPT_CUSTOMREQUEST, $type);
        curl_setopt($crl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, $con_timeout);
        curl_setopt($crl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($crl, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
        $call_response = curl_exec($crl);
        $responseInfo = curl_getinfo($crl);
        curl_close($crl);
        if ($responseInfo['http_code'] === 200) {
            return json_decode($call_response, true);
        }
        return array('http_response_code' => $responseInfo['http_code']);// Call failed
    }

    public function dateTimePassed(string $dt_to_check): bool
    { //False on passed
        date_default_timezone_set('UTC');
        $dt1 = strtotime(date('Y-m-d H:i:s', strtotime($dt_to_check)));
        $dt2 = strtotime(date('Y-m-d H:i:s'));
        return $dt1 < $dt2;
    }

    private function addSecondsToDateTime(int $seconds): string
    {
        date_default_timezone_set('UTC');
        return date("Y-m-d H:i:s", strtotime("+{$seconds} sec"));
    }

    public function getTokensFromFile(): void
    {
        if (!file_exists(self::TOKEN_FILENAME)) { // First time use = create the file
            $this->createTokenFile();
        }
        $tokens = json_decode(file_get_contents(self::TOKEN_FILENAME), false);
        $this->access_token = $tokens->access_token;
        $this->refresh_token = $tokens->refresh_token;
        $this->expires_dt = $tokens->expires;
        if ($this->dateTimePassed($this->expires_dt)) {
            $this->refreshToken();
            $this->getTokensFromFile();
        }
    }

    public function createTokenFile(): bool
    {
        $url = self::TWITCH_OUATH_URI . "/token?client_id=" . self::CLIENT_ID . "&client_secret=" . self::CLIENT_SECRET . "&code=" . self::ACCESS_CODE . "&grant_type=authorization_code&redirect_uri=" . self::REDIRECT_URI;
        $data = $this->doCurl($url, "POST");
        $contents = '{"access_token": "' . $data['access_token'] . '", "refresh_token": "' . $data['refresh_token'] . '", "expires": "' . $this->addSecondsToDateTime($data['expires_in']) . '"}';
        $fp = fopen(self::TOKEN_FILENAME, 'wb');
        fwrite($fp, $contents);
        return fclose($fp);
    }

    public function refreshToken(): bool
    {
        $url = self::TWITCH_OUATH_URI . "/token?grant_type=refresh_token&refresh_token=$this->refresh_token&client_id=" . self::CLIENT_ID . "&client_secret=" . self::CLIENT_SECRET;
        $data = $this->doCurl($url, 'POST');
        $contents = '{"access_token": "' . $data['access_token'] . '", "refresh_token": "' . $data['refresh_token'] . '"}';
        $fp = fopen(self::TOKEN_FILENAME, 'wb');
        fwrite($fp, $contents);
        return fclose($fp);
    }

    private function GETHeaders(): array
    {
        return array("Authorization: Bearer $this->access_token", "Client-ID: " . self::CLIENT_ID);
    }

    public function getUserStream(string $username): array
    {
        return $this->stream_data = $this->doCurl(self::URI . '/helix/streams?user_login=' . rawurlencode($username), 'GET', $this->GETHeaders());
    }

    public function userIsLive(): ?bool
    {
        if (isset($this->stream_data['data'][0])) {
            return true; // Yes
        }
        return false; // No
    }

}