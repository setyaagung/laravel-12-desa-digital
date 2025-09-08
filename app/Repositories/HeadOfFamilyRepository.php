<?php

namespace App\Repositories;

use App\Interfaces\HeadOfFamilyRepositoryInterface;
use App\Models\HeadOfFamily;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            $userRepository = new UserRespository();
            $user = $userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            $headOfFamily = new HeadOfFamily();
            $headOfFamily->user_id = $user->id;
            $headOfFamily->profile_picture = $data['profile_picture']->store('assets/head-of-family', 'public');
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
            if(isset($data['profile_picture'])){
                if($headOfFamily->profile_picture){
                    // delete image
                    Storage::disk('public')->delete($headOfFamily->profile_picture);
                }
                $headOfFamily->profile_picture = $data['profile_picture']->store('assets/head-of-family', 'public');
            }
            $headOfFamily->identity_number = $data['identity_number'];
            $headOfFamily->gender = $data['gender'];
            $headOfFamily->date_of_birth = $data['date_of_birth'];
            $headOfFamily->phone_number = $data['phone_number'];
            $headOfFamily->occupation = $data['occupation'];
            $headOfFamily->marital_status = $data['marital_status'];
            $headOfFamily->save();

            $userRepository = new UserRespository();
            $userRepository->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => isset($data['password']) ? bcrypt($data['password'])
                    : $headOfFamily->user->password,
            ], $headOfFamily->user_id);

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
            if(!$headOfFamily){
                throw new \Exception('Head of family not found');
            }
            $headOfFamily->delete();
            $headOfFamily->profile_picture ? Storage::disk('public')->delete($headOfFamily->profile_picture) : null;
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }
}
