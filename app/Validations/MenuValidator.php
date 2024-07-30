<?php

namespace App\Validations;
use App\Helpers\Func;

class MenuValidator
{
    protected static $validation_rules = [];

    public static function validate_rules($request, string $arg)
    {
        self::$validation_rules = [
            'create' => [
                'title' => 'required|unique:menu',
                'description' => 'required',
                'image_url' => 'required',
                'type' => 'required',
                'price' => 'required',
                'discount' => 'required',
            ],
            'delete' => [
                'id' => 'required',
            ],

            'update' => [
                'id' => 'required',
            ],
            'place_order' => [
                'menu_id' => 'required',
            ],
          
        ];

        return Func::run_validation($request, self::$validation_rules[$arg]);
    }
}
