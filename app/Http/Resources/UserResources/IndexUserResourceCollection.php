<?php

declare(strict_types=1);

namespace App\Http\Resources\UserResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class IndexUserResourceCollection extends ResourceCollection
{
    public $resource = IndexUserResource::class;

    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
