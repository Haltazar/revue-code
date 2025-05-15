<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Auth\LoginManager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Connexion PDO
$pdo = new PDO('mysql:host=mariadb;dbname=jeu', 'joueur', 'joueurpass');
// Identifiants en dur → à sécuriser via .env + phpdotenv par exemple

// Initialisation de Twig
$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader, ['cache' => false]);
// En prod, penser à activer le cache Twig pour les performances

// Gestion du login
$auth = new LoginManager($pdo);
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Manque de validation côté serveur (ex : longueur minimale, protection contre les injections basiques)
    // Possibilité d’ajouter un `trim()` sur les entrées pour éviter les espaces parasites

    if ($auth->login($username, $password)) {
        header('Location: dashboard.php'); // redirection en cas de succès
        exit;
    } else {
        $error = "Identifiants incorrects.";
    }
}

// Affichage du formulaire (avec éventuelle erreur)
echo $twig->render('login.html.twig', [
    'error' => $error
]);
