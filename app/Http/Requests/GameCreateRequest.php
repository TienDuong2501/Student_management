<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GameCreateRequest extends FormRequest
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
            'name' => 'required|unique:games',
            'suggestion' => 'nullable',
            'file' => 'required|file|max:30240|mimetypes:pdf,txt,xlsx,xlsm,text/plain,doc,docx,ppt,pptx,ods,odt,odp',
        ];
    }
}
