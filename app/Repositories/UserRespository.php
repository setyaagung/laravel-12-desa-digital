<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRespository implements UserRepositoryInterface
{
    public function getAllUsers(
        ?string $search,
        ?int $limit,
        bool $execute
    ) {
        $query = User::where(function ($query) use ($search) {
            // jika ada pencarian
            if ($search) {
                $query->search($search);
            }
        });

        if ($limit) {
            // mengambil beberapa
            $query->take($limit);
        }

        if ($execute) {
            return $query->get();
        }
        return $query;
    }

    public function getAllPaginated(?string $search, ?int $rowPerPage)
    {
        $query = $this->getAllUsers($search, $rowPerPage, false);
        return $query->paginate($rowPerPage);
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            //code...
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();

            DB::commit();
            return $user;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    public function getById(string $id)
    {
        $query = User::where('id', $id);
        return $query->first();
    }

    public function update(array $data, string $id)
    {
        DB::beginTransaction();
        try {
            //code...
            $user = $this->getById($id);
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = $data['password'] ? bcrypt($data['password']) : $user->password;
            $user->save();

            DB::commit();
            return $user;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    public function delete(string $id)
    {
        DB::beginTransaction();
        try {
            //code...
            $user = $this->getById($id);

            $user->delete();

            DB::commit();

            return true;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }
}
