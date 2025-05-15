<?php
namespace App\Controller;

use App\Entity\Utilisateur;
use PDO;
use Twig\Environment;

class DashboardController
{
    private PDO $pdo;
    private Environment $twig;

    public function __construct(PDO $pdo, Environment $twig)
    {
        $this->pdo = $pdo;
        $this->twig = $twig;
    }

    public function index(): void
    {
        $sql = "SELECT id, nom, email, avatar_url, date_inscription FROM utilisateurs ORDER BY date_inscription DESC";
        $stmt = $this->pdo->query($sql);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user) {
            $utilisateurs[] = new Utilisateur($user['id'], $user['nom'], $user['email'], '', $user['avatar_url'], $user['date_inscription']);
        }
        // Le mot de passe est passé en vide → attention si l'objet Utilisateur l'attend obligatoirement ou l'utilise

        // Affichage via Twig
        echo $this->twig->render('dashboard.html.twig', [
            'utilisateurs' => $utilisateurs
        ]);
    }
}