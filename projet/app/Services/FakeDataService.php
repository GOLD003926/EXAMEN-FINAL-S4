<?php

namespace App\Services;

class FakeDataService
{
    // Fake prefixes data
    public function getPrefixes()
    {
        return [
            ['id' => 1, 'codes' => '033', 'descriptions' => 'Telma'],
            ['id' => 2, 'codes' => '037', 'descriptions' => 'Orange'],
        ];
    }

    // Fake operation types data
    public function getTypeOperations()
    {
        return [
            ['id' => 1, 'codes' => 'DEP', 'libelle' => 'Dépôt', 'descriptions' => 'Dépôt d\'argent'],
            ['id' => 2, 'codes' => 'RET', 'libelle' => 'Retrait', 'descriptions' => 'Retrait d\'argent'],
            ['id' => 3, 'codes' => 'TRF', 'libelle' => 'Transfert', 'descriptions' => 'Transfert d\'argent'],
        ];
    }

    // Fake fee schedule based on the image
    public function getFraisOperations()
    {
        return [
            ['id' => 1, 'id_type_operation' => 2, 'somme_min' => 100, 'somme_max' => 1000, 'frais' => 50, 'descriptions' => 'Frais retrait 100-1000 Ar'],
            ['id' => 2, 'id_type_operation' => 2, 'somme_min' => 1001, 'somme_max' => 5000, 'frais' => 50, 'descriptions' => 'Frais retrait 1001-5000 Ar'],
            ['id' => 3, 'id_type_operation' => 2, 'somme_min' => 5001, 'somme_max' => 10000, 'frais' => 100, 'descriptions' => 'Frais retrait 5001-10000 Ar'],
            ['id' => 4, 'id_type_operation' => 2, 'somme_min' => 10001, 'somme_max' => 25000, 'frais' => 200, 'descriptions' => 'Frais retrait 10001-25000 Ar'],
            ['id' => 5, 'id_type_operation' => 2, 'somme_min' => 25001, 'somme_max' => 50000, 'frais' => 400, 'descriptions' => 'Frais retrait 25001-50000 Ar'],
            ['id' => 6, 'id_type_operation' => 2, 'somme_min' => 50001, 'somme_max' => 100000, 'frais' => 800, 'descriptions' => 'Frais retrait 50001-100000 Ar'],
            ['id' => 7, 'id_type_operation' => 2, 'somme_min' => 100001, 'somme_max' => 250000, 'frais' => 1500, 'descriptions' => 'Frais retrait 100001-250000 Ar'],
            ['id' => 8, 'id_type_operation' => 2, 'somme_min' => 250001, 'somme_max' => 500000, 'frais' => 1500, 'descriptions' => 'Frais retrait 250001-500000 Ar'],
            ['id' => 9, 'id_type_operation' => 2, 'somme_min' => 500001, 'somme_max' => 1000000, 'frais' => 2500, 'descriptions' => 'Frais retrait 500001-1000000 Ar'],
            ['id' => 10, 'id_type_operation' => 2, 'somme_min' => 1000001, 'somme_max' => 2000000, 'frais' => 3000, 'descriptions' => 'Frais retrait 1000001-2000000 Ar'],
            ['id' => 11, 'id_type_operation' => 3, 'somme_min' => 100, 'somme_max' => 1000, 'frais' => 50, 'descriptions' => 'Frais transfert 100-1000 Ar'],
            ['id' => 12, 'id_type_operation' => 3, 'somme_min' => 1001, 'somme_max' => 5000, 'frais' => 50, 'descriptions' => 'Frais transfert 1001-5000 Ar'],
            ['id' => 13, 'id_type_operation' => 3, 'somme_min' => 5001, 'somme_max' => 10000, 'frais' => 100, 'descriptions' => 'Frais transfert 5001-10000 Ar'],
            ['id' => 14, 'id_type_operation' => 3, 'somme_min' => 10001, 'somme_max' => 25000, 'frais' => 200, 'descriptions' => 'Frais transfert 10001-25000 Ar'],
            ['id' => 15, 'id_type_operation' => 3, 'somme_min' => 25001, 'somme_max' => 50000, 'frais' => 400, 'descriptions' => 'Frais transfert 25001-50000 Ar'],
            ['id' => 16, 'id_type_operation' => 3, 'somme_min' => 50001, 'somme_max' => 100000, 'frais' => 800, 'descriptions' => 'Frais transfert 50001-100000 Ar'],
            ['id' => 17, 'id_type_operation' => 3, 'somme_min' => 100001, 'somme_max' => 250000, 'frais' => 1500, 'descriptions' => 'Frais transfert 100001-250000 Ar'],
            ['id' => 18, 'id_type_operation' => 3, 'somme_min' => 250001, 'somme_max' => 500000, 'frais' => 1500, 'descriptions' => 'Frais transfert 250001-500000 Ar'],
            ['id' => 19, 'id_type_operation' => 3, 'somme_min' => 500001, 'somme_max' => 1000000, 'frais' => 2500, 'descriptions' => 'Frais transfert 500001-1000000 Ar'],
            ['id' => 20, 'id_type_operation' => 3, 'somme_min' => 1000001, 'somme_max' => 2000000, 'frais' => 3000, 'descriptions' => 'Frais transfert 1000001-2000000 Ar'],
        ];
    }

    // Fake client accounts data
    public function getComptes()
    {
        return [
            ['id' => 1, 'numero' => '0331234567', 'nom' => 'Rakoto', 'prenom' => 'Jean', 'id_etat' => 1, 'solde' => 500000, 'update_at' => '2024-01-15'],
            ['id' => 2, 'numero' => '0377654321', 'nom' => 'Rasoa', 'prenom' => 'Marie', 'id_etat' => 1, 'solde' => 750000, 'update_at' => '2024-01-16'],
            ['id' => 3, 'numero' => '0339876543', 'nom' => 'Randria', 'prenom' => 'Paul', 'id_etat' => 1, 'solde' => 250000, 'update_at' => '2024-01-17'],
            ['id' => 4, 'numero' => '0371234567', 'nom' => 'Andriamanitra', 'prenom' => 'Lucie', 'id_etat' => 2, 'solde' => 100000, 'update_at' => '2024-01-18'],
            ['id' => 5, 'numero' => '0334567890', 'nom' => 'Rabe', 'prenom' => 'Pierre', 'id_etat' => 1, 'solde' => 1500000, 'update_at' => '2024-01-19'],
        ];
    }

    // Fake account states
    public function getEtatsCompte()
    {
        return [
            ['id' => 1, 'codes' => 'ACTIF', 'libelle' => 'Actif', 'descriptions' => 'Compte actif'],
            ['id' => 2, 'codes' => 'BLOQUE', 'libelle' => 'Bloqué', 'descriptions' => 'Compte bloqué'],
            ['id' => 3, 'codes' => 'SUSPENDU', 'libelle' => 'Suspendu', 'descriptions' => 'Compte suspendu'],
        ];
    }

    // Fake transactions data
    public function getTransactions($numero = null)
    {
        $transactions = [
            ['id' => 1, 'id_compte' => 1, 'id_type_operation' => 1, 'numero_source' => '0331234567', 'numero_destinataire' => null, 'somme' => 100000, 'gain' => 0, 'created_at' => '2024-01-15 10:30:00'],
            ['id' => 2, 'id_compte' => 1, 'id_type_operation' => 2, 'numero_source' => '0331234567', 'numero_destinataire' => null, 'somme' => 50000, 'gain' => 400, 'created_at' => '2024-01-15 14:20:00'],
            ['id' => 3, 'id_compte' => 1, 'id_type_operation' => 3, 'numero_source' => '0331234567', 'numero_destinataire' => '0377654321', 'somme' => 75000, 'gain' => 400, 'created_at' => '2024-01-16 09:15:00'],
            ['id' => 4, 'id_compte' => 2, 'id_type_operation' => 1, 'numero_source' => '0377654321', 'numero_destinataire' => null, 'somme' => 200000, 'gain' => 0, 'created_at' => '2024-01-16 11:00:00'],
            ['id' => 5, 'id_compte' => 2, 'id_type_operation' => 3, 'numero_source' => '0377654321', 'numero_destinataire' => '0339876543', 'somme' => 150000, 'gain' => 800, 'created_at' => '2024-01-17 16:45:00'],
        ];

        if ($numero) {
            return array_filter($transactions, function($t) use ($numero) {
                return $t['numero_source'] === $numero || $t['numero_destinataire'] === $numero;
            });
        }

        return $transactions;
    }

    // Get account balance by phone number
    public function getSolde($numero)
    {
        $comptes = $this->getComptes();
        foreach ($comptes as $compte) {
            if ($compte['numero'] === $numero) {
                return $compte['solde'];
            }
        }
        return 0;
    }

    // Calculate gain from fees
    public function getTotalGain()
    {
        $transactions = $this->getTransactions();
        $totalGain = 0;
        foreach ($transactions as $transaction) {
            $totalGain += $transaction['gain'];
        }
        return $totalGain;
    }

    // Get gain by operation type
    public function getGainByType($typeOperationId)
    {
        $transactions = $this->getTransactions();
        $totalGain = 0;
        foreach ($transactions as $transaction) {
            if ($transaction['id_type_operation'] == $typeOperationId) {
                $totalGain += $transaction['gain'];
            }
        }
        return $totalGain;
    }

    // Calculate fee based on amount and operation type
    public function calculateFee($amount, $typeOperationId)
    {
        $frais = $this->getFraisOperations();
        foreach ($frais as $fra) {
            if ($fra['id_type_operation'] == $typeOperationId && 
                $amount >= $fra['somme_min'] && 
                $amount <= $fra['somme_max']) {
                return $fra['frais'];
            }
        }
        return 0;
    }

    // Fake operator users data
    public function getOperatorUsers()
    {
        return [
            ['id' => 1, 'username' => 'admin', 'password' => 'admin123', 'nom' => 'Admin', 'prenom' => 'Principal', 'role' => 'admin'],
            ['id' => 2, 'username' => 'manager', 'password' => 'manager123', 'nom' => 'Manager', 'prenom' => 'Système', 'role' => 'manager'],
            ['id' => 3, 'username' => 'supervisor', 'password' => 'super123', 'nom' => 'Superviseur', 'prenom' => 'Opérations', 'role' => 'supervisor'],
        ];
    }

    // Validate operator login
    public function validateOperatorLogin($username, $password)
    {
        $users = $this->getOperatorUsers();
        foreach ($users as $user) {
            if ($user['username'] === $username && $user['password'] === $password) {
                return $user;
            }
        }
        return null;
    }
}
