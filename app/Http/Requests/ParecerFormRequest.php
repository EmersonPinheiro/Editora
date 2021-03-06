<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParecerFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //TODO: Verificar permisser do usuário.
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
            'parecer'=>'required|file|mimes:pdf',
        ];
    }
}
