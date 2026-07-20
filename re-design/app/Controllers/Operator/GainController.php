<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Models\TransactionsModel;
use App\Models\TypeOperationsModel;
use App\Models\OperateursModel;

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
        $gainRetrait   = $this->transactionsModel->getGainByType(TypeOperationsModel::TYPE_RETRAIT, $dateDebut, $dateFin);
        
        // Séparation des gains de transfert en interne et externe
        $gainTransfertInterne   = $this->transactionsModel->getGainByType(TypeOperationsModel::TYPE_TRANSFERT, $dateDebut, $dateFin, 1);
        $gainTransfertExterne   = $this->transactionsModel->getGainByType(TypeOperationsModel::TYPE_TRANSFERT, $dateDebut, $dateFin, 0);
        $gainTransfertTotal     = $gainTransfertInterne + $gainTransfertExterne;
        
        $operations    = $this->typeOperationsModel->findAll();
        $transactions  = $this->transactionsModel->getTransactionsFiltrees($dateDebut, $dateFin);
        
        // Montants à envoyer par opérateur
        $montantsParOperateur = $this->transactionsModel->getMontantsParOperateur($dateDebut, $dateFin);
        
        // Récupérer les détails des opérateurs pour affichage
        $operateurs = $this->operateursModel->findAll();
        $operateursMap = [];
        foreach ($operateurs as $operateur) {
            $operateursMap[$operateur['id']] = $operateur;
        }

        return view('operator/gains', [
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
            'retrait'           => $this->transactionsModel->getGainByType(TypeOperationsModel::TYPE_RETRAIT, $dateDebut, $dateFin),
            'transfertInterne'  => $this->transactionsModel->getGainByType(TypeOperationsModel::TYPE_TRANSFERT, $dateDebut, $dateFin, 1),
            'transfertExterne'  => $this->transactionsModel->getGainByType(TypeOperationsModel::TYPE_TRANSFERT, $dateDebut, $dateFin, 0),
        ];

        return $this->response->setJSON([
            'totalGain'  => $totalGain,
            'gainByType' => $gainByType,
        ]);
    }
}