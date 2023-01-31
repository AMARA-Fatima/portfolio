<?php
require_once("./configuration/conf.php");
require_once("./models/projectModel.php");
require_once("./models/pictureModel.php");

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

        return $result;

    }

    public function readOne($id): ProjectModel
    {
        
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

        return $project;
    }
}
