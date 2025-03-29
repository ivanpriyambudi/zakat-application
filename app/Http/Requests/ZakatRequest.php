<?php

namespace App\Http\Requests;

use App\Enums\ZakatTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ZakatRequest extends FormRequest
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
            'people_name' => 'required',
            'rw_id' => 'required|exists:rws,id',
            'rt_id' => 'required|exists:rts,id',
            'type' => ['required', Rule::in(ZakatTypeEnum::getValues())],
            'amount_type_id' => 'required|exists:satuan_zakats,id',
            'amount' => 'required|numeric',
        ];
    }
}
