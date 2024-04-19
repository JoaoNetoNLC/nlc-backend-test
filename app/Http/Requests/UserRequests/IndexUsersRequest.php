<?php

declare(strict_types=1);

namespace App\Http\Requests\UserRequests;

use App\Actions\UserActions\SeeUserAction;
use App\Rules\UserCanAccessType;
use App\Services\UserService\UserStatusesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class IndexUsersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_by' => ['string', 'in:name,email'],
            'order_direction' => ['string', 'in:asc,desc'],
            'search' => ['string'],
        ];
    }
}
