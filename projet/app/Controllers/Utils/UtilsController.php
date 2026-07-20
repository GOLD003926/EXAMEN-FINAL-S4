<?php

namespace App\Controllers\Utils;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UtilsController extends BaseController
{
    public function index()
    {
        //
    }
    public function getPrefixes()
    {
        $prefixes = [
            '033',
            '037',
        ];

        return $this->response->setJSON(['prefixes' => $prefixes]);
    }
}
