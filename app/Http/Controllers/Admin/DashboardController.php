<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function dashboard()
   {
      return view('admin.dashboard');
   }

    public function user_list()
   {
      return view('admin.dashboard');
   }


}
