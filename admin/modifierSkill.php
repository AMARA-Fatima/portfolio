<?php

session_start();

define("PAGE_TITLE", "Modifier une Compétence");

require_once("../controllers/skillController.php");
require_once("../controllers/accountController.php");


$accountController = new AccountController;
// Permet de vérifier que l'utilisateur soit connecté
$accountController->isLogged();

$skillController = new SkillController;

$skill = $skillController->readOne($_GET["id"]);

if(isset($_POST["submit"])){
    $error = $skillController->updateSkill($_POST["id_skill"],$_POST["name"], $_POST["level"], $_FILES["picture"]);
}


?>
<?php include("../assets/inc/head.php"); ?>
<?php include("../assets/inc/header.php"); ?>

<main class="mt-5 mb-5">
    
    <h1 class="text-center">Modification de la compétence <?= $skill->name ?></h1>
    <?php 
    if(isset($error)){
        if($error["success"]){?>
            <div class="alert alert-success"><?=$error["message"]?></div>
       <?php } else {?>
        <div class="alert alert-danger"><?=$error["message"]?></div>
     <?php  }
    }
    ?>
    <div class="container d-flex justify-content-center  ">
        <form action="#" method="POST" enctype="multipart/form-data">     
            <div>
                <input type="hidden" name="id_skill" value="<?= $skill->id_skill?>">
            </div>
            <div class="mb-2">
                <label for="name" >Nom :</label>
                <input value="<?=$skill->name?>" type="text" name="name" id="name" required>
            </div>
            <div class="mb-2">
                <label for="level" >Niveau :</label>
                <input value="<?=$skill->level?>"type="number" min="1" max="5" name="level" id="level" required>
            </div>
            <div>
                <label for="picture" >Image :</label>
                <input type="file" id="picture" name="picture" accept="image/png, image/jpg, image/webp" required>
            </div>
            <div >
                <button type="submit" name="submit" class="btn btnProject mt-4 mb-5">Modifier</button>
            </div>


        </form>
    </div>
        <div class="text-center">
            <a href="../index.php" class="btn btnProject">Retour</a>
        </div>

</main>
<?php include("../assets/inc/footer.php");