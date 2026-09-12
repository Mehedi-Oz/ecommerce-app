<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class EcommerceController extends Controller
{
    public function index(): View
    {
        return view('frontend.home.index');
    }

    public function category(): View
    {
        return view('frontend.category.index');
    }

    public function details(): View
    {
        return view('frontend.details.index');
    }
}
