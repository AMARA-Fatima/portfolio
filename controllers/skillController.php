<?php

require_once(__DIR__ . "/../configuration/conf.php");
require_once(__DIR__ . "/../models/pictureModel.php");
require_once(__DIR__ . "/../models/skillModel.php");
require_once(__DIR__ . "/../models/skillModel.php");
require_once(__DIR__ . "/../models/projectModel.php");

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
        foreach ($result as $skill) {
            $this->loadProjectsFromSkill($skill);
        }
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

        $skill = $statement->fetch();

        $this->loadProjectsFromSkill($skill);
        return $skill;
    }

    public function loadProjectsFromSkill(SkillModel $skill)
    {
        global $pdo;
        $sql = "SELECT project.`id_project`, project.`name`
                FROM project
                INNER JOIN skill_project
                ON skill_project.`id_project` = project.`id_project`
                INNER JOIN skill 
                ON skill.`id_skill` = skill_project.`id_skill`
                WHERE skill.`id_skill` = :id
                ";

        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id", $skill->id_skill, PDO::PARAM_INT);
        $statement->execute();

        $skill->projects = $statement->fetchAll(PDO::FETCH_CLASS, "ProjectModel");
    }

    public function createSkill(string $name, int $level, array $picture)
    {
        if(strlen($name) > 255)
        {
            return 
            [
            "success" => true,
            "message" => "Le nom doit contenir 255 caractère maximum"
            ];
        }

        if($level < 1 || $level > 5)
        {
            return 
            [
            "success" => false,
            "message" => "Le niveau doit entre 1 et 5"
            ];
        }

        if(!in_array($picture["type"], ["image/png", "image/jpeg", "image/webp"]))
        {
            return 
            [
            "success" => false,
            "message" => "Format d'image accépté png, jpeg, webp"
            ];
        }

        // les information sont correctes : stockons l'image
        $image_name = time() . $picture["name"];

        move_uploaded_file($picture["tmp_name"], __DIR__ . "/../assets/img/competences/" . $image_name);

        Global $pdo;

        $sql = "INSERT INTO skill (
                                    name, 
                                    level,
                                    picture
                                    )
                    VALUE (
                            :name,
                            :level,
                            :picture
                            )
                ";

        $statement = $pdo->prepare($sql);

        $statement->bindParam(":name", $name);
        $statement->bindParam(":level", $level);
        $statement->bindParam(":picture", $image_name);

        $statement->execute();

        // Renvoi d'un tableau associatif permettant de connaître le succès ou non de la méthode
        return [
            "success" => true,
            "message" => "La competence . $name . a été créé"
        ];

    }

    public function updateSkill(int $id_skill, string $name, int $level, array $picture)
    {
        if(strlen($name)> 255)
        {
            return [
                "success" => false,
                "message" => "Le nom doit contenir 255 caractère"
            ];
        }
        if($level < 1 || $level > 5)
        {
            return [
                "success" => false,
                "message" => "Le niveau doit être compris entre 1 et 5"
            ];
        }

        if(!in_array($picture["type"],["image/png", "image/jpeg", "image/webp"]))
        {
            return [
                "success" => false,
                "message" => "Formats d'image acceptés :  Png, Jpeg, Webp"
            ];
        }

        // Les informations sont correctes : stockons l'image en lui attribuant un nouveau nom unique
        $image_name = time() . $picture["name"];
        move_uploaded_file($picture["tmp_name"], __DIR__ . "/../assets/img/skills/" . $image_name);
            
         // L'image a bien été stockée, exécutons la requête pour ajouter la compétence
        global $pdo;

        $sql = "UPDATE skill 
                SET  name =:name, 
                level = :level, 
                picture = :picture
                WHERE id_skill = :id_skill
                ";
                

        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id_skill", $id_skill);
        $statement->bindParam(":name", $name);
        $statement->bindParam(":level", $level);
        $statement->bindParam(":picture", $image_name);

        $statement->execute();


        return [
            "success" => true,
            "message" => "La compétence a été modifiée"
        ];
    }

}
