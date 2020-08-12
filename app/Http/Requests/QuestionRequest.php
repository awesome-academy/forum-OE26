<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'title' => 'required|max:255',
            'content' => 'required|max:1600000',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => trans('messages.title_required'),
            'title.max' => trans('messages.title_max'),
            'content.required' => trans('messages.content_required'),
            'content.max' => trans('messages.content_max'),
        ];
    }
}
