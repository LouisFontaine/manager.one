# manager.one

## First you need to install Xampp
It is used to manage the database in order to store our database

## Execute database.sql on PhpMyAdmin to create the database


Mise en place du mode Rewrite
Pour mettre en place ce système, votre serveur web (d'un point de vue matériel) doit tout d'abord être équipé du logiciel Apache. Apache est aujourd'hui devenu le processus serveur web le plus utilisé. Il est simple a mettre en place et il est gratuit. C'est d'ailleurs pourquoi on le retrouve dans les applications telles que EasyPHP, WAMP Server, MAMP, MovAMP, XAMP...

Nous devons tout d'abord commencer par activer le mod_rewrite d'Apache. Deux cas de figure s'offrent à nous :

Nous avons la main mise totale sur notre serveur (serveur dédié par exemple).
Nous dépendons d'un prestataire de services pour l'hébergement qui nous interdit l'accès à la configuration de ses serveurs (hébergement mutualisé).
Dans le premier cas, il nous suffit de vérifier dans le fichier httpd.conf d'Apache que le mod_rewrite est bien actif. Dans le cas contraire, nous devrons juste décommenter la ligne. La ligne en question est la suivante :

Chargement du module de réécriture d'url
LoadModule rewrite_module modules/mod_rewrite.so

