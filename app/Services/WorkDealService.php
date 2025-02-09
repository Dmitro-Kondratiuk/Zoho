<?php

namespace App\Services;

use App\Data\DealsData;
use App\Data\DealsRequestData;
use App\Traits\ApiClientTrait;
use Spatie\LaravelData\DataCollection;

class WorkDealService
{
    use ApiClientTrait;

    public function index(): DataCollection
    {
        $response = $this->getDeals();
        return DealsData::collect(json_decode($response->getBody(), true)['data'], DataCollection::class);
    }

    public function create(DealsRequestData $data): void
    {
        try {
            $this->createDealInZoho($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
