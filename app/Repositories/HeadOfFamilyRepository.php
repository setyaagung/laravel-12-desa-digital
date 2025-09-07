<?php

namespace App\Repositories;

use App\Interfaces\HeadOfFamilyRepositoryInterface;
use App\Models\HeadOfFamily;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HeadOfFamilyRepository implements HeadOfFamilyRepositoryInterface
{
    public function getAllHeadOfFamilies(
        ?string $search,
        ?int $limit,
        bool $execute
    ) {
        $query = HeadOfFamily::where(function ($query) use ($search) {
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
        $query = $this->getAllHeadOfFamilies($search, $rowPerPage, false);
        return $query->paginate($rowPerPage);
    }

    public function create(array $data){
        DB::beginTransaction();

        try {
            //code...
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();

            $headOfFamily = new HeadOfFamily();
            $headOfFamily->user_id = $user->id;
            $headOfFamily->profile_picture = $data['profile_picture'];
            $headOfFamily->identity_number = $data['identity_number'];
            $headOfFamily->gender = $data['gender'];
            $headOfFamily->date_of_birth = $data['date_of_birth'];
            $headOfFamily->phone_number = $data['phone_number'];
            $headOfFamily->occupation = $data['occupation'];
            $headOfFamily->marital_status = $data['marital_status'];
            $headOfFamily->save();

            DB::commit();

            return $headOfFamily;

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    public function getById(string $id){
        $query = HeadOfFamily::where('id', $id);
        return $query->first();
    }

    public function update(array $data, string $id){
        DB::beginTransaction();

        try {
            //code...
            $headOfFamily = $this->getById($id);
            $headOfFamily->profile_picture = $data['profile_picture'];
            $headOfFamily->identity_number = $data['identity_number'];
            $headOfFamily->gender = $data['gender'];
            $headOfFamily->date_of_birth = $data['date_of_birth'];
            $headOfFamily->phone_number = $data['phone_number'];
            $headOfFamily->occupation = $data['occupation'];
            $headOfFamily->marital_status = $data['marital_status'];
            $headOfFamily->save();

            DB::commit();
            return $headOfFamily;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    public function delete(string $id){

        DB::beginTransaction();
        try {
            //code...
            $headOfFamily = $this->getById($id);
            $headOfFamily->delete();
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }
}
