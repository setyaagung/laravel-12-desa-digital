<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $users = $this->userRepository->getAllUsers(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Get user data successfully', UserResource::collection($users), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        $request = $request->validate([
            'search' => 'nullable|string',
            'rowPerPage' => 'required|integer',
        ]);
        try {
            $users = $this->userRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['rowPerPage'],
            );
            return ResponseHelper::jsonResponse(
                true,
                'Get user data successfully',
                PaginateResource::make($users, UserResource::class),
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
    public function store(UserStoreRequest $request)
    {
        $request = $request->validated();
        try {
            $user = $this->userRepository->create($request);
            return ResponseHelper::jsonResponse(true, 'User created successfully', new UserResource($user), 201);
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
            $user = $this->userRepository->getById($id);

            if (!$user) {
                return ResponseHelper::jsonResponse(false, 'User not found', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'User data successfully retrieved', new UserResource($user), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $request = $request->validated();
        try {
            $user = $this->userRepository->getById($id);

            if (!$user) {
                return ResponseHelper::jsonResponse(false, 'User not found', null, 404);
            }

            $user = $this->userRepository->update($request, $id);

            return ResponseHelper::jsonResponse(true, 'User updated successfully', new UserResource($user), 200);
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
            $user = $this->userRepository->getById($id);

            if (!$user) {
                return ResponseHelper::jsonResponse(false, 'User not found', null, 404);
            }

            $user = $this->userRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'User deleted successfully', \null, 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }
}
