<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class HomeWorkUpdateRequest extends FormRequest
{
    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (integer) $request->route()->homework->id;
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
            'name' => 'required|unique:homeworks,name,' . $this->id,
            'home_work' => 'file|max:30240|mimetypes:pdf,txt,xlsx,xlsm,text/plain,doc,docx,ppt,pptx,ods,odt,odp',
        ];
    }
}
