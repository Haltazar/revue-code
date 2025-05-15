<?php

namespace App\Auth;

use PDO;

class LoginManager
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login(string $username, string $password): bool
    {
        $stmt = $this->pdo->prepare("SELECT id, username, password_hash FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // En cas d'échec, aucune temporisation → vulnérable aux attaques par bruteforce
        // Recommandé : ajouter un `sleep(1)` ou système de rate limiting

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        }

        return false;
    }

    public function isAuthenticated(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
    }

    public function getCurrentUser(): ?string
    {
        return $_SESSION['username'] ?? null;
    }
}