<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.category.index');
    }

    public function manage(): View
    {
        return view('admin.category.manage');
    }
}
