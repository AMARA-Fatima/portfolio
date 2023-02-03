<?php

class SkillModel 
{
    // TODO: ajouter ici les propriété de la table dans la base de donnée 
    public int $id_skill;
    public string $name;
    public int $level;
    public ?string $picture;
    public ?array $projects;
}
?>