<?php

declare(strict_types=1);

namespace App\Services\UserService;

use App\Actions\AccountActions\HaveAnAccountAction;
use App\Actions\AccountActions\HaveAnBindAccountAction;
use App\Actions\AccountActions\ManageAccountAction;
use App\Events\UserEvents\UserArchiveUserEvent;
use App\Events\UserEvents\UserCreateClientEvent;
use App\Events\UserEvents\UserDeleteUserEvent;
use App\Events\UserEvents\UserUnarchiveUserEvent;
use App\Events\UserEvents\UserUpdateClientEvent;
use App\Models\Account;
use App\Models\ClientProfile;
use App\Models\Organization;
use App\Models\Request;
use App\Models\User;
use App\Services\TeamService\TeamServiceContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Throwable;
use App\Services\RolesService\RoleServiceContract;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use App\Models\Pivots\UserAccount;
use App\Models\Product;
use App\Models\Pivots\UserRequest;

class UserService implements UserServiceContract
{
    public function get(
        int $perPage,
        string $orderBy,
        string $orderDirection,
        ?string $search
    ): LengthAwarePaginator {
        $query = User::query();

        $query->when($search, fn ($query) => $query->search($search));

        return $query
            ->orderBy($orderBy, $orderDirection)
            ->paginate(perPage: $perPage);
    }

    public function delete(string $userId): bool
    {
        // to do
        return false;
    }

    public function show(string $userId): void
    {
        // to do
    }

    public function create(array $data): User
    {
        $roleService = App::get(RoleServiceContract::class);
        $role = $roleService->findBySlug($data['role_slug']);
        $clientProfile = $this->pullClientProfileData($data);
        $data['organization_id'] = Organization::where('slug', 'no-limit-creatives')->value('id');
        $data['role_id'] = $role->id;

        if (!empty($data['account_slug'])) {
            $data['account_id'] = Account::where('slug', $data['account_slug'])->value('id');
        }

        if (!empty($data['team_slug'])) {
          /** @var TeamServiceContract $teamService */
          $teamService = App::get(TeamServiceContract::class);
          $team = $teamService->findBySlug(
              $data['team_slug']
          );
          $data['team_id'] = $team->id;
        }

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $client = new User();
        $client->fill($data);
        $client->saveOrFail();
        $client->clientProfile()->create($clientProfile);
        $this->loadClientRelations($client);

        if ($role->isOwner()) {
            $account = Account::create([
                "status" => "demo",
                "slug" => Str::slug($data['account_name']),
                "name" => $data['account_name'],
                "free_account" => $data['free_account'] ?? false,
                "product_id" => Product::where('slug', $data['product_id'])->value('id'),
                "owner_id" => $client->id,
            ]);

            UserAccount::create([
                "user_id" => $client->id,
                "account_id" => $account->id,
            ]);
        }

        if ($role->isAccountCollaborator()) {
            $requestIds = $data['requests_ids'] ?? [];
            foreach ($requestIds as $requestId) {
                UserRequest::create([
                    "user_id" => $client->id,
                    "request_id" => $requestId
                ]);
            }
        }

        if ($role->isAccountManager() || $role->isAccountCollaborator()) {
            UserAccount::create([
                "user_id" => $client->id,
                "account_id" => $data['account_id'],
            ]);
        }

        event(new UserCreateClientEvent($client));

        return $client;
    }

    public function update(User $user, array $data): User
    {
        $clientProfile = $this->pullClientProfileData($data);

        $user->update($data);
        $user->clientProfile()->update($clientProfile);
        $this->loadClientRelations($user);

        event(new UserUpdateClientEvent($user));

        return $user;
    }
}
