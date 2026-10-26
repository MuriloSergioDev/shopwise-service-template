<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Data\PingData;
use Illuminate\Foundation\Http\FormRequest;

final class CreatePingRequest extends FormRequest
{
    /**
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'max:200'],
        ];
    }

    public function toData(): PingData
    {
        return new PingData(message: $this->string('message')->toString());
    }
}
