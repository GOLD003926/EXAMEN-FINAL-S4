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
            '034',
            '038',
            '032',
            '037',
            '033',
            '031',
            '+261'
        ];

        return $this->response->setJSON(['prefixes' => $prefixes]);
    }
}
