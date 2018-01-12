# L3 MIAGE (Université Rennes 1) 2017 - 2018
## Projet Web - Prêt de chez vous > Admin Panel

### Prérequis
- php 7.1
- composer

### Installation
Pour installer le projet, cloner ce repertoire avec la commande suivante:<br>
``git clone https://github.com/anohabbah/pw_project.git``.<br>
Ensuite, positioner vous à la racine du projet et executer cette commande:<br> ``composer install``.

Une fois les dépendances installer copier le fichier ``.env.exapmle`` en ``.env``, ouvrier le nouveau fichier (.env) 
et configurer la base de données.

Après la configuration de la base de données, executer cette commande à la racine du projet:<br> ``php artisan migrate --seed``.<br>
Elle créera les différentes tables et générera de fausses données.

A ce niveau, vous pouvez lancer l'application en executant la commande suivante:<br> ``php artisan serve``<br> et dans votre 
navigateur aller sur le lien suivant: ``http://127.0.0.1:8000``.

Connectez-vous avec les paramètres suivants: 
- email: admin@example.com
- mot de passe: secret