<?php
namespace App\Entity;

class Item
{
    private int $id;
    private string $nom;
    private ?string $description;
    private string $type;
    private int $valeur;

    public function __construct(int $id, string $nom, ?string $description, string $type, int $valeur)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
        $this->type = $type;
        $this->valeur = $valeur;
    }

    public function getId(): int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getDescription(): ?string { return $this->description; }
    public function getType(): string { return $this->type; }
    public function getValeur(): int { return $this->valeur; }

    public static function create(array $item): self
    {
        return new self($item['id'], $item['nom'], $item['description'], $item['type'], $item['valeur']);

        // Pas de vérification sur les clés → crash possible si une clé est absente
        // Suggestion : ajouter un contrôle ou une version "safeCreate" si la source est externe
    }
}

