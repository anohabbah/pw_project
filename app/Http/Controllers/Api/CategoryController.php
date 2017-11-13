<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Category::list();
    }
}
