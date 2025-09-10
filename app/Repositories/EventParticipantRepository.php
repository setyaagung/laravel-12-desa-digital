<?php

namespace App\Repositories;

use App\Interfaces\EventParticipantRepositoryInterface;
use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Support\Facades\DB;

class EventParticipantRepository implements EventParticipantRepositoryInterface
{
    public function getAllEventParticipants(string|null $search, int|null $limit, bool $execute)
    {
        try {
            //code...
            $query = EventParticipant::where(function ($query) use ($search) {
                // jika ada pencarian
                if ($search) {
                    $query->search($search);
                }
            });

            if ($limit) {
                $query->take($limit);
            }

            if ($execute) {
                return $query->get();
            }

            return $query;
        } catch (\Throwable $th) {
            //throw $th;
            return new \Exception($th->getMessage());
        }
    }

    public function getAllPaginated(string|null $search, int|null $rowPerPage)
    {
        $query = $this->getAllEventParticipants($search, $rowPerPage, false);
        return $query->paginate($rowPerPage);
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            //code...
            $eventParticipant = new EventParticipant();
            $eventParticipant->event_id = $data['event_id'];
            $eventParticipant->head_of_family_id = $data['head_of_family_id'];
            $eventParticipant->quantity = $data['quantity'];
            $eventParticipant->total_price = $data['total_price'];
            $eventParticipant->payment_status = 'pending';
            $eventParticipant->save();

            DB::commit();
            return $eventParticipant;
        } catch (\Throwable $th) {
            //throw $th;
            return new \Exception($th->getMessage());
        }
    }

    public function getById(string $id)
    {
        $query = EventParticipant::where('id', $id);
        return $query->first();
    }

    public function update(array $data, string $id)
    {
        DB::beginTransaction();
        try {
            //code...
            $eventParticipant = $this->getById($id);
            $eventParticipant->event_id = $data['event_id'];
            $eventParticipant->head_of_family_id = $data['head_of_family_id'];
            $eventParticipant->quantity = $data['quantity'];
            $eventParticipant->total_price = $data['total_price'];
            $eventParticipant->payment_status = $data['payment_status'];
            $eventParticipant->save();

            DB::commit();
            return $eventParticipant;
        } catch (\Throwable $th) {
            //throw $th;
            return new \Exception($th->getMessage());
        }
    }

    public function delete(string $id)
    {
        DB::beginTransaction();
        try {
            //code...
            $eventParticipant = $this->getById($id);
            $eventParticipant->delete();
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            return new \Exception($th->getMessage());
        }
    }
}
