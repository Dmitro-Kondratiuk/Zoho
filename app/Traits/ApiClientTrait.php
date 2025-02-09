<?php

namespace App\Traits;

use App\Data\CreateAccountData;
use App\Data\DealsData;
use App\Data\DealsRequestData;
use App\Services\Enum\GrantType;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Cache;

trait ApiClientTrait
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function headers(): array
    {
        return [
            'Authorization' => 'Zoho-oauthtoken '.Cache::get('access_token')
        ];
    }

    public function getUserZoho(): Response
    {
        return $this->client->get(
            'https://www.zohoapis.eu/crm/v2/users',
            [
                'headers' => $this->headers(),
            ]
        );
    }

    public function getDeals(): Response
    {
        return $this->client->get(
            "https://www.zohoapis.eu/crm/v2/Deals",
            [
                'headers' => [
                    'Authorization' => 'Zoho-oauthtoken '.Cache::get('access_token')
                ]
            ]
        );
    }
    public function getAccount(): Response
    {
        return $this->client->get(
            "https://www.zohoapis.eu/crm/v2/Accounts",
            [
                'headers' => [
                    'Authorization' => 'Zoho-oauthtoken '.Cache::get('access_token')
                ]
            ]
        );
    }

    public function refreshToken(string $refreshToken): Response
    {
        return $this->client->post('https://accounts.zoho.eu/oauth/v2/token', [
            'form_params' => [
                'grant_type' => GrantType::REFRESH_TOKEN->value,
                'client_id' => config('app.zoho.client_id'),
                'client_secret' => config('app.zoho.client_secret'),
                'refresh_token' => $refreshToken,
            ],
        ]);
    }

    public function getAccessToken(string $authorizationCode): Response
    {
        return $this->client->post('https://accounts.zoho.eu/oauth/v2/token', [
            'form_params' => [
                'grant_type' => GrantType::AUTHORIZATION_CODE->value,
                'client_id' => config('app.zoho.client_id'),
                'client_secret' => config('app.zoho.client_secret'),
                'redirect_uri' => config('app.zoho.redirect_url'),
                'code' => $authorizationCode,
            ]
        ]);
    }

    public function createDealInZoho(DealsRequestData $data): Response
    {
        return $this->client->post("https://www.zohoapis.eu/crm/v2/Deals", [
            'headers' => $this->headers(),
            'json' => ['data' => [$data->toArray()]],
        ]);
    }
    public function createAccountInZoho(CreateAccountData $data): Response
    {
        return $this->client->post("https://www.zohoapis.eu/crm/v2/Accounts", [
            'headers' => $this->headers(),
            'json' => ['data' => [$data->toArray()]],
        ]);
    }
}
