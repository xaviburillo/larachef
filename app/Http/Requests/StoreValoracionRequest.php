<?php

namespace App\Http\Requests;

use App\Models\Valoracion;
use Illuminate\Foundation\Http\FormRequest;

class StoreValoracionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('store', Valoracion::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'texto' => 'required|string|max:1000',
        ];
    }
}
