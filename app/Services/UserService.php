<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(protected UserRepository $users) {}

    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        return $this->users->create($data);
    }

    public function update($id, array $data)
    {
        $user = $this->users->findById($id);

        if (!$user) return null;

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->users->update($user, $data);
    }

    public function getByRole($role)
    {
        return \App\Models\User::where('role', $role)->get();
    }

    public function findKaryawan($id)
    {
        return \App\Models\User::where('role', 'Karyawan')
            ->where('id_user', $id)
            ->first();
    }

    public function updateKaryawan($id, array $data)
    {
        $user = $this->findKaryawan($id);

        if (! $user) return null;

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $data['role'] = 'Karyawan';

        return $this->users->update($user, $data);
    }

    public function deleteKaryawan($id)
    {
        $user = $this->findKaryawan($id);

        if (! $user) return false;

        return $user->delete();
    }
}
