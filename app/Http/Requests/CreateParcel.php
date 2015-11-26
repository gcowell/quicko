<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateParcel extends Request
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
        return
            [
                'width' => ['required', 'numeric'],
                'height' => ['required', 'numeric'],
                'depth' => ['required', 'numeric'],
                'weight' => ['required', 'numeric'],
                'startaddress' => 'required',
                'endaddress' => 'required',
                'startpoint' => ['required', 'regex:(^[0-9\.\-\ ]+$)'],
                'endpoint' => ['required', 'regex:(^[0-9\.\-\ ]+$)'],
                'contents' => 'required'
            ];
    }
}
