<?php

namespace App\Repositories;

use App\Interfaces\SocialAssistanceRecipientRepositoryInterface;
use App\Models\SocialAssistanceRecipient;
use Illuminate\Support\Facades\DB;

class SocialAssistanceRecipientRepository implements SocialAssistanceRecipientRepositoryInterface{

    public function getAllSocialAssistanceRecipients(string|null $search, int|null $limit, bool $execute)
    {
        try {
            $query = SocialAssistanceRecipient::where(function ($query) use ($search) {
                // jika ada pencarian
                if ($search) {
                    $query->search($search);
                }
            });

            if($limit) {
                $query->take($limit);
            }

            if($execute) {
                return $query->get();
            }

            return $query;
        } catch (\Throwable $th) {
            //throw $th;
            throw new \Exception($th->getMessage());
        }
    }

    public function getAllPaginated(string|null $search, int|null $rowPerPage)
    {
        $query = $this->getAllSocialAssistanceRecipients($search, $rowPerPage, false);
        return $query->paginate($rowPerPage);
    }

    public function create(array $data){
        DB::beginTransaction();

        try {
            $socialAssistanceRecipient = new SocialAssistanceRecipient();
            $socialAssistanceRecipient->social_assistance_id = $data['social_assistance_id'];
            $socialAssistanceRecipient->head_of_family_id = $data['head_of_family_id'];
            $socialAssistanceRecipient->bank = $data['bank'];
            $socialAssistanceRecipient->account_number = $data['account_number'];
            $socialAssistanceRecipient->amount = $data['amount'];
            $socialAssistanceRecipient->reason = $data['reason'];
            $socialAssistanceRecipient->proof = $data['proof'];
            $socialAssistanceRecipient->status = $data['status'];
            $socialAssistanceRecipient->save();

            DB::commit();

            return $socialAssistanceRecipient;

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    public function getById(string $id){
        $query = SocialAssistanceRecipient::where('id', $id);
        return $query->first();
    }

    public function update(array $data, string $id){
        DB::beginTransaction();
        try {
            $socialAssistanceRecipient = $this->getById($id);
            $socialAssistanceRecipient->social_assistance_id = $data['social_assistance_id'];
            $socialAssistanceRecipient->head_of_family_id = $data['head_of_family_id'];
            $socialAssistanceRecipient->bank = $data['bank'];
            $socialAssistanceRecipient->account_number = $data['account_number'];
            $socialAssistanceRecipient->amount = $data['amount'];
            $socialAssistanceRecipient->reason = $data['reason'];
            $socialAssistanceRecipient->proof = $data['proof'];
            $socialAssistanceRecipient->status = $data['status'];
            $socialAssistanceRecipient->save();

            DB::commit();

            return $socialAssistanceRecipient;

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    public function delete(string $id){
        DB::beginTransaction();
        try {
            $socialAssistanceRecipient = $this->getById($id);
            if(!$socialAssistanceRecipient){
                throw new \Exception('Social assistance recipient not found');
            }
            $socialAssistanceRecipient->delete();
            DB::commit();
            return $socialAssistanceRecipient;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }
}
