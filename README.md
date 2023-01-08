# SAFER ?
TP symfony, demandé par l'uuiversité de Rennes 1 pour controle de connaissance, et réalisé par *[Wilfrand ATCHI](https://github.com/icanbewill).* et *Maël BARAC'H*


# INSTALLATION
Pour lancer le projet

1. Clonez le repo
```
git clone https://github.com/icanbewill/rennes-tpsafer-web.git
```
2. Installez les dépendances
```
composer install | composer update
```
3. Configuez la connexion à la BDD avec les bonnes informations dans le fichier __.env__
```ruby
DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8&charset=utf8mb4"
```
4. Créez votre base de données
```
php bin/console doctrine:database:create
```
5. Lancez les migrations
```
php bin/console doctrine:migrations:migrate
```
6. Servez votre projet cloné
```
symfony serve
```
7. Lien vers la vidéo démo
[DEMO](https://screenapp.io/#/shared/a2503f8c-d911-4583-be68-683af0495a05)
