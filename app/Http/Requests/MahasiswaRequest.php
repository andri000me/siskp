<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MahasiswaRequest extends FormRequest
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
            'nim' => 'required|string|max:50',
            'nama' => 'required|string|max:255',
            'password' => $pass_rule,
            'id_dosen' => 'required|integer',
            'id_prodi' => 'required|integer'
        ];
    }
}
