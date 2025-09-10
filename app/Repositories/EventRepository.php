<?php

namespace App\Repositories;

use App\Interfaces\EventRepositoryInterface;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventRepository implements EventRepositoryInterface
{
    public function getAllEvents(string|null $search, int|null $limit, bool $execute)
    {
        try {
            //code...
            $query = Event::where(function ($query) use ($search) {
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
        } catch (\Throwable $th) {
            //throw $th;
            throw new \Exception($th->getMessage());
        }
    }

    public function getAllPaginated(string|null $search, int|null $rowPerPage)
    {
        $query = $this->getAllEvents($search, $rowPerPage, false);
        return $query->paginate($rowPerPage);
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            //code...
            $event = new Event();
            $event->thumbnail = $data['thumbnail']->store('assets/events', 'public');
            $event->name = $data['name'];
            $event->date = $data['date'];
            $event->time = $data['time'];
            $event->price = $data['price'];
            $event->description = $data['description'];
            $event->is_active = $data['is_active'];
            $event->save();

            DB::commit();
            return $event;
        } catch (\Throwable $th) {
            //throw $th;
            throw new \Exception($th->getMessage());
        }
    }

    public function getById(string $id){
        $query = Event::where('id', $id);
        return $query->first();
    }

    public function update(array $data, string $id){
        DB::beginTransaction();
        try {
            $event = $this->getById($id);
            if(isset($data['thumbnail'])){
                if($event->thumbnail){
                    // delete image
                    Storage::disk('public')->delete($event->thumbnail);
                }
                $event->thumbnail = $data['thumbnail']->store('assets/events', 'public');
            }
            $event->name = $data['name'];
            $event->date = $data['date'];
            $event->time = $data['time'];
            $event->price = $data['price'];
            $event->description = $data['description'];
            $event->is_active = $data['is_active'];
            $event->save();

            DB::commit();
            return $event;
        } catch (\Throwable $th) {
            //throw $th;
            throw new \Exception($th->getMessage());
        }
    }

    public function delete(string $id)
    {
        DB::beginTransaction();
        try {
            //code...
            $event = $this->getById($id);
            if($event->thumbnail){
                // delete image
                Storage::disk('public')->delete($event->thumbnail);
            }
            $event->delete();

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            throw new \Exception($th->getMessage());
        }
    }
}
