<?php
session_start();

define("PAGE_TITLE", "Ajouter une competence");

require_once("../controllers/skillController.php");
require_once("../controllers/accountController.php");

$skillController = new SkillController;

if (isset($_POST["submit"])) 
{
    $result = $skillController->createSkill($_POST["name"], $_POST["level"], $_FILES["picture"]);
}

?>
<?php include("../assets/inc/head.php") ?>
<?php include("../assets/inc/header.php") ?>

<main id="formulaire" class="container">
    <div class="row">
        <div class="col-9 ms-3">

            <h1>Ajouter une compétence :</h1>

            <?php
        if(isset($result)) {
            if($result["success"]) { ?>
                <div class="alert alert-success"><?= $result["message"] ?></div>
            <?php }
            else { ?>
                <div class="alert alert-danger"><?= $result["message"] ?></div>
            <?php }
        }
        ?>
            
            <form action="#" method="POST" class="offset-4 my-3" enctype="multipart/form-data">

                <label for="name">Nom de la compétence</label>
                <input class="form-control" type="text" name="name" id="name" required>

                <label for="level">Niveau de la compétence</label>
                <input class="form-control" type="number" name="level" id="level" min="1" max="5" required>

                <label for="picture">Image de la compétence</label>
                <input class="form-control" type="file" name="picture" id="picture" accept="image/png, image/jpeg, image/webp" required>

                <button type="submit" name="submit" class="btn btn-primary mt-2">Envoyer</button>

            </form>
        </div>
    </div>
</main>

<?php include("../assets/inc/footer.php") ?>