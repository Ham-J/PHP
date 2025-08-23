#Touche Pas Au Klaxon

Application PHP pour la gestion de trajets 

------------------------------------------------------------------------

## Installation

  **Cloner le projet**

    ``` bash
    git clone https://github.com/ton-compte/ton-projet.git
    cd ton-projet
    ```
**Lancer la base de donnée avec les scripts du dossier db


  **Lancer le serveur PHP**\
    
    php -S localhost:8080 -t public

  **Accéder à l'application**\
    <http://localhost:8080>

------------------------------------------------------------------------

##  Identifiants de test

### Compte administrateur

-   **Login** : `admin`\
-   **Mot de passe** : `Admin!123`

### Compte utilisateur

-   **Login** : `user`\
-   **Mot de passe** : `User!123`

------------------------------------------------------------------------

##  Tests

### Analyse statique avec PHPStan

 bash
php tools/phpstan.phar analyse app


### Tests unitaires avec PHPUnit

php tools/phpunit.phar tests


------------------------------------------------------------------------

## 📂Structure du projet

    app/              → Contrôleurs, modèles, vues
    public/           → Point d’entrée (index.php)
    db/               → Scripts SQL (création de la base)
    tests/            → Tests unitaires PHPUnit
    tools/            → Outils (phpstan.phar, phpunit.phar, etc.)

------------------------------------------------------------------------

