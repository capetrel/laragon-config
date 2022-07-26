# Configuration de Laragon windows
Configuration personnel de Laragon.

## Principe

L'idée, c'est de télécharger [Laragon](https://laragon.org/download/) et de cloner ce dépôt, afin d'avoir une configuration des programmes prête à l'emploi, il restera à configurer Laragon lui-même, dossier www, data, activer le ssl, gérer les variables d'environnement selon ses besoins.

Cette configuration est basée sur le fait que les dossiers 'www' et 'data' ne sont plus dans l'installation par défaut de Laragon. Déplacer le dossier 'www' et 'data' dans le dossier C:/user/nom-utilisateur et changer l'emplacement dans les paramètres de laragon : Menu -> préférences -> général, section 'Document Root' et 'Répertoire des données MySQL'.

## Garder Facilement la dernière version de PHP APACHE et autres à jour

Dans Laragon pour mettre à jour, changer de version d'un logiciel, il suffit de l'ajouter dans le dossier adéquat, cependant ça implique de tous reconfigurer derrière.

Dans le dossier /bin/apache nommer un dossier httpd-2.4 et installer la dernière version d'apache dedans. Lors d'une mise à jour, remplacer tous les fichiers sauf le fichier /bin/apache/conf/httpd.conf

Dans le dossier /bin/php/ nommer un dossier php8.1 et installer la dernière version de php 8.1 dedans. Lors d'une mise à jour, remplacer tous les fichiers tout en conservant le fichier /bin/php/php.ini

Dans le dossier /bin/mysql/ nommer un dossier mariadb-10.7 et installer la dernière version de mariadb-10.7 à l'intérieur. Pour la mise à jour même principe que précédemment sauf qu'il ne faut pas écraser le fichier /bin/mysql/my.ini

A priori nodejs n'a pas de fichier de configuration manuel donc ce n'est pas nécessaire de faire cette manipulation, il est possible de mettre la dernière version dans un dossier /bin/nodejs/node<version>

Ce principe va permettre au système d'avoir accès et d'exécuter la dernière version de chaque logiciel sans les avoir en doublon, c'est-à-dire installer classiquement sur le système et en version "portable" dans laragon. Pour cela il faut renseigner les différents chemins des logiciels dans le PATH Des variables (utilisateurs ou global, selon les besoins).

Note : C'est valable pour d'autres programmes comme composer, wp-cli, drush etc.., il faudra juste les ajouter au PATH. Ce principe permet quand même de changer de version si besoin (pour quelque raisons que ce soit), il suffira alors de configurer la version (php, apache ...) au moment du changement.

Variable d'environnement
C:\laragon\bin
C:\laragon\bin\composer
C:\laragon\bin\ngrok
C:\laragon\bin\putty
C:\laragon\bin\telnet
C:\laragon\bin\wpcli
C:\laragon\bin\apache\httpd-2.4\bin
C:\laragon\bin\laragon\utils
C:\laragon\bin\mysql\mariadb-10.7\bin
C:\laragon\bin\nodejs\node-V18
C:\laragon\bin\php\php8.1
C:\laragon\usr\bin

L'avantage, c'est que cette configuration peut être partagée facilement entre plusieurs postes à travers ce dépôt.

L'inconvénient, c'est que la mise à jour de chaque programme doit se faire manuellement, cependant avec un petit script bash, on peut simplifier cette mise à jour avec juste une commande bash à exécuter.

On peut se servir du fichier /usr/packages.conf pour récupérer la dernière version des programmes, il suffit de remplacer les liens de téléchargement par ceux en version 'latest'


## Cas particulier de MariaDB

Le fichier de configuration de MariaDB (et mySQL) et modifié par Laragon. Dans le cas d'un changement majeur de version (10.7 -> 10.8) il faudra faire un dump de toutes les bases de l'ancienne version pour les réinjecter dans la nouvelle version.


## Application
Laragon inclus quelques applications dans le dossier /etc/apps. Elles sont accessibles depuis la page root de laragon (/www/index.php -> http://localhost), et se situe dans le dossier /etc/apps.
 - [adminer](https://www.adminer.org/)
 - laragon : code fournit avec Laragon permet de téléverser des fichiers dans le dossier /etc/apps/laragon/uploads
 - [memcached](https://memcached.org/)
 - [phpMyAdmin](https://www.phpmyadmin.net/)
 - [phpRedisAdmin](https://github.com/erikdubbelboer/phpRedisAdmin)

Il faut les mettre à jour en fonction des versions d'Apache / PHP / MariaDB installé. Pour phpMyAdmin et phpRedisAdmin il y a des fichiers de configuration : /etc/apps/phpMyAdmin/config.inc.php et /etc/apps/phpRedisAdmin/includes/config.inc.php. Pensez à les conserver ou reproduire leur config.

Si besoin on peut ajouter des applications dans ce dossier, il faut créer un nouveau dossier au nom de l'appli /etc/apps/example et ajouter un VHost dans /etc/apache2/alias/example.conf. Il suffit ensuite de s'inspirer d'un des fichiers .conf.

## HTTPS et HTTP2

### HTTPS
Pour activer le https 
Menu -> Apache -> SSL -> Ajouter largon.crt au certificat de confiance
Menu -> Apache -> SSL -> Activé
Menu -> Préférences -> Services & Ports -> SSL: 443 'Activé'

Redémarrer Laragon


### HTTP2
Pour activer le http2 il faut modifier plusieurs fichiers qui servent de modèle à Laragon lors de la création d'un projet. Mais il faut également configurer Apache :

Dans le fichier /bin/apache/httpd-2.4/conf/httpd.conf Ajouter/dé commenter les lignes (évidemment s'assurer que les modules sont présents dans /bin/apache/modules):
 - LoadModule http2_module modules/mod_http2.so
 - Ajouter "Protocols h2 h2c http/1.1" sous la ligne ServerName (ou ailleurs peu importe)

Il faut ajouter ces lignes dans les fichiers -> /usr/tpl/openssl.conf.tpl,  -> /bin/laragon/tpl/openssl.conf.tpl et -> /etc/ssl/auto.openssl.conf (si le fichier existe)
```conf
    [v3_req]
    keyUsage = nonRepudiation, digitalSignature, keyEncipherment
    extendedKeyUsage = serverAuth
    subjectAltName = @alt_names
```

Redémarrer Laragon

## Astuce

Si jamais des changements ne sont pas pris en compte penser à redémarrer l'ordinateur.

### VHost
Il est possible d'empêcher Laragon de modifier le vhost d'un projet, il suffit d'enlever le 'auto.' dans le nom du fichier conf du projet dans /etc/apache2/sites-enabled/auto.nom-projet.test.conf -> etc/apache2/sites-enabled/nom-projet.test.conf

Cela permet de gérer des sous-domaines, de faire configuration un peu plus avancée comme ajouter des serverAlias pour gérer un multisite avec nom de domaine dans Wordpress.

### Création de projet

Dans le fichier /usr/sites.conf il est possible d'ajouter des lignes pour créer de nouveau projet à partir d'un dépôt git ex :
(TODO)

## TODO
 - [ ] Faciliter la mise à jour avec un script ou avec le fichier /usr/packages.conf