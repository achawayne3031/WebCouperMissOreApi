<?php

namespace App\Validations;
use App\Helpers\Func;

class AuthValidator
{
    protected static $validation_rules = [];

    public static function validate_rules($request, string $arg)
    {
        self::$validation_rules = [
            'register' => [
                'email' => 'required|unique:users',
                'name' => 'required',
                'password' => 'required',
            ],
          
            'login' => [
                'email' => 'required',
                'password' => 'required',
            ],
          
        ];

        return Func::run_validation($request, self::$validation_rules[$arg]);
    }
}
