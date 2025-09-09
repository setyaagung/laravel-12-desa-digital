<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\SocialAssistanceRecipientStoreRequest;
use App\Http\Requests\SocialAssistanceRecipientUpdateRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\SocialAssistanceRecipientResource;
use App\Interfaces\SocialAssistanceRecipientRepositoryInterface;
use Illuminate\Http\Request;

class SocialAssistanceRecipientController extends Controller
{

    private SocialAssistanceRecipientRepositoryInterface $socialAssistanceRecipientRepository;

    public function __construct(SocialAssistanceRecipientRepositoryInterface $socialAssistanceRecipientRepository)
    {
        $this->socialAssistanceRecipientRepository = $socialAssistanceRecipientRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $socialAssistanceRecipients = $this->socialAssistanceRecipientRepository->getAllSocialAssistanceRecipients(
                $request->search ?? null,
                $request->limit,
                true,
            );

            return ResponseHelper::jsonResponse(true,'Get all social assistance recipients successfully',
            SocialAssistanceRecipientResource::collection($socialAssistanceRecipients), 200);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getAllPaginated(Request $request){

        $request = $request->validate([
            'search' => 'nullable|string',
            'rowPerPage' => 'required|integer'
        ]);

        try {
            //code...
            $socialAssistanceRecipients = $this->socialAssistanceRecipientRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['rowPerPage']
            );

            return ResponseHelper::jsonResponse(true,'Get all social assistance recipients successfully',
            PaginateResource::make($socialAssistanceRecipients, SocialAssistanceRecipientResource::class), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false,'Failed to get all social assistance recipients', 'null', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SocialAssistanceRecipientStoreRequest $request)
    {
        $request = $request->validated();
        try {
            $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->create($request);
            return ResponseHelper::jsonResponse(true, 'Social assistance recipient created successfully', new SocialAssistanceRecipientResource($socialAssistanceRecipient), 201);
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
            $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->getById($id);
            if(!$socialAssistanceRecipient){
                return ResponseHelper::jsonResponse(false,'Social assistance recipient not found', 'null', 404);
            }
            return ResponseHelper::jsonResponse(true,'Get social assistance recipient successfully',
            SocialAssistanceRecipientResource::make($socialAssistanceRecipient), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false,'Failed to get social assistance recipient', 'null', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SocialAssistanceRecipientUpdateRequest $request, string $id)
    {
        $request = $request->validated();

        try {
            //code...
            $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->getById($id);
            if(!$socialAssistanceRecipient){
                return ResponseHelper::jsonResponse(false,'Social assistance recipient not found', 'null', 404);
            }
            $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->update($request, $id);
            return ResponseHelper::jsonResponse(true,'Update social assistance recipient successfully',
            SocialAssistanceRecipientResource::make($socialAssistanceRecipient), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false,'Failed to update social assistance recipient', 'null', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            //code...
            $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->getById($id);
            if(!$socialAssistanceRecipient){
                return ResponseHelper::jsonResponse(false,'Social assistance recipient not found', 'null', 404);
            }
            $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->delete($id);
            return ResponseHelper::jsonResponse(true,'Delete social assistance recipient successfully',
            SocialAssistanceRecipientResource::make($socialAssistanceRecipient), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false,'Failed to delete social assistance recipient', 'null', 500);
        }
    }
}
