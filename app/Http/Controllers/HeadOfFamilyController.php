<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Resources\HeadOfFamilyResource;
use App\Http\Resources\PaginateResource;
use App\Interfaces\HeadOfFamilyRepositoryInterface;
use Illuminate\Http\Request;

class HeadOfFamilyController extends Controller
{
    private HeadOfFamilyRepositoryInterface $headOfFamilyRepository;

    public function __construct(HeadOfFamilyRepositoryInterface $headOfFamilyRepository)
    {
        $this->headOfFamilyRepository = $headOfFamilyRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            //code...
            $headOfFamilies = $this->headOfFamilyRepository->getAllHeadOfFamilies(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true,'Get all head of families successfully',
            HeadOfFamilyResource::collection($headOfFamilies), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false,'Failed to get all head of families', 'null', 500);
        }
    }

    public function getAllPaginated(Request $request){

        $request = $request->validate([
            'search' => 'nullable|string',
            'rowPerPage' => 'required|integer'
        ]);

        try {
            //code...
            $headOfFamilies = $this->headOfFamilyRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['rowPerPage']
            );

            return ResponseHelper::jsonResponse(true,'Get all head of families successfully',
            PaginateResource::make($headOfFamilies, HeadOfFamilyResource::class), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false,'Failed to get all head of families', 'null', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            //code...
            $headOfFamily = $this->headOfFamilyRepository->getById($id);
            if(!$headOfFamily){
                return ResponseHelper::jsonResponse(false, 'Head of family not found', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Get head of family successfully', new HeadOfFamilyResource($headOfFamily), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
