<?php

declare(strict_types=1);

namespace App\Services\UserService;

use App\Models\Account;
use App\Models\ClientProfile;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceContract
{
    public function get(
        int $perPage,
        string $orderBy,
        string $orderDirection,
        ?string $search
    ): LengthAwarePaginator;

    public function delete(string $userId): bool;

    public function show(string $userId): void;

    public function create(array $data): User;

    public function update(User $user, array $data): User;
}
