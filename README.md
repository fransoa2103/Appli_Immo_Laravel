# François Couvé-Bonnaire pour 3G-Immo Annecy
- Réalisation d'un CRUD sur le thème de l'immobilier avec le Framework LARAVEL

# Base de données

- A partir de l'ennoncé ci-dessous, le besoin est une base de données nommée "3g_immo".
  - à l'intérieur 2 tables principales (hormis les tables automatiques de Laravel)
    
    -  users 
       - id (clé primaire automatique) 
       - nom_agent (varchar) -> exemple "WAUCAMPT"
       - prenom_agent (varchar) -> exemple "Corentin"
       - email (varchar) 
       - password (varchar)
       - remember_token(varchar) 
       - et les 2 champs created_at et update-at (automatique)

    -  annnonces
       - id (clé primaire automatique) 
       - user_id contient l'id unique du commercial en charge du dossier immobilier (1 id commercial max par annonce)
       - reference_annonce (varchar) -> exemple "123654FG"
       - description_annonce (champs que j'ai ajouté)
       - prix_annonce (float) -> exemple "125.05"
       - surface_habitable (float) -> exemple "12.25"
       - nombre_de_piece (int) -> exemple "5"
       - et les 2 champs created_at et update-at (automatique)
       

# MVC architecture mise en place

    - Les Models, un par table
      - Annonce, app\Models\Annonce.php
      - User, app\Models\User.php
  
    - Les Vues -> app\resources\views
      - Les vues utilisateurs sont regroupées dans le dossier auth
      - Les vues annonces sont regroupées dans le dossier annonces

    - Les Controllers
    - un controller reource pour la table des annonces app\Http\Controllers\AnnonceController.php
      - avec toutes les classes nécessaires au CRUD
    - et 4 controllers pour la table User comme suit:
      - Register, pour l'enregistrement d'un nouveau commercial
      - Login, pour son authentification
      - Logout, pour mettre fin à sa session
      - User, qui pour ce test se contente d'afficher ses noms et prénoms

# Démarrage
    - AU DEMARRAGE
      - la liste des annonces s'affichent dans l'ordre chronologique, à partir de la plus récente.
      - l'affichage des annonces comme suit : 3 annonces par écran + aide la fonction pagination de Laravel
      - Sans identification les annonces ne sont accessibles qu'en 'lecture seule
    
    - MENU PRINCIPAL
      - CONNEXION UTILISATEUR
        - vous accedez au formulaire d'identification avec votre mail et mot de passe
        - Une fois identifié, vous devenez AUTH (utilisateur identifié) avec le middleware app\Http\Middleware\Authenticate.php
      - INSCRIPTION NOUVEL UTILISATEUR (commercial)
        - Après inscription vous devrez vous connecter pour confirmer votre identité

  
    - UNE FOIS CONNECTE vous avez les privilèges utilisateur AUTH. 
        - la liste de toutes les annonces s'affiche de nouveau mais 
        - sous VOS annonces 2 boutons vous permettent d'intéragir comme suit:
          
          - MODIFIER > et sur une nouvelle page l'aide d'un formulaire pour modifier votre annonce
          - SUPPRIMER > en cliquant directement sur le bouton

          - et dans le nouveau menu auth connecté vous disposez des liens:
          - CREATION
            - pour vous permettre de créer une nouvelle annonce 
            - une nouvelle page et vous avez l'aide d'un formulaire pour CREER votre annonce
          - DECONNEXION
            - qui comme son nom l'indique vous déconnecte, vous (re)devenez GUEST (utilisateur visiteur)
    
    - le controle des formulaires des annonces passe par un formRequest > app\Http\Requests\AnnonceRequest.php

    - Des liens existent sur :
      - les titres des annonces
      - les noms et prénoms des commerciaux 
    -  pour un affichage unqiue à l'écran mais sans action supplémentaire


# Ennoncé du test

- Les fonctionnalités suivantes doivent être présente :
     - Affichage des annonces (ref_annonce,prix_annonce,surface_habitable,nombre_de_piece,nom_agent,prenom_agent)
     - Modification des annonces
     - Création d'une annonce
     - Suppression d'une annonce


- Un agent immobilier se compose des éléments suivants :
    - nom_agent (varchar) -> exemple "WAUCAMPT"
    - prenom_agent (varchar) -> exemple "Corentin"


Chaque annonce doit être rattachée au minimum à 1 agent et au maximum à 1 agent.
Un agent peut avoir au minimum 0 annonce et au maximum une infinité d'annonces.

- Techno back : LARAVEL
- Techno front : libre (Html, Js natif, Jquery, scss, css, vueJS, ...)

- Rendu sur GitHub avant le 21/02/2022 12H00. Si votre "repositories git" est privé, merci d'inviter (@3G-IMMO-Sebastien).

- Me transmettre par mail un export de votre base de données (.sql)

- Ne pas oublier le README et de commenter votre code.

- Fonctionnalité bonus : possibilité de trier les annonces par prix et/ou surface