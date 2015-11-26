<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateJourney extends Request
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
                'startaddress' => 'required',
                'endaddress' => 'required',
                'startpoint' => ['required', 'regex:(^[0-9\.\-\ ]+$)'],
                'endpoint' => ['required', 'regex:(^[0-9\.\-\ ]+$)'],
                'traveldate' => ['required', 'date', 'after:today']
            ];
    }
}

