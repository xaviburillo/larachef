<?php

namespace App\Http\Requests;

use App\Models\Valoracion;
use Illuminate\Foundation\Http\FormRequest;

class UpdateValoracionRequest extends StoreValoracionRequest
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
            
        ]+parent::rules();
    }
}
