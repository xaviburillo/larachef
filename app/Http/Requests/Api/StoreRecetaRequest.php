<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\StoreRecetaRequest as RequestsStoreRecetaRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;


class StoreRecetaRequest extends RequestsStoreRecetaRequest
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

    public function failedValidation(Validator $validator) {
        $response = response([
            'status' => 'ERROR',
            'message' => 'No se superaron los criterios de validación.',
            'errors' => $validator->errors()
        ], 422);

        throw new ValidationException($validator, $response);
    }
}
