<?php

namespace App\Http\Requests\Song;


use Illuminate\Foundation\Http\FormRequest;

class StoreSong extends FormRequest
{

   

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:255',
            'songFile' => 'required'
        ];
    }
}
