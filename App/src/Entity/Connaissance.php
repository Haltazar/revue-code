<?php
namespace App\Entity;

class Connaissance
{
    public function __construct(private int $id,private string $titre,private string $contenu)
    { }

    public function getId(): int { return $this->id; }
    public function getTitre(): string { return $this->titre; }
    public function getContenu(): string { return $this->contenu; }



    public static function create(array $connaissance): self
    {
        return new self($connaissance['id'], $connaissance['titre'], $connaissance['contenu']);

        // Pas de validation ici → suppose que toutes les clés existent et sont valides
        // Suggestion : vérifier l'existence des clés, ou typer `$connaissance` plus strictement avec un DTO / ValueObject
    }
}
