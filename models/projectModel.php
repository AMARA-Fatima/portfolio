<?php

class ProjectModel
{
    public ?string $cover;
    public int $id_project;
    public string $name;
    public string $description;
    public string $date_start;
    public ?string $date_end;
    public ?string $link_site;
    public ?string $link_git;

    public function afficherProjects()
    {
?>
        <div class="conatiner">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-5 ms-5 mt-5" style="width: 18rem;">
                        <div class="card-body">
                            <img src="./assets/img/projects/<?= $this->cover ?>" class="card-img-top" alt="...">
                            <h5 class="card-title">Titre : <?= $this->name ?> </h5>
                            <p class="card-text">Description : <?= $this->description ?></p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Date_début : <?= $this->date_start ?></li>
                            <li class="list-group-item">Date_fin : <?= $this->date_end ?></li>
                        </ul>
                        <div class="card-body">
                            <a href="#" class="card-link">Voir_site : <?= $this->link_site ?></a>
                            <a href="#" class="card-link">Voir_Git : <?= $this->link_git ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}
?>