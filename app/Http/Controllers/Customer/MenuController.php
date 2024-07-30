<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\CustomerMenuOrder;
use App\Models\Menu;
use App\Helpers\DBHelpers;
use App\Helpers\Func;
use Illuminate\Support\Facades\Auth;
use App\Validations\MenuValidator;
use App\Validations\ErrorValidation;
use Carbon\Carbon;




class MenuController extends Controller
{
    //


    //// Customer place order ////
    public function place_order(Request $request)
    {
        if ($request->isMethod('post')) {
            $validate = MenuValidator::validate_rules($request, 'place_order');

            if (!$validate->fails() && $validate->validated()) {
                $uid = Auth::id();

                ///// checking the time ////
                $time = Carbon::now(); 
                $start = Carbon::create($time->year, $time->month, $time->day, 10, 0, 0); //set time to 10:00
                $end = Carbon::create($time->year, $time->month, $time->day, 18, 0, 0); //set time to 18:00
        
                ///// checking the time between the store working hours /////
                if(!$time->between($start, $end, true)) {
                    return ResponseHelper::success_response(
                        'We are not taking orders right now, try again tomorrow (10AM - 6PM)',
                        null
                    );
                }


                /// checking if you have placed this order before ////
                if(DBHelpers::exists(CustomerMenuOrder::class, ['customer_id' => $uid, 'menu_id' => $request->menu_id])){
                    return ResponseHelper::error_response(
                        'Menu already in your order',
                        [],
                        404
                    );
                }

                /// Saving order /////
                $order_data = [
                    'menu_id' => $request->menu_id,
                    'customer_id' => $uid
                ];
                DBHelpers::create_query(CustomerMenuOrder::class, $order_data);
        
                return ResponseHelper::success_response(
                    'Order Placed successfully',
                    null
                );

            } else {
                $errors = json_decode($validate->errors());
                $props = ['menu_id'];
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





    public function drinks(){
        $menus = DBHelpers::where_query(Menu::class, ['type' => 'drink']);
        return ResponseHelper::success_response(
            'Menu with drinks was fetched successfully',
            $menus
        );
    }



    public function discounted(){
        $menus = DBHelpers::where_query(Menu::class, ['discount' => 1]);
        return ResponseHelper::success_response(
            'Menu with discount was fetched successfully',
            $menus
        );
    }

    
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


    public function menus(Request $request){
        $menus = DBHelpers::all_data(Menu::class);
      
        return ResponseHelper::success_response(
            'All menu was fetched successfully',
            $menus
        );
    }







}
