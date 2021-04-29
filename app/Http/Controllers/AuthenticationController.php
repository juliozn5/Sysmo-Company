<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
  // Login v1
  public function login()
  {
    $pageConfigs = ['blankPage' => true];

    return view('/auth/login', ['pageConfigs' => $pageConfigs]);
  }

  // Register v1
  public function register()
  {
    $pageConfigs = ['blankPage' => true];

    return view('/auth/login', ['pageConfigs' => $pageConfigs]);
  }

  // Forgot Password v1
  public function forgot_password()
  {
    $pageConfigs = ['blankPage' => true];

    return view('/auth/passwords/reset', ['pageConfigs' => $pageConfigs]);
  }

}
