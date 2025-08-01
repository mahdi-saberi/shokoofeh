<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProductRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'age_group' => 'required|array|min:1',
            'age_group.*' => 'required|string',
            'game_type' => 'required|array|min:1',
            'game_type.*' => 'required|string',
            'category' => 'required|array|min:1',
            'category.*' => 'required|string',
            'gender' => 'required|in:دختر,پسر,هردو',
            'product_code' => 'nullable|string|max:20|unique:products,product_code',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'عنوان محصول الزامی است.',
            'title.string' => 'عنوان محصول باید متن باشد.',
            'title.max' => 'عنوان محصول نباید بیش از ۲۵۵ کاراکتر باشد.',

            'price.numeric' => 'قیمت باید عدد باشد.',
            'price.min' => 'قیمت نمی‌تواند منفی باشد.',

            'description.string' => 'توضیحات باید متن باشد.',

            'stock.required' => 'موجودی انبار الزامی است.',
            'stock.integer' => 'موجودی انبار باید عدد صحیح باشد.',
            'stock.min' => 'موجودی انبار نمی‌تواند منفی باشد.',

            'image.image' => 'فایل انتخابی باید تصویر باشد.',
            'image.mimes' => 'فرمت تصویر باید jpeg، png، jpg، gif یا webp باشد.',
            'image.max' => 'حجم تصویر نباید بیش از ۲ مگابایت باشد.',

            'age_group.required' => 'انتخاب حداقل یک گروه سنی الزامی است.',
            'age_group.array' => 'گروه‌های سنی باید به صورت آرایه باشد.',
            'age_group.min' => 'حداقل یک گروه سنی باید انتخاب شود.',
            'age_group.*.required' => 'گروه سنی نمی‌تواند خالی باشد.',
            'age_group.*.string' => 'گروه سنی باید متن باشد.',

            'game_type.required' => 'انتخاب حداقل یک نوع بازی الزامی است.',
            'game_type.array' => 'انواع بازی باید به صورت آرایه باشد.',
            'game_type.min' => 'حداقل یک نوع بازی باید انتخاب شود.',
            'game_type.*.required' => 'نوع بازی نمی‌تواند خالی باشد.',
            'game_type.*.string' => 'نوع بازی باید متن باشد.',

            'category.required' => 'انتخاب حداقل یک دسته‌بندی الزامی است.',
            'category.array' => 'دسته‌بندی‌ها باید به صورت آرایه باشد.',
            'category.min' => 'حداقل یک دسته‌بندی باید انتخاب شود.',
            'category.*.required' => 'دسته‌بندی نمی‌تواند خالی باشد.',
            'category.*.string' => 'دسته‌بندی باید متن باشد.',

            'gender.required' => 'انتخاب جنسیت الزامی است.',
            'gender.in' => 'جنسیت باید یکی از موارد: دختر، پسر، هردو باشد.',

            'product_code.string' => 'کد محصول باید متن باشد.',
            'product_code.max' => 'کد محصول نباید بیش از ۲۰ کاراکتر باشد.',
            'product_code.unique' => 'این کد محصول قبلاً استفاده شده است.',
        ];
    }
}
