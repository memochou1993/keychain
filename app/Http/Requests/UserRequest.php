<?php

namespace App\Http\Requests;

use App\Rules\ElementsInArray;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $route = $this->route() ? $this->route()->getName() : null;

        switch($route) {
            case 'users.show':
                return [
                    'with' => [
                        new ElementsInArray([
                            'keys',
                        ]),
                        'nullable',
                    ],
                ];

            case 'users.update':
                return [
                    'name' => [
                        'required',
                    ],
                    'username' => [
                        Rule::unique('users')->ignore($this->user),
                        'required',
                    ],
                    'password' => [
                        'min:8',
                        'nullable',
                    ],
                ];

            default:
                return [
                    //
                ];
        }
    }
}
