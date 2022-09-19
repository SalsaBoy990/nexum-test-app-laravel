<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //'original_filename'
            'view_name' => ['required', 'max:255', 'string'],
            'file_path' => ['required', 'mimes:png,jpg,jpeg,pdf,doc,docx,xls,txt,odt,ppt', 'max:1024'],
            // 'version',
            // 'user_id',
            'category_id' => ['required', 'integer'],
        ];
    }
}
