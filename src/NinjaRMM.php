<?php

namespace Supsign\Laravel;

use Supsign\Laravel\BaseApi;

class NinjaRMM extends BaseApi
{
    protected ?string $requestEncoding = 'x-www-form-urlencoded';

    public function __construct()
    {
        $this->authUrl = env('NINJA_REST_AUTH_URL');
        $this->baseUrl = env('NINJA_REST_URL');
        $this->clientId = env('NINJA_REST_CLIENT_ID');
        $this->clientSecret = env('NINJA_REST_CLIENT_SECRET');
    }

    public function getDevices(): array
    {
        return $this->makeCall('devices');
    }

    public function getOrganizations(): array
    {
        return $this->makeCall('organizations');
    }

    public function getPolicies(): array
    {
        return $this->makeCall('policies');
    }

    public function getRoles(): array
    {
        return $this->makeCall('roles');
    }

    protected function getBearerToken(): string
    {
        $response = json_decode(
            $this->fetchBearerToken([
                'scope' => 'control management monitoring'
            ])
        );

        if (!empty($response->resultCode) && $response->resultCode === 'FAILURE') {
            throw new \Exception($response->errorMessage);
        }

        return $response->access_token;
    }
}