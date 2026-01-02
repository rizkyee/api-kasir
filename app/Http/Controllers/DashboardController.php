<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected $service;

    public function __construct(DashboardService $service)
    {
        $this->service = $service;
    }

    public function summary()
    {
        return response()->json([
            'data' => $this->service->summary()
        ]);
    }

    public function weeklyChart()
    {
        return response()->json([
            'data' => $this->service->weeklyChart()
        ]);
    }

    public function paymentMethods()
    {
        return response()->json([
            'data' => $this->service->paymentMethods()
        ]);
    }
}
