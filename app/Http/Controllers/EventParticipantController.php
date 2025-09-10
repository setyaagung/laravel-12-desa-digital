<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\EventParticipantStoreRequest;
use App\Http\Requests\EventParticipantUpdateRequest;
use App\Http\Resources\EventParticipantResource;
use App\Http\Resources\PaginateResource;
use App\Interfaces\EventParticipantRepositoryInterface;
use Illuminate\Http\Request;

class EventParticipantController extends Controller
{
    private EventParticipantRepositoryInterface $eventParticipantRepository;

    public function __construct(EventParticipantRepositoryInterface $eventParticipantRepository)
    {
        $this->eventParticipantRepository = $eventParticipantRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            //code...
            $eventParticipants = $this->eventParticipantRepository->getAllEventParticipants(
                $request->search ?? null,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true,'Get all event participants successfully',
            EventParticipantResource::collection($eventParticipants), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false,'Failed to get all event participants', 'null', 500);
        }
    }

    public function getAllPaginated(Request $request){

        $request = $request->validate([
            'search' => 'nullable|string',
            'rowPerPage' => 'required|integer'
        ]);

        try {
            $eventParticipants = $this->eventParticipantRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['rowPerPage']
            );
            return ResponseHelper::jsonResponse(
                true,
                'Get all event participants successfully',
                PaginateResource::make($eventParticipants, EventParticipantResource::class),
                200
            );
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventParticipantStoreRequest $request)
    {
        $request = $request->validated();
        try {
            $eventParticipant = $this->eventParticipantRepository->create($request);
            return ResponseHelper::jsonResponse(true,'Create event participant successfully',
            EventParticipantResource::make($eventParticipant), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false,'Failed to create event participant', 'null', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            //code...
            $eventParticipant = $this->eventParticipantRepository->getById($id);
            if(!$eventParticipant){
                return ResponseHelper::jsonResponse(false, 'Event participant not found', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Get event participant successfully', new EventParticipantResource($eventParticipant), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventParticipantUpdateRequest $request, string $id)
    {
        $request = $request->validated();

        try {
            $eventParticipant = $this->eventParticipantRepository->getById($id);
            if(!$eventParticipant){
                return ResponseHelper::jsonResponse(false,'Event participant not found', 'null', 404);
            }
            $eventParticipant = $this->eventParticipantRepository->update($request, $id);
            return ResponseHelper::jsonResponse(true,'Update event participant successfully',
            EventParticipantResource::make($eventParticipant), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false,'Failed to update event participant', 'null', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $eventParticipant = $this->eventParticipantRepository->getById($id);
            if(!$eventParticipant){
                return ResponseHelper::jsonResponse(false,'Event participant not found', 'null', 404);
            }
            $eventParticipant = $this->eventParticipantRepository->delete($id);
            return ResponseHelper::jsonResponse(true,'Delete event participant successfully',
            EventParticipantResource::make($eventParticipant), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false,'Failed to delete event participant', 'null', 500);
        }
    }
}
