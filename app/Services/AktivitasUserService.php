<?php

namespace App\Services;

use App\Repositories\AktivitasUserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // ini yang benar


class AktivitasUserService
{
    protected $repo;

    public function __construct(AktivitasUserRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Ambil semua aktivitas user
     */
    public function getAktivitas()
    {
        // Ambil user default (user pertama)
        $user = $user ?? Auth::user() ?? User::first();

        if (!$user) {
            throw new \Exception("Tidak ada user untuk log aktivitas");
        }


        return $this->repo->getAktivitasByUserRole($user);
    }

    /**
     * Catat aktivitas user otomatis
     */
    public function logAktivitas($aksi, $modul, $deskripsi = null, $user = null)
    {
        // Ambil user login jika ada, fallback ke default
        $user = $user ?? Auth::user() ?? User::first();

        if (!$user) {
            throw new \Exception("Tidak ada user untuk log aktivitas");
        }

        return $this->repo->create([
            'id_user' => $user->id_user, // pastikan pakai id_user
            'aksi' => $aksi,
            'modul' => $modul,
            'deskripsi' => $deskripsi,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }
}
