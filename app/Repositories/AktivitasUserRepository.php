<?php

namespace App\Repositories;

use App\Models\AktivitasUser;

class AktivitasUserRepository
{
    protected $model;

    public function __construct(AktivitasUser $model)
    {
        $this->model = $model;
    }

    public function getAktivitasByUserRole($user)
    {
        if (!$user) return collect();

        if ($user->role === 'Admin') {
            return $this->model->with('user')->orderBy('created_at', 'desc')->get();
        }

        return $this->model->with('user')
            ->whereHas('user', function ($q) {
                $q->where('role', 'Karyawan');
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
