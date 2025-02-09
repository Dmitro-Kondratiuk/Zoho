<?php

namespace App\Services;

use App\Data\AccountData;
use App\Data\CreateAccountData;
use App\Data\DealsData;
use App\Traits\ApiClientTrait;
use Spatie\LaravelData\DataCollection;

use function Symfony\Component\Translation\t;

class WorkWithAccount
{
    use ApiClientTrait;

    public function index()
    {
        $response = $this->getAccount();

        return AccountData::collect(json_decode($response->getBody(), true)['data'], DataCollection::class);
    }

    public function create(CreateAccountData $data): void
    {
        try {
            $this->createAccountInZoho($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
