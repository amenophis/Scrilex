# Scrilex (work in progress)

## Informations
Scrilex is built on the top of:
 - Silex (http://silex.sensiolabs.org)
 - Bootstrap (http://twitter.github.com/bootstrap/)
 - amenophis/silex-doctrineorm (https://github.com/amenophis/silex-doctrineorm)

## Installation
    git clone https://github.com/amenophis/Scrilex.git Scrilex
	cd Scrilex 
	curl -s http://getcomposer.org/installer | php
	php composer.phar install

##Configuration
You need to configure database credentials in src/bootstrap.php file:

    $app->register(new DoctrineServiceProvider(), array(
        'db.options' => array(
            'driver'    => 'pdo_mysql',
            'dbname'    => 'scrilex',
            'user'      => 'root',
            'password'  => 'root',
        )
    ));

You will soon set up access to the database in a yml file

##TODO
 - Date d'échéance
 - Masque de couleur Sévérité
 - Personnaliser le nombre de colonnes du projet
 - Tous les champs à la création de la tache
 - Historique des actions