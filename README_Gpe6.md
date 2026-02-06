# Blogart Template

## Setup


## Architecture
- **api** - Contains all php calls for example "create.php" for statuts, articles
- **classes** - Contains all classes for example "members.php"
- **config** - Contains all the configuration files specific to the operation of the application, for example "security.php"
- **functions** - Contains all the functions of your code for example "data.php", "create.php"
- **views** - Contain all front
- **src** - Contain all sources files or external libs

## Files to complete
- **.env** - Foreach user exemple in .env.example
- **config/security.php** - Check user cookie
- **index.php** - Must be the homepage
- **views** - All your pages
- 

Login Administrateur:

    Pseudo: Admin00
    MDP: Admin0000

Login Membre: 

    Pseudo: Membre
    MDP: Membre0000

Login Comptes extra:

    Pseudo: testPseudo, testPseudo2
    MDP: Test1234

Etat de la base de donnée:

    Des Membres, Statut, Articles, Mots-cles, Thématiques, Commentaires, Likes/Unlike ont été créés pour être supprimés et modifiés.

Etat des lieux du projet: 
    - Tous les CRUDs fonctionnenent
    - Les pages admins sont sécurisées, même par URLs.
    - Admins et Modérateurs ont les même perms, sauf la suppression définitive d'un commentaire et toutes les actions associées au Membres.
    - Les CAPTCHAs sont toujours hors service, comme discuté précédemment.
    - Les pages views\frontend\actors.php
                views\frontend\events.php
                views\frontend\movements.php
                views\frontend\original.php    existent mais ne sont pas accessible via le site, et ne contiennent pas les articles.

Dernier push GitHub 16h32