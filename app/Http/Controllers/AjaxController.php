<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Category\StoreCategoryRequest;

class AjaxController extends Controller
{

    public function getUsersByDeparment(Request $request)
    {
        $department_id = $request->input('department_id');
        return User::getDepartmentList($department_id);
    }


    public function getCategories (Request $request)
    {
        $type = $request->query('type');
        $categories = Category::select('id', 'name')->where('parent_id', $type)->get();
        return $categories;
    }


    public function storeCategory (StoreCategoryRequest $request)
    {
        $category = Category::create($request->only('name', 'parent_id'));
        return $category;
    }

}
