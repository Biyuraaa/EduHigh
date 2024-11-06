<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProposalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'topic' => 'required|string|max:255',
            'subkbk_id' => 'required|exists:subkbks,id',
            'titles.*' => 'required|string|max:255',
            'background' => 'required|string|max:1000',
            'backgroundReasons.*' => 'required|string|max:255',
            'previousResearch.*.title' => 'required|string|max:255',
            'previousResearch.*.doi' => 'required|string|max:255',
            'previousResearch.*.authors' => 'required|string|max:255',
            'previousResearch.*.problem' => 'required|string|max:255',
            'previousResearch.*.results' => 'required|string|max:255',
            'researchQuestions.*' => 'required|string|max:255',
            'researchOutputs.*' => 'required|string|max:255',
        ];
    }
}
