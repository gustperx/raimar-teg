<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AjaxController extends Controller
{

    public function getUsersByDeparment(Request $request)
    {
        $department_id = $request->input('department_id');
        return User::getDepartmentList($department_id);
    }

}
