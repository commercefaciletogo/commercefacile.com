<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'name' => [
            'required' => 'Vous devez fournir votre nom',
            'max' => 'Votre Nom ne doit pas etre superieur a :max caracteres',
        ],
        'username' => [
            'required' => 'Vous devez fournir votre numero de telephone.',
        ],
        'code' => [
            'required' => 'Vous devez fournir le code.',
            'same' => 'Le code est incorrect.',
        ],
        'phone' => [
            'required' => 'Vous devez fournir votre Numero de telephone',
            'unique' => 'The numero de telephone a ete deja pris.',
            'exists' => 'The numero de telephone est incorrect.',
            'regex' => 'The numero de telephone est incorrect.',
        ],
        'password' => [
            'required' => 'Vous devez fournir votre mot de passe',
            'min' => 'Doit etre au moins :min caracteres',
            'confirmed' => 'Vous devez confirmer votre mot de passe',
        ],
        'password_confirmation' => [
            'required' => 'Vous devez confirmer votre mot de passe',
            'same' => 'Doit correspondre a votre mot de passe',
        ]
    ],

];