# projetTWE
membres : nati, william, vale et jeanne
## Installation
Il faut autoriser l'usage d'une fichier .htaccess  
Pour cela, faire les commandes suivantes :  
`sudo a2enmod rewrite`  
`sudo service apache2 restart`  
`sudo nano /etc/apache2/sites-available/000-default.conf` et ajouter à la toute fin du fichier :
```
<Directory /var/www/html>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```
Et enfin, redémarrer une dernière fois le serveur Apache2 : `sudo service apache2 restart`