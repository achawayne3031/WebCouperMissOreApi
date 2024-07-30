<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\User;
use App\Helpers\DBHelpers;
use App\Helpers\Func;
use Illuminate\Support\Facades\Auth;


class CustomerController extends Controller
{
    //

    //// Show user profile /////
    public function profile(){
        $user = Auth::user();
        $uid = Auth::id();

        return ResponseHelper::success_response(
            'User profile was fetched successfully',
            $user
        );
    }


}
