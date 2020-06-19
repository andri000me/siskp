<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DosenRequest extends FormRequest
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
            'nip' => 'required|string|max:50',
            'tanda_tangan' => 'sometimes|mimes:png|max:1024',
            'nama' => 'required|string|max:255',
            'password' => $pass_rule
        ];
    }
}
