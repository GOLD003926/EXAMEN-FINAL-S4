<?php

namespace App\Controllers\Epargne;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\EpargneModel;
use App\Models\ComptesModel;

class EpargneController extends BaseController
{
    private EpargneModel $epargneModel;
    private ComptesModel $comptesModel;

    public function __construct()
    {
        $this->epargneModel = new EpargneModel();
        $this->comptesModel = new ComptesModel();
    }

    public function index()
    {
        helper('url');
        $epargne = $this->epargneModel->firstByNum(session('numero'))['taux'];
        return view('epargne', [
            'epargneActuelle' => $epargne
        ]);
    }
    public function epargner()
    {
        // mon numero (client en ligne)
        $taux = $this->request->getPost('taux');
        $numero = session('numero');
        $id_compte = $this->comptesModel->getCompteByNumero($numero);
        $this->epargneModel->updateTauxEpargne($id_compte['id'], $taux);
    }
}
