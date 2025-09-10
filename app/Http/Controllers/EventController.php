<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Resources\EventResource;
use App\Http\Resources\PaginateResource;
use App\Interfaces\EventRepositoryInterface;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{

    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            //code...
            $events = $this->eventRepository->getAllEvents(
                $request->search ?? null,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true,'Get all events successfully',
            EventResource::collection($events), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request){

        $request = $request->validate([
            'search' => 'nullable|string',
            'rowPerPage' => 'required|integer'
        ]);

        try {
            $events = $this->eventRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['rowPerPage']
            );
            return ResponseHelper::jsonResponse(
                true,
                'Get all events successfully',
                PaginateResource::make($events, EventResource::class),
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
    public function store(EventStoreRequest $request)
    {
        $request = $request->validated();
        try {
            //code...
            $event = $this->eventRepository->create($request);
            return ResponseHelper::jsonResponse(true, 'Event created successfully', new EventResource($event), 201);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            //code...
            $event = $this->eventRepository->getById($id);
            if(!$event){
                return ResponseHelper::jsonResponse(false, 'Event not found', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Get event successfully', new EventResource($event), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventUpdateRequest $request, string $id)
    {
        $request = $request->validated();

        try {
            //code...
            $event = $this->eventRepository->getById($id);
            if(!$event){
                return ResponseHelper::jsonResponse(false, 'Event not found', null, 404);
            }
            $event = $this->eventRepository->update($request, $id);
            return ResponseHelper::jsonResponse(true, 'Event updated successfully', new EventResource($event), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            //code...
            $event = $this->eventRepository->getById($id);
            if(!$event){
                return ResponseHelper::jsonResponse(false, 'Event not found', null, 404);
            }
            $event = $this->eventRepository->delete($id);
            return ResponseHelper::jsonResponse(true, 'Event deleted successfully', null, 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }
}
