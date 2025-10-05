<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccessTokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'access_token' => $this->plainTextToken,
            'token_type' => 'Bearer',
            'expires_at' => now()->addMinutes(config('sanctum.expiration')),
        ];
    }
}
