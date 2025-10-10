<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $post = $this->route('post');
        return auth()->check() && auth()->id() === $post->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'min:3'],
            'content' => ['required', 'string', 'min:10'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'status' => ['required', 'in:draft,published'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
            'tags' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The post title is required.',
            'title.min' => 'The post title must be at least 3 characters.',
            'title.max' => 'The post title may not be greater than 255 characters.',
            'content.required' => 'The post content is required.',
            'content.min' => 'The post content must be at least 10 characters.',
            'status.required' => 'Please select a post status.',
            'status.in' => 'The selected status is invalid.',
            'categories.array' => 'Categories must be an array.',
            'categories.*.exists' => 'One or more selected categories are invalid.',
            'tags.max' => 'Tags may not be greater than 1000 characters.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'title' => 'post title',
            'content' => 'post content',
            'excerpt' => 'post excerpt',
            'status' => 'post status',
            'categories' => 'categories',
            'tags' => 'tags',
        ];
    }
}
