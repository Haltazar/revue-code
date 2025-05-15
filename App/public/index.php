<?php

use App\Auth\LoginManager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . '/../vendor/autoload.php';

$pdo = new PDO('mysql:host=mariadb;dbname=jeu', 'joueur', 'joueurpass');
// Identifiants en dur → à externaliser via .env ou config sécurisée

if (!(new LoginManager($pdo))->isAuthenticated()) {
    header("location: login.php");
   // Manque un exit; ou die(); après le header → le script continue sinon
}

$loader = new FilesystemLoader(__DIR__ . '/../templates');

$twig = new Environment($loader, [
    'cache' => false,
    // En production, le cache devrait être activé pour améliorer les performances
]);

$data = [
    'titre' => 'Bienvenue sur mon site',
    'message' => "Lors d’une revue de code, le développeur doit vérifier la clarté du code, le respect des conventions de nomage et la cohérence dans l’usage des structures. Il est important de détecter les duplications inutiles et de s’assurer que les fonctions sont bien découpés. La gestion des erreurs et les tests associés doivent également être examinés. On veillera à l'absence de données sensibles dans le dépôt et à la pertinance des commentaires. Enfin, l’impact des modifications sur les performances ou la sécurité ne doit pas être négligé.",
];

echo $twig->render('home.html.twig', $data);
