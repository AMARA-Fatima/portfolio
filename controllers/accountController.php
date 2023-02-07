<?php
require_once("../models/accountModel.php");
require_once("../configuration/conf.php");

// Ce controller nous servira à créer de nouveaux comptes, à nous connecter, et à vérifier la connexion quand on navigue dans la partie admin du site
class AccountController
{
    public function create(string $email, string $password)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                "success" => false,
                "message" => "Email incorrect"
            ];
        }
        if (strlen($password) < 8) {
            return [
                "success" => false,
                "message" => "Mot de passe trop court"
            ];
        }

        //Vérification de la force du mot de passe
        if (!preg_match("~^\S*(?=\S*[a-zA-Z])(?=\S*[0-9])(?=\S*[\W])\S*$~", $password)) {
            return [
                "success" => false,
                "message" => "Le mot de passe doit contenir au moins une lettre, un chiffre, et un caractère spécial"
            ];
        }
        // Si nous sommes arrivés jusque là c'est que notre nouvel account est correct, insérons le dans la base de données
        global $pdo;
        $sql = "INSERT INTO account (email, password)
            VALUES (:email, :password )";

        $statement = $pdo->prepare($sql);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":password", $password);

        $statement->execute();

        // Renvoi d'un tableau associatif permettant de connaître le succès ou non de la méthode
        return [
            "success" => true,
            "message" => "Compte utilisateur créé"
        ];
    }

    public function login(string $email, string $password)
    {
        global $pdo;
        // première etape : récupération un compte utilisateur correspond à cet email
        $sql = "SELECT id_account, email, password
                FROM account 
                WHERE email = :email
                ";

        $statement = $pdo->prepare($sql);
        $statement->bindParam(":email", $email);
        $statement->execute();

        // deuxieme partie : verification si au moins un compte a été trouvé 
        if ($statement->rowCount() > 0) {
            $statement->setFetchMode(PDO::FETCH_CLASS, "AccountModel");
            $account = $statement->fetch();

            // troixieme partie : vérifions si le mot de passe est correct
            if (password_verify($password, $account->password)) {
                // bravo : le mot de passe est correct, la personne est connécté 
                // du coup on enregistre les données de la session (enregistrer la connexion tout au long de la navigation grace au $_SESSION)
                $_SESSION["email"] = $account->email;
                header("location: /portfolio/admin/index.php");
            } 
            else 
            {
                return
                    [
                        "success" => false,
                        "message" => "mot de passe incorrect"
                    ];
            }
        } 
        else 
        {
            return
                [
                    "success" => false,
                    "message" => "Email incorrect"
                ];
        }
    }
    // fonction qui permet de verifier qu'un utilisateur soit connecté afin d'accéder à l'interface d'admin
    public function isLogged()
    {
        if(isset($_SESSION["email"]))
        {
            // la personne est connéctée ! 
            return true;
        }
        else 
        {
            // la personne n'est pas connéctée 
            header("Location: /protfolio/admin/connexion.php");
            return false;
        }
    }
}
