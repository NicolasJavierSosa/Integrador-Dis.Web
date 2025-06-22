<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();
        $id = $this->route('producto');

        $rules = [
            'codigo' => ['required', 'string', 'max:16', 'unique:productos,codigo,' . $id],
            'nombre' => ['required', 'string', 'max:100'],
            'precio' => ['required', 'numeric', 'min:0'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'imagen' => [$method === 'POST' ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
        return $rules;
    }
    public function messages(): array
    {
        return [
            'codigo.required' => 'El código del producto es obligatorio.',
            'codigo.unique' => 'Este código ya está registrado en otro producto.',
            'codigo.max' => 'El código no puede tener más de 50 caracteres.',

            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',

            'precio.required' => 'El precio del producto es obligatorio.',
            'precio.numeric' => 'El precio debe ser un valor numérico.',
            'precio.min' => 'El precio no puede ser negativo.',

            'descripcion.max' => 'La descripción no puede tener más de 1000 caracteres.',

            'imagen.required' => 'La imagen del producto es obligatoria.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser de tipo JPG o PNG.',
            'imagen.max' => 'La imagen no debe pesar más de 2MB.',
        ];
    }
}
