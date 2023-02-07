TODO ce matin :
- Formulaire d'ajout de compétence sur la page ajoutCompetence.php
- Méthode create() permettant d'ajouter une compétence dans SkillController
- Envoyer les informations du formulaire dans la méthode create()

Points de vigilance :
- vérifiez si besoin les informations envoyées par le formulaire avant de les insérer dans la base de données dans votre méthode create()
- s'il y a une erreur, affichez-la dans le formulaire (inspirez-vous de ce qu'on a fait dans le formulaire de connexion)
- l'image de la compétence va nécessiter un traitement plus complexe que les autres champs. Il faudra vérifier qu'il s'agit bien d'une image (jpg / png...), l'enregistrer dans le dossier assets/img/skills, et enfin mettre son nom dans le champ "picture" de votre table "skill" en base de données
