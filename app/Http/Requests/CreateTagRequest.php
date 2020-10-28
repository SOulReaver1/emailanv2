<?php

namespace App\Http\Requests;

use App\Email;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class CreateTagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'bases' => 'required',
            'tags' => 'required',
        ];
    }
}
