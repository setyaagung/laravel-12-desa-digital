<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\SocialAssistanceStoreRequest;
use App\Http\Requests\SocialAssistanceUpdateRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\SocialAssistanceResource;
use App\Interfaces\SocialAssistanceRepositoryInterface;
use Illuminate\Http\Request;

class SocialAssistanceController extends Controller
{

    private SocialAssistanceRepositoryInterface $socialAssistanceRepository;

    public function __construct(SocialAssistanceRepositoryInterface $socialAssistanceRepository)
    {
        $this->socialAssistanceRepository = $socialAssistanceRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $socialAssistances = $this->socialAssistanceRepository->getAllSocialAssistances(
                $request->search ?? null,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Get social assistance data successfully',
            SocialAssistanceResource::collection($socialAssistances), 200);

        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false, 'Failed to get social assistance data', 'null', 500);
        }
    }

    public function getAllPaginated(Request $request){

        $request = $request->validate([
            'search' => 'nullable|string',
            'rowPerPage' => 'required|integer'
        ]);

        try {
            //code...
            $socialAssistances = $this->socialAssistanceRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['rowPerPage']
            );

            return ResponseHelper::jsonResponse(true,'Get all social assistance successfully',
            PaginateResource::make($socialAssistances, SocialAssistanceResource::class), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false,'Failed to get all social assistance', 'null', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SocialAssistanceStoreRequest $request)
    {
        $request = $request->validated();

        try {
            $socialAssistance = $this->socialAssistanceRepository->create($request);
            return ResponseHelper::jsonResponse(true,'Create social assistance successfully',
            SocialAssistanceResource::make($socialAssistance), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false,'Failed to create social assistance', 'null', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $socialAssistance = $this->socialAssistanceRepository->getById($id);
            if(!$socialAssistance){
                return ResponseHelper::jsonResponse(false,'Social assistance not found', 'null', 404);
            }
            return ResponseHelper::jsonResponse(true,'Get social assistance successfully',
            SocialAssistanceResource::make($socialAssistance), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false,'Failed to get social assistance', 'null', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SocialAssistanceUpdateRequest $request, string $id)
    {
        $request = $request->validated();

        try {
            $socialAssistance = $this->socialAssistanceRepository->getById($id);
            if(!$socialAssistance){
                return ResponseHelper::jsonResponse(false,'Social assistance not found', 'null', 404);
            }
            $socialAssistance = $this->socialAssistanceRepository->update($request, $id);
            return ResponseHelper::jsonResponse(true,'Update social assistance successfully',
            SocialAssistanceResource::make($socialAssistance), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false,'Failed to update social assistance', 'null', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $socialAssistance = $this->socialAssistanceRepository->getById($id);
            if(!$socialAssistance){
                return ResponseHelper::jsonResponse(false,'Social assistance not found', 'null', 404);
            }
            $socialAssistance = $this->socialAssistanceRepository->delete($id);
            return ResponseHelper::jsonResponse(true,'Delete social assistance successfully', 'null', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false,'Failed to delete social assistance', 'null', 500);
        }
    }
}
