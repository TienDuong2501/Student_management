<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class GameUpdateRequest extends FormRequest
{
    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (integer) $request->route()->game->id;
    }

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
            'name' => 'required|unique:games,name,' . $this->id,
            'suggestion' => 'nullable',
            'file' => 'file|max:30240|mimetypes:pdf,txt,xlsx,xlsm,text/plain,doc,docx,ppt,pptx,ods,odt,odp',
        ];
    }
}
