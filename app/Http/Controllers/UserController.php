<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\UserService\UserServiceContract;
use App\Http\Requests\UserRequests\IndexUsersRequest;
use App\Http\Requests\UserRequests\DeleteUserRequest;
use App\Http\Requests\UserRequests\ShowUserRequest;
use App\Http\Requests\UserRequests\CreateUserRequest;
use App\Http\Requests\UserRequests\UpdateUserRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResources\IndexUserResourceCollection;
use App\Http\Resources\UserResources\ShowUserResource;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(protected readonly UserServiceContract $userService)
    {
    }

    public function index(IndexUsersRequest $request): IndexUserResourceCollection
    {
        $perPage = $request->inputInt('per_page', 5);
        $orderBy = $request->inputString('order_by', 'name');
        $orderDirection = $request->inputString('order_direction', 'asc');
        $search = $request->inputString('search');

        $users = $this->userService->get(
            $perPage,
            $orderBy,
            $orderDirection,
            $search
        );

        return new IndexUserResourceCollection($users);
    }

    public function delete(string $id): JsonResponse
    {
        if ($this->userService->delete($id)) {
            return new JsonResponse(status: Response::HTTP_OK);
        }

        return new JsonResponse(status: Response::HTTP_CONFLICT);
    }

    public function show(string $id): ShowUserResource
    {
        $this->userService->show($request->user);

        return new ShowUserResource($request->user);
    }

    public function store(CreateUserRequest $request): ShowUserResource
    {
        $client = $this->userService->create($request->validated());

        return new ShowUserResource($client);
    }

    public function update(UpdateUserRequest $request): ShowUserResource
    {
        $client = $this->userService->update($request->user, $request->validated());

        return new ShowUserResource($client);
    }
}
