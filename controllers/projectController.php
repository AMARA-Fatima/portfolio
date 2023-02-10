<?php
require_once(__DIR__ . "/../configuration/conf.php");
require_once(__DIR__ . "/../models/projectModel.php");
require_once(__DIR__ . "/../models/pictureModel.php");
require_once(__DIR__ . "/../models/skillModel.php");

class ProjectController
{
    public function readAll(): array
    {
        global $pdo;

        $sql = "SELECT * 
                FROM project";

        $statement = $pdo->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_CLASS, "ProjectModel");

        foreach ($result as $project) {
            $this->loadSkillsFromProject($project);
        }
        return $result;
    }

    public function readOne($id): ProjectModel
    {
        // requete récupération des projects
        global $pdo;

        $sql = "SELECT * 
                FROM project
                WHERE id_project = :id
                ";

        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        $statement->setFetchMode(PDO::FETCH_CLASS, 'ProjectModel');

        $project = $statement->fetch();

        // requete récupération des images 
        $sql = " SELECT *
                FROM picture
                WHERE id_project = :id
                ";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        $pictures = $statement->fetchAll(PDO::FETCH_CLASS, "PictureModel");
        $project->pictures = $pictures;

        // requete récupération des compétences (skills)
        $this->loadSkillsFromProject($project);
        return $project;
    }

    public function loadSkillsFromProject(ProjectModel $project)
    {
        global $pdo;
        $sql = "SELECT skill.`id_skill`, skill.`name`, skill.`level`, skill.`picture`
                FROM skill
                INNER JOIN skill_project
                ON skill_project.`id_skill` = skill.`id_skill`
                INNER JOIN project 
                ON project.`id_project` = skill_project.`id_project`
                WHERE project.`id_project` = :id
                ";

        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id", $project->id_project, PDO::PARAM_INT);
        $statement->execute();

        $project->skills = $statement->fetchAll(PDO::FETCH_CLASS, "SkillModel");
    }

    public function createProject(string $name, string $description, string $date_start, string $date_end, string $link_site, string $link_git, array $cover, array $skills)
    {
        if(strlen($name) > 255)
        {
            return 
            [
            "success" => false,
            "message" => "Le nom doit contenir 255 caractère maximum"
            ];
        }

        if(strlen($link_site) > 255)
        {
            return 
            [
            "success" => false,
            "message" => "Le lien doit contenir 255 caractère maximum"
            ];
        }

        if(strlen($link_git) > 255)
        {
            return 
            [
            "success" => false,
            "message" => "Le Git doit contenir 255 caractère maximum"
            ];
        }

        if(!in_array($cover["type"], ["image/png", "image/jpeg", "image/webp", "image/jpg"]))
        {
            return 
            [
            "success" => false,
            "message" => "Format d'image accépté png, jpeg, webp"
            ];
        }

        // les information sont correctes : stockons l'image
        $cover_name = time() . $cover["name"];

        move_uploaded_file($cover["tmp_name"], __DIR__ . "/../assets/img/projects/" . $cover_name);

        Global $pdo;

        $sql = "INSERT INTO project (
                                    name, 
                                    description,
                                    date_start,                                    
                                    date_end,                                    
                                    link_site,
                                    link_git,
                                    cover
                                    )
                    VALUE (
                            :name,
                            :description,
                            :date_start,                            
                            :date_end,
                            :link_site,
                            :link_git,
                            :cover
                            )
                ";

        $statement = $pdo->prepare($sql);

        $statement->bindParam(":name", $name);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":date_start", $date_start);

        $date_end = ($date_end == '' ? null : $date_end);
        $statement->bindParam(":date_end", $date_end);

        $link_site = ($link_site == '' ? null : $link_site);
        $statement->bindParam(":link_site", $link_site);

        $link_git = ($link_git == '' ? null : $link_git);
        $statement->bindParam(":link_git", $link_git);

        $statement->bindParam(":cover", $cover_name);

        $statement->execute();

        // récupération de l'Id du projet que nous venons d'inserer
        $id_project = $pdo->lastInsertId();

        // Insertion des competences lié à, ce projet
        if(count($skills) > 0)
        {
            foreach($skills as $skill)
            {
                $sql = "INSERT INTO skill_project (id_project, id_skill)
                        VALUES (:id_project, :id_skill)
                        ";
                
                $statement = $pdo->prepare($sql);

                $statement->bindParam(":id_project", $id_project);
                $statement->bindParam(":id_skill", $skill);

                $statement->execute();
            }
        }
        // Renvoi d'un tableau associatif permettant de connaître le succès ou non de la méthode
        return [
            "success" => true,
            "message" => "Le projet" . $name . "a été créé"
        ];
    }
}
