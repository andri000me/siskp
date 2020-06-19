<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if($this->method() === 'PATCH'){
            $pass_rule = 'sometimes|max:255';
        }else{
            $pass_rule = 'required|string|max:255';
        }
        return [
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:100',
            'password' => $pass_rule
        ];
    }
}
