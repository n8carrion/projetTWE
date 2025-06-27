# Installation
## config.php
Il faut duppliquer le fichier `config.php.example` et le renommer `config.php`.  
Doit y être indiqué :
 - le nom de la base de donnée
 - les codes d'accès à celle-ci
 - le mode du site : si `$PROD=false`, alors des fixtures de connexion sont activées pour permettre de tester le site sans utiliser l'authentification via CLA (car celle-ci ne peut foncitonner que pour un site accesible depuis larezerve.rezoleo.fr)

## Base de donnée
Il existe deux versions de la base de donnée : Une version vide `bdd/bdd_REZerve_blank.sql`, et une version contenant les utilisateurs testes pour les fixtures, ainsi que des données de testes `bdd/bdd_REZerve_test.sql` (les images sont déjà présentes dans le dossier uploads).  
Celle-ci doit être rendue accessible sur un serveur MySQL.

## Serveur web
Le site est prévu pour être installé sur un serveur web Apache2. Le contenue de ce dossier doit être présent à la racine du point d'accès d'où vous souhaitez que le site soit accessible (peut être un sous-dossier).

## .htaccess
Il faut autoriser l'usage d'une fichier .htaccess  
Pour cela, faire les commandes suivantes :  
`sudo a2enmod rewrite` 
`sudo nano /etc/apache2/sites-available/000-default.conf` et ajouter à la fin du fichier :
```
<Directory /var/www/html>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```
Et enfin, redémarrer le serveur Apache2 : `sudo service apache2 restart`

## Droits d'upload de fichiers
Il faut s'assurer que l'utilisateur de PHP a les droits d'accès et d'écriture au fichier `uploads/`, afin  de permettre l'upload d'images. 
Pour ce faire : https://stackoverflow.com/a/49566838