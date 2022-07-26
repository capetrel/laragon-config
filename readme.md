# Configuration de Laragon windows
Configuration personnel de Laragon

## Principe

L'idée, c'est de télécharger [Laragon](https://laragon.org/download/) et de cloner ce dépôt, afin d'avoir une configuration des programmes prête à l'emploi, il restera à configurer Laragon lui-même, dossier www, data, activer le ssl, gérer les variables d'environnement selon ses besoins.

## Garder Facilement la dernière version de PHP APACHE et autres à jour

Dans Laragon pour mettre à jour, changer de version d'un logiciel il suffit de l'ajouter dans le dossier adéquat, cependant ça implique de tous reconfigurer derrière

Dans le dossier /bin/apache nommer un dossier httpd2.4 et installer la dernière version d'apache dedans. Lors d'une mise à jour, remplacer tous les fichiers sauf en conservant le fichier /bin/apache/httpd2.4/conf/httpd.conf

Dans le dossier /bin/php/ nommer un dossier php8.1 et installer la dernière version de php 8.1 dedans. Lors d'un mise à jour, remplacer tous les fichiers sauf en conservant le fichier /bin/php/php.ini

Dans le dossier /bin/mysql/ nommer un dossier mariadb10 et installer la dernière version de mariadb10 à l'intérieur. Pour la mises à jour même principe que précédemment sauf qu'il ne faut pas écraser le fichier /bin/mysql/my.ini

A priori nodejs n'a pas de fichier de configuration manuel donc ce n'est pas nécessaire de faire cette manipulation, il est possible de mettre la dernière version dans un dossier /bin/nodejs/node

Ce principe va permettre au système d'avoir accès et d'exécuter la dernière version de chaque logicielle sans les avoir en doublon, c'est-à-dire installer classiquement sur le système et en version "portable" dans laragon. Pour cela il faut renseigner les différents chemins des logiciels dans le PATH Des variables d'environnement soit système (pour que tous les utilisateurs est la même version), soit utilisateur.

Note : C'est valable pour d'autres programmes comme composer, wp-cli, drush etc.., il faudra juste les ajouter au PATH. Ce principe permet quand même de changer de version si besoin (pour quelque raisons que ce soit), il suffira alors de configurer la version (php, apache ...) au moment du changement.

C:\laragon\bin
C:\laragon\bin\composer
C:\laragon\bin\ngrok
C:\laragon\bin\putty
C:\laragon\bin\telnet
C:\laragon\bin\wpcli
C:\laragon\bin\apache\httpd2.4\bin
C:\laragon\bin\laragon\utils
C:\laragon\bin\mysql\mariadb10\bin
C:\laragon\bin\nodejs\node
C:\laragon\bin\php\php8.1
C:\laragon\usr\bin

L'avantage, c'est que cette configuration peut être partagé facilement entre plusieurs postes à travers ce dépôt.

L'inconvénient, c'est que la mise à jour de chaque programme doit se faire manuellement, cependant avec un petit script bash, on peut simplifier cette mise à jour avec juste une commande bash à exécuter.

On peutse servir du fichier /usr/packages.conf pour récupérer la dernière version des programmes, il suffit de remplacer les liens de téléchargement par ceux en version 'latest'

## HTTPS et HTTP2

### HTTPS
Pour activer le https 
Menu -> Apache -> SSL -> Ajouter largon.crt au certificat de confiance
Menu -> Apache -> SSL -> Activé
Menu -> Préférences -> Services & Ports -> SSL: 443 'Activé'

Redémarrer Laragon


### HTTP2
Pour activer le http2 il faut modifier plusieurs fichiers qui servent de modèle à Laragon lors de la création d'un projet. Mais il faut également configurer Apache:

Dans le fichier /bin/apache/httpd-2.4/conf/httpd.conf Ajouter/dé commenter les lignes (évidemment s'assurer que les modules sont présents dans /bin/apache/modules):
 - LoadModule http2_module modules/mod_http2.so
 - LoadModule proxy_http2_module modules/mod_proxy_http2.so
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

### vhost
Il est possible d'empêcher Laragon de modifier le vhost d'un projet, il faut pour enlever le 'auto.' dans le nom du fichier conf du projet dans /etc/apache2/sites-enabled/auto.nom-projet.test.conf -> etc/apache2/sites-enabled/nom-projet.test.conf

Cela permet de gérer des sous-domaines, de faire configuration un peu plus avancée comme ajouter des serverAlias pour gérer un multisite avec nom de domaine dans Wordpress.

### création de projet

Dans le fichier /usr/sites.conf il est possible d'ajouter des lignes pour créer de nouveau projet à partir d'un dépôt git ex :
(TODO)

## TODO
 -[ ] Faciliter la mise à jour avec un script ou avec le fichier /usr/packages.conf
 -[ ] Compléter avec la config de l'autre ordi