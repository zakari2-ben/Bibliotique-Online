<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
    // Règles de validation
    public function rules(): array
    {
        return [
            'designation' => 'required|string|max:255',
            'auteur'      => 'required|string|max:255',
            'prix'        => 'required|numeric|min:0',
            'type'        => 'required|string|max:255',
            'categorie'    => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'editeur'     => 'nullable|string|max:255',
            'annee'       => 'nullable|numeric',


        ];
    }

    public function messages(): array
    {
        return [
            'designation.required' => 'La désignation est obligatoire.',
            'designation.string'   => 'La désignation doit être une chaîne de caractères.',
            'designation.max'      => 'La désignation ne doit pas dépasser 255 caractères.',

            'auteur.required'      => 'Le nom de l’auteur est obligatoire.',
            'auteur.string'        => 'Le nom de l’auteur doit être une chaîne de caractères.',
            'auteur.max'           => 'Le nom de l’auteur ne doit pas dépasser 255 caractères.',

            'prix.required'        => 'Le prix est obligatoire.',
            'prix.numeric'         => 'Le prix doit être un nombre.',
            'prix.min'             => 'Le prix doit être supérieur ou égal à 0.',

            'type.required'        => 'Le type du livre est obligatoire.',
            'type.string'          => 'Le type doit être une chaîne de caractères.',
            'type.max'             => 'Le type ne doit pas dépasser 255 caractères.',
            'cover.image'          => 'Le fichier doit être une image.',
            'cover.mimes'          => 'L’image doit être au format : jpeg, png, jpg, gif ou svg.',
            'cover.max'            => 'La taille de l’image ne doit pas dépasser 2 Mo.',
        ];
    }
}
