<?php

require_once("./configuration/conf.php");
require_once("./models/skillModel.php");

class SkillController 
{
    // TODO: créer les methodes permettant de récupérer les skills (reaAll()..)
    public function readAll(): array
    {
        global $pdo;

        $sql = "SELECT *
                FROM skill
                ";
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_CLASS, "SkillModel");
        return $result;
    }
    public function readOne($id): SkillModel
    {
        global $pdo;
        $sql = "SELECT *
                FROM skill 
                WHERE id_skill = :id
                ";
        
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $statement->setFetchMode(PDO::FETCH_CLASS, 'SkillModel');

        $competence = $statement->fetch();
        return $competence;
    }
}

?>