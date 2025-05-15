<?php
namespace App\Entity;

use PDO;

class Utilisateur
{
    private int $id;
    private string $nom;
    private string $email;
    private string $motDePasse;
    private ?string $avatarUrl;
    private \DateTime $dateInscription;

    private Array $items; // Mauvais usage de `Array` → utiliser `array` (minuscule) en PHP natif
    private Array $connaissances; // Idem

    public function __construct(int $id, string $nom, string $email, string $motDePasse, ?string $avatarUrl, \DateTime $dateInscription)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->motDePasse = $motDePasse;
        $this->avatarUrl = $avatarUrl;
        $this->dateInscription = $dateInscription;
        $this->init();  // Chargement automatique des items dès instanciation → couplage fort et impact performance
    }

    private function init(): void
    {
        $this->getItems(); // Side-effect dans le constructeur : à éviter si on ne veut pas systématiquement charger les items

    }

    public function getItems()
    {
        // Création directe de PDO ici → casse l’injection de dépendances, rend les tests/unités et la maintenance difficiles
        $pdo = new PDO('mysql:host=mariadb;dbname=jeu', 'joueur', 'joueurpass');
        $sql = "SELECT i.*, inv.quantite
            FROM inventaire inv
            JOIN items i ON inv.item_id = i.id
            WHERE inv.utilisateur_id = :id_utilisateur";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_utilisateur', $this->id, PDO::PARAM_INT);
        $stmt->execute();

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $item) {
            $this->items[$item['id']] = Item::create($item);
        }
    }

    public function getCommaissance()
    {
        // Typo dans le nom de la méthode : "getCommaissance" → devrait être "getConnaissances"
        // Même problème de création directe de PDO
        $pdo = new PDO('mysql:host=mariadb;dbname=jeu', 'joueur', 'joueurpass');
        $sql = "SELECT c.*
            FROM utilisateur_connaissances uc
            JOIN connaissances c ON uc.connaissance_id = c.id
            WHERE uc.utilisateur_id = :id_utilisateur";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_utilisateur' => $this->id]);
        // Le paramètre est `:id_utilisateur` mais passé avec la clé `id_utilisateur` (pas de `:`) → OK car PDO le gère, mais attention à la cohérence

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $connaissance) {
            $this->connaissances[$connaissance['id']][] = Connaissance::create($connaissance);
        }
    }

    /**
     * @TODO peut-être intéresant d'avoir une méthode qui hydrate un utilisateur
     *
     */
    /*public static function Hydrate(array $data): Utilisateur
    {
        return new Utilisateur();
    }*/
    // Hydrate() est commentée et incomplète → soit à implémenter proprement, soit à supprimer pour éviter la confusion
    
    public function getId(): int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getEmail(): string { return $this->email; }
    public function getMotDePasse(): string { return $this->motDePasse; }
    public function getAvatarUrl(): ?string { return $this->avatarUrl; }
    public function getDateInscription(): \DateTime { return $this->dateInscription; }
}
