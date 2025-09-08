<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\FamilyMemberStoreRequest;
use App\Http\Requests\FamilyMemberUpdateRequest;
use App\Http\Resources\FamilyMemberResource;
use App\Http\Resources\PaginateResource;
use App\Interfaces\FamilyMemberRepositoryInterface;
use Illuminate\Http\Request;

class FamilyMemberController extends Controller
{
    private FamilyMemberRepositoryInterface $familyMemberRepository;

    public function __construct(FamilyMemberRepositoryInterface $familyMemberRepository)
    {
        $this->familyMemberRepository = $familyMemberRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $familyMembers = $this->familyMemberRepository->getAllFamilyMembers(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true,'Get all family members successfully',
            FamilyMemberResource::collection($familyMembers), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false,'Failed to get all family members', 'null', 500);
        }
    }

    public function getAllPaginated(Request $request){

        $request = $request->validate([
            'search' => 'nullable|string',
            'rowPerPage' => 'required|integer'
        ]);

        try {
            //code...
            $familyMembers = $this->familyMemberRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['rowPerPage']
            );

            return ResponseHelper::jsonResponse(true,'Get all family members successfully',
            PaginateResource::make($familyMembers, FamilyMemberResource::class), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false,'Failed to get all family members', 'null', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FamilyMemberStoreRequest $request)
    {
        $request = $request->validated();

        try {
            $familyMember = $this->familyMemberRepository->create($request);
            return ResponseHelper::jsonResponse(true,'Create family member successfully',
            FamilyMemberResource::make($familyMember), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false,'Failed to create family member', 'null', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $familyMember = $this->familyMemberRepository->getById($id);
            if(!$familyMember){
                return ResponseHelper::jsonResponse(false,'Family member not found', 'null', 404);
            }
            return ResponseHelper::jsonResponse(true,'Get family member successfully',
            FamilyMemberResource::make($familyMember), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false,'Failed to get family member', 'null', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FamilyMemberUpdateRequest $request, string $id)
    {
        $request = $request->validated();

        try {
            $familyMember = $this->familyMemberRepository->getById($id);
            if(!$familyMember){
                return ResponseHelper::jsonResponse(false,'Family member not found', 'null', 404);
            }
            $familyMember = $this->familyMemberRepository->update($request, $id);
            return ResponseHelper::jsonResponse(true,'Update family member successfully',
            FamilyMemberResource::make($familyMember), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false,'Failed to update family member', 'null', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $familyMember = $this->familyMemberRepository->getById($id);
            if(!$familyMember){
                return ResponseHelper::jsonResponse(false,'Family member not found', 'null', 404);
            }
            $familyMember = $this->familyMemberRepository->delete($id);
            return ResponseHelper::jsonResponse(true,'Delete family member successfully', 'null', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false,'Failed to delete family member', 'null', 500);
        }
    }
}
