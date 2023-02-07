<?php

define("PAGE_TITLE", "Ajouter une competence");

require_once("../controllers/skillController.php");

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
            <form action="#" method="POST" class="offset-4 my-3" enctype="multipart/form-data">

                <label for="name">Nom de la compétence</label>
                <input class="form-control" type="text" name="name" id="name" required>

                <label for="level">Niveau de la compétence</label>
                <input class="form-control" type="number" name="level" id="level" min="1" max="5" required>

                <label for="picture">Image de la compétence</label>
                <input class="form-control" type="file" name="picture" id="picture" accept="image/png, image/jpeg, image/webp" required>

                <button type="submit" name="submit" class="btn btn-primary mt-2">Envoyer</button>

                <!-- <input type="hidden" name="faire" value="create_competence">

                <input class="form-control" type="text" name="name" placeholder="Nom de la compétences">

                <input class="form-control mt-3" type="int" name="level" placeholder="Ajouter un level">

                <label for="picture" class="mt-2">Ajouter une image</label>
                <input class="form-control" type="file" name="picture">

                <div>
                    <input type="checkbox" name="active" value="1">
                    <label for="active">afficher dans le Front-end</label>
                </div>

                <button type="submit" name="soumettre" class="mt-3 btn text-white bg-primary">Enregistrer</button> -->

            </form>
        </div>
    </div>
</main>

<?php include("../assets/inc/footer.php") ?>