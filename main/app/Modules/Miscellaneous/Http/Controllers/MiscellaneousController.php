<?php

namespace App\Modules\Miscellaneous\Http\Controllers;

use Illuminate\Routing\Controller;

class MiscellaneousController extends Controller
{

  public function index()
  {
    return view('miscellaneous::index');
  }
}
