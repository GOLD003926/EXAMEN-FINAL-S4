<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Models\TransactionsModel;
use App\Models\TypeOperationsModel;
use App\Models\OperateursModel;

// SUPPOSITION: TransactionsModel a les méthodes:
// - getGainByType($typeId, $dateDebut, $dateFin, $estInterne) : avec filtre interne/externe pour transferts
// - getMontantsParOperateur($dateDebut, $dateFin) : SUM(montant + commission) groupé par id_operateur_destinataire

class GainController extends BaseController
{
    private TransactionsModel $transactionsModel;
    private TypeOperationsModel $typeOperationsModel;
    private OperateursModel $operateursModel;

    public function __construct()
    {
        $this->transactionsModel   = new TransactionsModel();
        $this->typeOperationsModel = new TypeOperationsModel();
        $this->operateursModel    = new OperateursModel();
    }

    public function index()
    {
        $dateDebut = $this->request->getGet('date_debut');
        $dateFin   = $this->request->getGet('date_fin');

        // Gains totaux
        $totalGain     = $this->transactionsModel->getTotalGain($dateDebut, $dateFin);
        $gainRetrait   = $this->transactionsModel->getGainByType(2, $dateDebut, $dateFin); // Type 2 = Retrait
        
        // SUPPOSITION: getGainByType accepte un 4ème paramètre pour filtrer interne/externe (null = tous)
        // Séparation des gains de transfert en interne et externe
        $gainTransfertInterne   = $this->transactionsModel->getGainByType(3, $dateDebut, $dateFin, 1); // Transferts internes
        $gainTransfertExterne   = $this->transactionsModel->getGainByType(3, $dateDebut, $dateFin, 0); // Transferts externes
        $gainTransfertTotal     = $gainTransfertInterne + $gainTransfertExterne;
        
        $operations    = $this->typeOperationsModel->findAll();
        $transactions  = $this->transactionsModel->getTransactionsFiltrees($dateDebut, $dateFin);
        
        // SUPPOSITION: getMontantsParOperateur retourne les montants à envoyer par opérateur
        $montantsParOperateur = $this->transactionsModel->getMontantsParOperateur($dateDebut, $dateFin);
        
        // Récupérer les détails des opérateurs pour affichage
        $operateurs = $this->operateursModel->findAll();
        $operateursMap = [];
        foreach ($operateurs as $operateur) {
            $operateursMap[$operateur['id']] = $operateur;
        }

        return view('operator/gain', [
            'totalGain'              => $totalGain,
            'gainRetrait'            => $gainRetrait,
            'gainTransfertInterne'   => $gainTransfertInterne,
            'gainTransfertExterne'   => $gainTransfertExterne,
            'gainTransfertTotal'     => $gainTransfertTotal,
            'operations'             => $operations,
            'transactions'           => $transactions,
            'montantsParOperateur'   => $montantsParOperateur,
            'operateursMap'          => $operateursMap,
            'dateDebut'              => $dateDebut,
            'dateFin'                => $dateFin,
        ]);
    }

    public function getGainStats()
    {
        $dateDebut = $this->request->getGet('date_debut');
        $dateFin   = $this->request->getGet('date_fin');

        $totalGain = $this->transactionsModel->getTotalGain($dateDebut, $dateFin);
        
        // Séparation des gains de transfert
        $gainByType = [
            'retrait'           => $this->transactionsModel->getGainByType(2, $dateDebut, $dateFin),
            'transfertInterne'  => $this->transactionsModel->getGainByType(3, $dateDebut, $dateFin, 1),
            'transfertExterne'  => $this->transactionsModel->getGainByType(3, $dateDebut, $dateFin, 0),
        ];

        return $this->response->setJSON([
            'totalGain'  => $totalGain,
            'gainByType' => $gainByType,
        ]);
    }
}