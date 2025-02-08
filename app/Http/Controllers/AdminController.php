<?php

namespace App\Http\Controllers; // Namespace harus di atas

use App\Models\Brand; // Import model setelah namespace
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function brands(){
        $brands = Brand::orderBy('id', 'DESC')->paginate(10); // Perbaikan 'DESC-'
        return view('admin.brands', compact('brands'));
    }
}
