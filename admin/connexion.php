<?php

session_start();

define("PAGE_TITLE", "Connexion");

include("../assets/inc/head.php");
include("../assets/inc/header.php");

require_once("../controllers/accountController.php");

$controller = new AccountController;

if (isset($_POST["submit"]) && isset($_POST["email"]) && isset($_POST["password"])) {
    // le formulaire a été envoyé, essayons de nous connecter
    $error = $controller->login($_POST["email"], $_POST["password"]);
}
// création d'un nouveau compte
// $result = $controller->create("amarafati27@gmail.com", "Patate78!");
// var_dump($result)

?>

<main id="formulaire">
    <div class="container mb-3">
        <div class="row">

            <h1 class="text-center">Connexion à l'espace administrateur :</h1>

            <?php if (isset($error)) { ?>
                <div>
                    <?= $error["message"] ?>
                </div>
            <?php } ?>

            <form class="col-6 offset-3" action="#" method="POST">
                <div>
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe :</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary offset-5">Valider</button>
            </form>

        </div>
    </div>
</main>

<?php include("../assets/inc/footer.php"); ?>