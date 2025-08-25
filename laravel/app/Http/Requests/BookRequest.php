<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'authorIds'  => ['required', 'array', 'min:1'],
            'authorIds.*' => ['required', 'integer', 'exists:autores,codAu'],
            'subjectIds' => ['required', 'array', 'min:1'],
            'subjectIds.*'=> ['integer', 'exists:assuntos,codAs'],
            'title'      => ['required', 'string', 'max:40'],
            'publisher'  => ['required', 'string', 'max:40'],
            'edition'    => ['required', 'integer', 'min:1'],
            'year'       => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'price'      => ['required', 'regex:/^\d{1,3}(\.\d{3})*(,\d{1,2})?$/'], // formato pt-BR
        ];
    }

    public function messages(): array
    {
        return [
            'authorIds.required'   => 'É necessário selecionar pelo menos um autor.',
            'authorIds.array'      => 'Formato de autores inválido.',
            'authorIds.*.exists'   => 'Um dos autores selecionados não existe.',
            'subjectIds.required'  => 'É necessário selecionar pelo menos um assunto.',
            'subjectIds.array'     => 'Formato de assuntos inválido.',
            'subjectIds.*.exists'  => 'Um dos assuntos selecionados não existe.',
            'title.required'       => 'O título é obrigatório.',
            'title.max'            => 'O título deve ter no máximo 40 caracteres.',
            'publisher.required'   => 'A editora é obrigatória.',
            'publisher.max'        => 'A editora deve ter no máximo 40 caracteres.',
            'edition.required'     => 'A edição é obrigatória.',
            'edition.min'          => 'A edição deve ser no mínimo 1.',
            'year.required'        => 'O ano é obrigatório.',
            'year.min'             => 'O ano deve ser maior ou igual a 1900.',
            'year.max'             => 'O ano deve ser menor ou igual a ' . (date('Y') + 1) . '.',
            'price.required'       => 'O preço é obrigatório.',
            'price.regex'          => 'O preço deve estar no formato correto (ex: 100,00 ou 1.000,15).',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Erro de validação',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
