<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\RedirectResponse as RedirectResponseAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ZohoAuthController extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    public function zohoAuth(): RedirectResponseAlias
    {
        return $this->authService->authZoho();
    }

    /**
     * @throws \Exception
     */
    public function handleCallback(Request $request): RedirectResponseAlias
    {
        $this->authService->workWithCallback($request);
        return Redirect::route('welcome');
    }

    public function getUserZohoDN(): RedirectResponseAlias
    {
        $this->authService->getUser();
        return Redirect::route('welcome');
    }
}
