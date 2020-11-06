<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserUpdateRequest extends FormRequest
{
    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (integer) $request->route()->user->id;
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
        if (auth()->user()->role == 1) {
            return [
                'name' => 'required|unique:users,name,' . $this->id,
                'fullname' => 'required',
                'email' => 'required|email|unique:users,email,' . $this->id,
                'phone' => 'required|unique:users,phone,' . $this->id,
            ];
        }

        return [
            'password' => 'required|min:6',
            'password_confirmation' => 'required_with:password|same:password|min:6',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'phone' => 'required|unique:users,phone,' . $this->id,
        ];
    }
}
