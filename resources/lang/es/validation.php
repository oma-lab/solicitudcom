<?php

return [    
    'required' => 'Este campo es requerido.',
    'confirmed' => 'Las contraseñas no coinciden.',
    'min' => [
        'string' => 'El :attribute debe tener al menos :min caracteres.',
    ],


    'custom' => [
        'identificador' => [
            'unique' => 'Usuario ya existente, no es posible volver a registrar',
        ],
        'password' => [
            'min' => 'La contraseña debe tener al menos :min caracteres',
        ],
        'nombre' => [
            'max' => 'El nombre debe tener menos de :max caracteres',
        ],
        'apellido_paterno' => [
            'max' => 'El apellido debe tener menos de :max caracteres',
        ],
        'email' => [
            'unique' => 'Correo ya existente, no es posible volver a registrar',
            'email' => 'Este no es un correo valido',
        ],
        'num_oficio' => [
            'unique' => 'Número de oficio repetido, ingrese otro',
        ],
        'num_recomendacion' => [
            'unique' => 'Número de recomendacion repetido, ingrese otro',
        ],
        'num_dictamen' => [
            'unique' => 'Número de dictamen repetido, ingrese otro',
        ],
    ],

    'attributes' => [],
];
