<?php

return [    
    'required' => 'Este campo es requerido.',


    'custom' => [
        'num_oficio' => [
            'unique' => 'Número de oficio repetido, ingrese otro',
        ],
        'num_recomendacion' => [
            'unique' => 'Número de recomendacion repetido, ingrese otro',
        ],
        'num_dictamen' => [
            'unique' => 'Número de dictamen repetido, ingrese otro',
        ],
        'identificador' => [
            'unique' => 'Usuario ya existente, no es posible volver a registrar',
        ],
        'email' => [
            'unique' => 'Correo ya existente, no es posible volver a registrar',
        ],
    ],
];
