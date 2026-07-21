<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LogoutController extends BaseController
{
    public function index()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
