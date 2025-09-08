<?php

namespace App\Repositories;

use App\Interfaces\FamilyMemberRepositoryInterface;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FamilyMemberRepository implements FamilyMemberRepositoryInterface
{
    public function getAllFamilyMembers(string|null $search, int|null $limit, bool $execute)
    {
        $query = FamilyMember::where(function ($query) use ($search) {
            // jika ada pencarian
            if ($search) {
                $query->search($search);
            }
        });

        if($limit) {
            // mengambil beberapa
            $query->take($limit);
        }

        if($execute) {
            return $query->get();
        }

        return $query;
    }

    public function getAllPaginated(string|null $search, int|null $rowPerPage)
    {
        $query = $this->getAllFamilyMembers($search, $rowPerPage, false);
        return $query->paginate($rowPerPage);
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $userRepository = new UserRespository();
            $user = $userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            $familyMember = new FamilyMember();
            $familyMember->head_of_family_id = $data['head_of_family_id'];
            $familyMember->user_id = $user->id;
            $familyMember->profile_picture = $data['profile_picture']->store('assets/family-member', 'public');
            $familyMember->identity_number = $data['identity_number'];
            $familyMember->gender = $data['gender'];
            $familyMember->date_of_birth = $data['date_of_birth'];
            $familyMember->phone_number = $data['phone_number'];
            $familyMember->occupation = $data['occupation'];
            $familyMember->marital_status = $data['marital_status'];
            $familyMember->relation = $data['relation'];
            $familyMember->religion = $data['religion'];
            $familyMember->save();

            DB::commit();

            return $familyMember;

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    public function getById(string $id)
    {
        $query = FamilyMember::where('id', $id);
        return $query->first();
    }

    public function update(array $data, string $id)
    {
        DB::beginTransaction();

        try {
            //code...
            $familyMember = $this->getById($id);
            $familyMember->head_of_family_id = $data['head_of_family_id'];

            if(isset($data['profile_picture'])){
                if($familyMember->profile_picture){
                    // delete image
                    Storage::disk('public')->delete($familyMember->profile_picture);
                }
                $familyMember->profile_picture = $data['profile_picture']->store('assets/family-member', 'public');
            }
            $familyMember->identity_number = $data['identity_number'];
            $familyMember->gender = $data['gender'];
            $familyMember->date_of_birth = $data['date_of_birth'];
            $familyMember->phone_number = $data['phone_number'];
            $familyMember->occupation = $data['occupation'];
            $familyMember->marital_status = $data['marital_status'];
            $familyMember->relation = $data['relation'];
            $familyMember->religion = $data['religion'];
            $familyMember->save();

            $userRepository = new UserRespository();
            $userRepository->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => isset($data['password']) ? bcrypt($data['password'])
                    : $familyMember->user->password,
            ], $familyMember->user_id);

            DB::commit();

            return $familyMember;

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
            $familyMember = $this->getById($id);
            if(!$familyMember){
                throw new \Exception('Family member not found');
            }
            $familyMember->delete();
            $familyMember->profile_picture ? Storage::disk('public')->delete($familyMember->profile_picture) : null;
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }
}
