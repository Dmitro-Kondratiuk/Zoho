<?php

namespace App\Services;

use App\Data\UserData;
use App\Models\User;
use App\Traits\ApiClientTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;

class AuthService
{
    use ApiClientTrait;

    public function authZoho(): RedirectResponse
    {
        $clientId = config('app.zoho.client_id');
        $redirectUri = config('app.zoho.redirect_url');
        $scope = config('app.zoho.scope');
        $accessType = config('app.zoho.access_type');

        $url = config(
                'app.zoho.api_url'
            )."/oauth/v2/auth?response_type=code&client_id={$clientId}&redirect_uri={$redirectUri}&scope={$scope}&access_type={$accessType}";
        return Redirect::to($url);
    }


    public function workWithCallback(Request $request): RedirectResponse
    {
        $authorizationCode = $request->get('code');
        if (!$authorizationCode) {
            throw new \Exception('Authorization code is missing');
        }

        try {
            $response = $this->getAccessToken($authorizationCode);
            $data = json_decode($response->getBody(), true);
            $this->updateDbAndCache($data);
            return Redirect::to(route('welcome'));
        } catch (\Exception $e) {
            throw new \Exception('Zoho API Error: '.$e->getMessage());
        }
    }

    public function refreshZohoToken(): RedirectResponse
    {
        $refreshToken = Cache::get('refresh_token') !== null
            ? Cache::get('refresh_token')
            : User::first()->refresh_token;

        if (!$refreshToken) {
            return Redirect::to(route('zoho.auth'));
        }

        try {
            $response = $this->refreshToken($refreshToken);

            $data = json_decode($response->getBody(), true);

            if (!isset($data['access_token'])) {
                throw new \Exception('Access Token  is missing: '.$data);
            }
            $this->updateDbAndCache($data);
        } catch (\Exception $e) {
            throw new \Exception('Zoho Token Refresh Error: '.$e->getMessage());
        }
        return Redirect::to(route('welcome'));
    }

    private function updateDbAndCache(array $data): void
    {
        $data['expires_in'] = Carbon::parse(now()->addSeconds($data['expires_in']))->unix() + 3600;
        User::first()->update($data);

        Cache::put('access_token', $data['access_token']);
        Cache::put('expires_in', $data['expires_in']);
        Cache::put('refresh_token', $data['refresh_token']);
    }


    public function getUser(): Model
    {
        $response = $this->getUserZoho();
        $responseBody = json_decode($response->getBody(), true);
        dd($responseBody);
        return $this->findOrCreateUser($responseBody);
    }

    private function findOrCreateUser(array $responseBody): Model
    {
        $userZoho = $responseBody['users'][0];
        return User::findOrCreate(
            ['zoho_id' => $userZoho['id']],
            UserData::from($userZoho)->toArray()
        );
    }
}
