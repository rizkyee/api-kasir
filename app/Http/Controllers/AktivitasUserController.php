<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AktivitasUserService;

class AktivitasUserController extends Controller
{
    protected $service;

    public function __construct(AktivitasUserService $service)
    {
        $this->service = $service;
    }

    /**
     * List aktivitas user
     */
    public function index()
    {
        try {
            $aktivitas = $this->service->getAktivitas();
            return response()->json([
                'message' => 'Daftar aktivitas user',
                'data' => $aktivitas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
