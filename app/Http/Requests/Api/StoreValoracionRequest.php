<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\StoreValoracionRequest as RequestsStoreValoracionRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreValoracionRequest extends RequestsStoreValoracionRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            
        ]+parent::rules();
    }
}
