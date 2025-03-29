<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MustahikRequest extends FormRequest
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
            'rw_id' => 'required|exists:rws,id',
            'rt_id' => 'required|exists:rts,id',
            'mustahik_type_id' => 'required|exists:mustahik_types,id',
            'name' => 'nullable|string',
            'names' => 'nullable',
        ];
    }
}
