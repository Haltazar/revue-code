<?php

declare(strict_types=1); 

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\DashboardController;

// Connexion à la BDD (à adapter selon ton .env ou config)
$pdo = new PDO('mysql:host=db;dbname=jeu;charset=utf8mb4', 'joueur', 'joueurpass', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
// les identifiants sont en clair dans le code
// idéalement utiliser des variables d’environnement (.env)

// Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($loader);
// En production, le cache devrait être activé pour améliorer les performances


// Appel du contrôleur
$controller = new DashboardController($pdo, $twig); 
$controller->index();
