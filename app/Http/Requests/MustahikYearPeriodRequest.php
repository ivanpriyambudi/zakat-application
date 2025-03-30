<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MustahikYearPeriodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mustahik_id' => 'nullable|exists:mustahiks,id',
            'context' => 'nullable|string',
        ];
    }
}
