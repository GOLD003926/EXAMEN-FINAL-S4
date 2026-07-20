<?php
// Simulation d'une base de données avec des données d'exemple
// Ce fichier sert de source de données pour les démos d'import/export

return [
    // Table des étudiants
    'students' => [
        ['id' => 1, 'nom' => 'Dupont', 'prenom' => 'Jean', 'classe' => 'L1', 'moyenne' => 14.5, 'statut' => 'Admis'],
        ['id' => 2, 'nom' => 'Martin', 'prenom' => 'Marie', 'classe' => 'L2', 'moyenne' => 16.2, 'statut' => 'Admis'],
        ['id' => 3, 'nom' => 'Bernard', 'prenom' => 'Pierre', 'classe' => 'L1', 'moyenne' => 9.5, 'statut' => 'Ajourné'],
        ['id' => 4, 'nom' => 'Petit', 'prenom' => 'Sophie', 'classe' => 'L3', 'moyenne' => 17.8, 'statut' => 'Admis'],
        ['id' => 5, 'nom' => 'Robert', 'prenom' => 'Luc', 'classe' => 'L2', 'moyenne' => 11.3, 'statut' => 'Admis'],
        ['id' => 6, 'nom' => 'Richard', 'prenom' => 'Emma', 'classe' => 'L1', 'moyenne' => 8.9, 'statut' => 'Ajourné'],
        ['id' => 7, 'nom' => 'Durand', 'prenom' => 'Thomas', 'classe' => 'L3', 'moyenne' => 15.7, 'statut' => 'Admis'],
        ['id' => 8, 'nom' => 'Lefebvre', 'prenom' => 'Chloe', 'classe' => 'L2', 'moyenne' => 12.4, 'statut' => 'Admis'],
        ['id' => 9, 'nom' => 'Moreau', 'prenom' => 'Hugo', 'classe' => 'L1', 'moyenne' => 10.1, 'statut' => 'Admis'],
        ['id' => 10, 'nom' => 'Simon', 'prenom' => 'Léa', 'classe' => 'L3', 'moyenne' => 18.5, 'statut' => 'Admis'],
    ],
    
    // Table des produits
    'products' => [
        ['id' => 1, 'nom' => 'iPhone 15', 'categorie' => 'electronique', 'prix' => 999, 'stock' => 25],
        ['id' => 2, 'nom' => 'MacBook Pro', 'categorie' => 'electronique', 'prix' => 2499, 'stock' => 10],
        ['id' => 3, 'nom' => 'T-shirt Nike', 'categorie' => 'vetements', 'prix' => 35, 'stock' => 150],
        ['id' => 4, 'nom' => 'Jean Levi\'s', 'categorie' => 'vetements', 'prix' => 89, 'stock' => 75],
        ['id' => 5, 'nom' => 'Pommes', 'categorie' => 'alimentaire', 'prix' => 3.5, 'stock' => 200],
        ['id' => 6, 'nom' => 'Lait', 'categorie' => 'alimentaire', 'prix' => 1.2, 'stock' => 500],
        ['id' => 7, 'nom' => 'Lampe LED', 'categorie' => 'maison', 'prix' => 29, 'stock' => 80],
        ['id' => 8, 'nom' => 'Canapé', 'categorie' => 'maison', 'prix' => 599, 'stock' => 5],
        ['id' => 9, 'nom' => 'Samsung Galaxy', 'categorie' => 'electronique', 'prix' => 799, 'stock' => 30],
        ['id' => 10, 'nom' => 'Robe', 'categorie' => 'vetements', 'prix' => 65, 'stock' => 45],
    ],
    
    // Table des employés
    'employees' => [
        ['id' => 1, 'nom' => 'Alice', 'prenom' => 'Design', 'departement' => 'design', 'statut' => 'active', 'role' => 'UI Designer'],
        ['id' => 2, 'nom' => 'Bob', 'prenom' => 'Dev', 'departement' => 'dev', 'statut' => 'active', 'role' => 'Développeur Front'],
        ['id' => 3, 'nom' => 'Charlie', 'prenom' => 'Market', 'departement' => 'marketing', 'statut' => 'active', 'role' => 'CM'],
        ['id' => 4, 'nom' => 'Diana', 'prenom' => 'HR', 'departement' => 'rh', 'statut' => 'inactive', 'role' => 'RH Manager'],
        ['id' => 5, 'nom' => 'Eve', 'prenom' => 'Back', 'departement' => 'dev', 'statut' => 'active', 'role' => 'Développeur Back'],
        ['id' => 6, 'nom' => 'Frank', 'prenom' => 'UX', 'departement' => 'design', 'statut' => 'active', 'role' => 'UX Designer'],
        ['id' => 7, 'nom' => 'Grace', 'prenom' => 'SEO', 'departement' => 'marketing', 'statut' => 'inactive', 'role' => 'SEO Expert'],
        ['id' => 8, 'nom' => 'Henry', 'prenom' => 'Recrut', 'departement' => 'rh', 'statut' => 'active', 'role' => 'Recruteur'],
    ],
];
