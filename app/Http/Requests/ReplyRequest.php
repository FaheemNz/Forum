<?php

namespace App\Http\Requests;

use App\Reply;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\SpamRule;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Gate;

class ReplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->getMethod() === 'POST') {
            return Gate::allows('create', new Reply);
        }

        return Gate::allows('update', new Reply);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => ['required', 'string', new SpamRule]
        ];
    }

    protected function failedAuthorization()
    {
        if ($this->getMethod() === 'POST') {
            throw new ThrottleRequestsException("You are posting too frequently... Have a break!");
        }
    }
}
