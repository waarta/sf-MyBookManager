##Installation

\$ git clone https://perin011@iut-info.univ-reims.fr/gitlab/perin011/MyBookManager.git

\$ cd MyBookManager

\$ composer install

\$ npm install

##Modifier ensuite les variables d'environnement du fichier .env selon votre environnement local.

DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name

##Création, migration, fixtures de la base de données

\$ php bin/console doctrine:database:create

\$ php bin/console doctrine:migrations:migrate

\$ php bin/console doctrine:fixtures:load

##lancer le serveur

\$ php bin/console server:start

##Fonctionnalité

###log de test

en tant qu'admin -> login: admin password: admin
en tant que user -> login: user1 password: user1
en tant que user -> login: user2 password: user2

###Marque page

Possibilité de rechercher un marque page ave son titre/url/commentaire

Une personne non connecté peut pas voir les marques pages

Un user peut ajouter un marque page et modifier ou supprimer ceux quil a creer

Un user / admin peut voir uniquement ses marques pages
