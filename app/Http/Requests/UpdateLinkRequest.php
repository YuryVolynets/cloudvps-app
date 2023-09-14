<?php

namespace App\Http\Requests;

use App\Models\Link;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateLinkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(Link $link): array
    {
        return [
            'name' => [
                'string',
                'nullable',
                'min:1',
                'max:255',
            ],
            'original_url' => [
                'string',
                'required',
                'min:1',
                'max:255',
            ],
            'shortened_url' => [
                'nullable',
                'string',
                'min:1',
                'max:255',
                Rule::unique('links')->ignore($link),
            ],
        ];
    }
}
