<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePersonaRequest extends FormRequest
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
    $id = $this->route('id'); // Asume que el ID está en la ruta, puede necesitar ajuste si no es así

    return [
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'cedula' => 'required|numeric|digits_between:7,8',
        'correo' => 'required|email|max:255',
        'telefono' => 'required|numeric|digits:11',
        'direccion' => 'required|string|max:255',
        'estado' => 'required|string|max:255',
        'ciudad' => 'required|string|max:255',
    ];
}
}
