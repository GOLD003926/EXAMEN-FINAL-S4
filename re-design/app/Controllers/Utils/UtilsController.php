<?php

namespace App\Controllers\Utils;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UtilsController extends BaseController
{
    public function index()
    {
        // Méthode vide pour utilités futures
    }
    public function getPrefixes()
    {
        $prefixes = [
            '02022',
            '032',
            '033',
            '034',
            '037',
            '038'
        ];

        return $this->response->setJSON(['prefixes' => $prefixes]);
    }
}
