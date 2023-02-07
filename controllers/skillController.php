<?php

require_once("../configuration/conf.php");
require_once("../models/pictureModel.php");
require_once("../models/skillModel.php");

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

    // public function createSkill(string $name, int $level, $picture)
    // {   
    //     // var_dump($_POST);
    //     // var_dump($_FILES);
    //     // gestion de l'image 
    //     if(isset($_FILES["picture"]["tmp_name"]))
    //     {
    //         $tmp_Name = $_FILES['picture']['tmp_name'];

    //         $fichierExtention = explode('.', $name);

    //         $extention = strtolower(end($fichierExtention));

    //         $extentionAutorise = ['jpg', 'jpeg', 'git', 'png'];

    //         if(in_array($extention, $extentionAutorise))
    //         {
    //             $uniqueName = uniqid('', true);

    //             $filesName = $uniqueName . '.' . $extention;

    //             var_dump($filesName);

    //             move_uploaded_file($tmp_Name, './assets/img/competences/' . $filesName);

    //             $_SESSION['message'] = "Vous avez créé une competence . $name ";
    //         }
    //         else 
    //         {
    //             echo 'mauvaise extention';
    //         }
    //     }

    //     $name = addslashes(trim(ucfirst($_POST["name"])));
    //     $level = addslashes(trim(ucfirst($_POST["level"])));

    //     global $pdo;

    //     // var_dump($picture["type"]);

        // 2. préparation de l'ecriture SQL :
        // $sql = "INSERT INTO skill (
        //                             name, 
        //                             level,
        //                             picture
        //                         )
        //             VALUE (
        //                     :name,
        //                     :level,
        //                     :picture
        //                 )
        //             ";
        // $statement = $pdo->prepare($sql);
        // $statement->bindParam(":name", $name);
        // $statement->bindParam(":level", $level);
        // $statement->bindParam(":picture", $picture);

        // $statement->execute();

        // // Renvoi d'un tableau associatif permettant de connaître le succès ou non de la méthode
        // return [
        //     "success" => true,
        //     "message" => "La competence a été créé"
        // ];
    // }

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
}
