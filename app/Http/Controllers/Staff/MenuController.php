<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\User;
use App\Models\Menu;
use App\Helpers\DBHelpers;
use App\Helpers\Func;
use Illuminate\Support\Facades\Auth;
use App\Validations\MenuValidator;
use App\Validations\ErrorValidation;




class MenuController extends Controller
{
    //

    public function view($id){
        if(!DBHelpers::exists(Menu::class, ['id' => $id])){
            return ResponseHelper::error_response(
                'Menu not found',
                [],
                404
            );
        }

        $menu = DBHelpers::with_where_query_filter_first(Menu::class, [], ['id' => $id]);
        return ResponseHelper::success_response(
            'Menu data was fetched successfully',
            $menu
        );
    }


    public function delete(Request $request)
    {
        if ($request->isMethod('post')) {
            $validate = MenuValidator::validate_rules($request, 'delete');

            if (!$validate->fails() && $validate->validated()) {

                if(!DBHelpers::exists(Menu::class, ['id' => $request->id])){
                    return ResponseHelper::error_response(
                        'Menu not found',
                        [],
                        401
                    );
                }

                //// Delete Menu //
                DBHelpers::delete_query_multi(Menu::class, ['id' => $request->id]);
            
                return ResponseHelper::success_response(
                    'Menu deleted successfully',
                    null
                );

            } else {
                $errors = json_decode($validate->errors());
                $props = ['id'];
                $error_res = ErrorValidation::arrange_error($errors, $props);
                return ResponseHelper::error_response(
                    'validation error',
                    $error_res,
                    401
                );
            }
        } else {
            return ResponseHelper::error_response(
                'HTTP Request not allowed',
                '',
                404
            );
        }
    }


    public function update(Request $request)
    {
        if ($request->isMethod('post')) {
            $validate = MenuValidator::validate_rules($request, 'update');

            if (!$validate->fails() && $validate->validated()) {

                if(!DBHelpers::exists(Menu::class, ['id' => $request->id])){
                    return ResponseHelper::error_response(
                        'Menu not found',
                        [],
                        401
                    );
                }

               $menu = DBHelpers::query_filter_first(Menu::class, ['id' => $request->id]);

               $update_data = [
                   'title' => $request->title ? $request->title : $menu->title,
                   'price' => $request->price ? $request->price : $menu->price,
                   'type' => $request->type ? $request->type : $menu->type,
                   'discount' => $request->discount ? $request->discount : $menu->discount,
                   'description' => $request->description ? $request->description : $menu->description,
                   'image_url' => $request->image_url ? $request->image_url : $menu->image_url,
               ];

               DBHelpers::update_query_v3(Menu::class, $update_data, ['id' => $request->id]);
            
                return ResponseHelper::success_response(
                    'Menu updated successfully',
                    null
                );

            } else {
                $errors = json_decode($validate->errors());
                $props = ['id'];
                $error_res = ErrorValidation::arrange_error($errors, $props);
                return ResponseHelper::error_response(
                    'validation error',
                    $error_res,
                    401
                );
            }
        } else {
            return ResponseHelper::error_response(
                'HTTP Request not allowed',
                '',
                404
            );
        }
    }


    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $validate = MenuValidator::validate_rules($request, 'create');

            if (!$validate->fails() && $validate->validated()) {

                /// Save menu /////
                DBHelpers::create_query(Menu::class, $request->all());
        
                return ResponseHelper::success_response(
                    'Menu created successfully',
                    null
                );

            } else {
                $errors = json_decode($validate->errors());
                $props = ['title', 'type', 'image_url', 'discount', 'price', 'description'];
                $error_res = ErrorValidation::arrange_error($errors, $props);
                return ResponseHelper::error_response(
                    'validation error',
                    $error_res,
                    401
                );
            }
        } else {
            return ResponseHelper::error_response(
                'HTTP Request not allowed',
                '',
                404
            );
        }
    }



}
