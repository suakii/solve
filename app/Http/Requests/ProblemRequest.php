<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProblemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        'title'     => 'required|string|max:255',
        'statement' => 'required|string',
        'time_limit'    => 'nullable|integer|min:100',
        'memory_limit'  => 'nullable|integer|min:16',
        'judge_type'    => 'required|in:NORMAL,SPECIAL,OUTPUT_ONLY',
        'judge_lang'    => 'nullable|string|max:30',
        'cases_zip'     => 'nullable|file|mimes:zip',
    ];
    }
}
