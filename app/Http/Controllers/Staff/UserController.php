<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\User;
use App\Models\CustomerMenuOrder;

use App\Helpers\DBHelpers;
use App\Helpers\Func;

class UserController extends Controller
{
    //



    
    public function placed_orders(){
        $orders = DBHelpers::data_with_paginate(CustomerMenuOrder::class, ['menu', 'customer'], 100);
        return ResponseHelper::success_response(
            'All placed orders was fetched successfully',
            $orders
        );

    }




    public function view($id){
        if(!DBHelpers::exists(User::class, ['id' => $id, 'role' => 'customer'])){
            return ResponseHelper::error_response(
                'User not found',
                [],
                404
            );
        }

        $customer = DBHelpers::with_where_query_filter_first(User::class, [], ['id' => $id, 'role' => 'customer']);
        return ResponseHelper::success_response(
            'customer data was fetched successfully',
            $customer
        );

    }

    public function users(){
        $customers = DBHelpers::data_where_paginate(User::class, ['role' => 'customer'], 100);
        return ResponseHelper::success_response(
            'All registered customers was fetched successfully',
            $customers
        );

    }
}
