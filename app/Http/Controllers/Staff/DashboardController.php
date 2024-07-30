<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\User;
use App\Models\Menu;

use App\Helpers\DBHelpers;
use App\Helpers\Func;

class DashboardController extends Controller
{
    //

    public function dashboard(){

        //// New Code ////
        $total_customers = DBHelpers::count(User::class, ['role' => 'customer']);
        $total_menu = DBHelpers::count(Menu::class);
        $total_menu_on_discount = DBHelpers::count(Menu::class, ['discount' => 1]);


        $res = [
            'total_customers' => $total_customers,
            'total_menu' => $total_menu,
            'total_menu_on_discount' => $total_menu_on_discount
        ];

        return ResponseHelper::success_response(
            'Dashboard details fetched successfully',
            $res
        );
    }


}
