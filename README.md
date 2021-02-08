# Mini framework

Un petit framework d'exemple, avec les composants suivants :

* [Conteneur de services](https://php-di.org/doc/)
* [Router](https://github.com/mrjgreen/phroute)
* [Moteur de templates](https://twig.symfony.com/doc/3.x/)

### Installation

Éventuellement, &laquo; _forkez_ &raquo; ce dépôt. 

Clônez ce projet (ou votre _fork_) :

    git clone https://github.com/ekyna-learn/php-oo-mini-framework.git framework

Puis installez les dépendances :

    cd framework
    composer install

Dans votre gestionnaire de bases de données (comme _PhpMyAdmin_),
créez une base de données et importez le fichier _framework.sql_.

Créez le fichier _config/parameters.php.dist_ d'après le fichier 
_config/parameters.php.dist_, et modifiez la configuration pour 
la connection à la base de données.

Démarrez le serveur web dans le dossier _public/_ :

    cd public
    php -S localhost:8000

Puis visitez [http://localhost:8000](http://localhost:8000).
