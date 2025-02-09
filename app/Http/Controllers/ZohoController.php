<?php

namespace App\Http\Controllers;

use App\Data\CreateAccountData;
use App\Data\DealsRequestData;
use App\Services\WorkDealService;
use App\Services\WorkWithAccount;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\LaravelData\DataCollection;

class ZohoController extends Controller
{
    public function __construct(
        private readonly WorkDealService $workDealService,
        private readonly WorkWithAccount $workWithAccount
    ) {
    }

    public function index(): Response
    {
        $deals = $this->workDealService->index();
        $accounts = $this->workWithAccount->index();
        return Inertia::render('Welcome', ['deals' => $deals, 'accounts' => $accounts]);
    }

    public function getDeals(): DataCollection
    {
        return $this->workDealService->index();
    }

    public function getAccounts(): DataCollection
    {
        return $this->workWithAccount->index();
    }

    /**
     * @throws \Exception
     */
    public function createDeal(DealsRequestData $data): JsonResponse
    {
        $this->workDealService->create($data);
        return response()->json(['message' => 'Deal created successfully.'], 201);
    }

    /**
     * @throws \Exception
     */
    public function createAccount(CreateAccountData $data): JsonResponse
    {
        $this->workWithAccount->create($data);
        return response()->json(['message' => 'Account created successfully.'], 201);
    }
}
