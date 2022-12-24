<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdatePost extends FormRequest
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
        $id = $this->segment(2); //pega o segmento 2 da url, que nesse caso é o id

        $rules = [
            'title' => [
                'required',
                'min:3',
                'max:160',
                Rule::unique('posts')->ignore($id), //title é unique apenas no create, no editar ele ignora o segmento 3
                            //que nesse caso é o id, na tabela posts
            ],

            'body' => [
                'nullable',
                'min:5',
                'max:10000'
            ],
            'image' => [
                'required',
                'image'
            ]
        ];

        if($this->method() == 'PUT'){ //se a requisição for do tipo PUT, editar
            $rules['image'] = ['nullable',  'image']; //não vai ser obrigatório preencher, mas se preencher é tipo image
        }

        return $rules;
    }
}
