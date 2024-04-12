<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Criteria\User\SearchCriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\ActivateRequest;
use App\Http\Requests\Api\V1\User\DeactivateRequest;
use App\Http\Requests\Api\V1\User\DetailRequest;
use App\Http\Requests\Api\V1\User\IndexRequest;
use App\Http\Requests\Api\V1\User\StoreRequest;
use App\Http\Requests\Api\V1\User\UpdateRequest;
use App\Http\Resources\Api\V1\User\MediumJsonResource as UserJsonResource;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @method IndexResource index(IndexRequest $request)
 * @method DetailResource detail(DetailRequest $request)
 * @method StoreResource store(StoreRequrest $request)
 * @method UpdateResource update(UpdateRequest $request)
 */
class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * @param UserRepository $userRepository
     * @param UserService $userService
     */
    public function __construct(
        UserRepository $userRepository,
        UserService $userService
    ) {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * @param IndexRequest $request
     *
     * @return AnonymousResourceCollection
     */
    public function index(IndexRequest $request): AnonymousResourceCollection
    {
        $users = $this->userRepository->pushCriteria(new SearchCriteria($request->validated()))
            ->paginate(config('repository.pagination.limit'));

        return UserJsonResource::collection($users);
    }

    /**
     * @param DetailRequest $request
     *
     * @return SupplierResource
     */
    public function detail(DetailRequest $request): UserJsonResource
    {
        return new UserJsonResource(
            $this->userRepository->firstOrFail([
                'id' => $request->id,
            ])
        );
    }

    /**
     * @param StoreRequest $request
     *
     * @return UserJsonResource
     */
    public function store(StoreRequest $request): UserJsonResource
    {
        return new UserJsonResource(
            $this->userService->store($request->validated())
        );
    }

    /**
     * @param UpdateRequest $request
     *
     * @return UserJsonResource
     */
    public function update(UpdateRequest $request): UserJsonResource
    {
        return new UserJsonResource(
            $this->userService->update($request->id, $request->validated())
        );
    }

    /**
     * @param DeactivateRequest $request
     *
     * @return UserJsonResource
     */
    public function deactivate(DeactivateRequest $request): UserJsonResource
    {
        return new UserJsonResource(
            $this->userService->deactivate($request->id),
        );
    }

    /**
     * @param ActivateRequest $request
     *
     * @return UserJsonResource
     */
    public function activate(ActivateRequest $request): UserJsonResource
    {
        return new UserJsonResource(
            $this->userService->activate($request->id),
        );
    }
}
