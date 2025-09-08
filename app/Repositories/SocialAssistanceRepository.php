<?php

namespace App\Repositories;

use App\Interfaces\SocialAssistanceRepositoryInterface;
use App\Models\SocialAssistance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SocialAssistanceRepository implements SocialAssistanceRepositoryInterface
{
    public function getAllSocialAssistances(string|null $search, int|null $limit, bool $execute)
    {
        $query = SocialAssistance::where(function ($query) use ($search) {
            // jika ada pencarian
            if ($search) {
                $query->search($search);
            }
        });

        if ($limit) {
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
        $query = $this->getAllSocialAssistances($search, $rowPerPage, false);
        return $query->paginate($rowPerPage);
    }

    public function create(array $data){
        DB::beginTransaction();
        try {
            $socialAssistance = new SocialAssistance();
            $socialAssistance->thumbnail = $data['thumbnail']->store('assets/social-assistance', 'public');
            $socialAssistance->name = $data['name'];
            $socialAssistance->category = $data['category'];
            $socialAssistance->amount = $data['amount'];
            $socialAssistance->provider = $data['provider'];
            $socialAssistance->description = $data['description'];
            $socialAssistance->is_available = $data['is_available'];
            $socialAssistance->save();
            DB::commit();
            return $socialAssistance;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    public function getById(string $id){
        $query = SocialAssistance::where('id', $id);
        return $query->first();
    }

    public function update(array $data, string $id){
        DB::beginTransaction();
        try {
            $socialAssistance = $this->getById($id);
            if(isset($data['thumbnail'])){
                if($socialAssistance->thumbnail){
                    // delete image
                    Storage::disk('public')->delete($socialAssistance->thumbnail);
                }
                $socialAssistance->thumbnail = $data['thumbnail']->store('assets/social-assistance', 'public');
            }
            $socialAssistance->name = $data['name'];
            $socialAssistance->category = $data['category'];
            $socialAssistance->amount = $data['amount'];
            $socialAssistance->provider = $data['provider'];
            $socialAssistance->description = $data['description'];
            $socialAssistance->is_available = $data['is_available'];
            $socialAssistance->save();
            DB::commit();
            return $socialAssistance;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    public function delete(string $id){
        DB::beginTransaction();
        try {
            $socialAssistance = $this->getById($id);
            if($socialAssistance->thumbnail){
                // delete image
                Storage::disk('public')->delete($socialAssistance->thumbnail);
            }
            $socialAssistance->delete();
            DB::commit();
            return $socialAssistance;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }
}
