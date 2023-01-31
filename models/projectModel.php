<?php

class ProjectModel
{
    public string $cover;
    public int $id_project;
    public string $name;
    public string $description;
    public string $date_start;
    public ?string $date_end;
    public ?string $link_site;
    public ?string $link_git;
    public ?array $pictures;
}
?>
