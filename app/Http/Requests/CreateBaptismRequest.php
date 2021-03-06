<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CreateBaptismRequest extends FormRequest
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
        return [
            'child_name'    =>  'required|min:2',
            'father_name'   =>  'required|min:2',
            'mother_name'   =>  'required|min:2',
            'birth_place'   =>  'nullable',
            'birthday'      =>  'nullable|date',
            'baptism_date'  =>  'nullable|date',
            'book_no'       =>  'required|integer',
            'page_no'       =>  'required|integer',
            'entry_no'      =>  'required|integer',
            'sponsors'      =>  'nullable',
            'remarks'       =>  'nullable',
            'minister_id'   =>  'required|integer'
        ];
    }





}
