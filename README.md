# Scrilex (work in progress)

## Informations
Scrilex is built on the top of:
 - Silex (http://silex.sensiolabs.org)
 - Bootstrap (http://twitter.github.com/bootstrap/)
 - knplabs/repository-service-provider (https://github.com/KnpLabs/RepositoryServiceProvider)
 - knplabs/migration-service-provider (https://github.com/KnpLabs/MigrationServiceProvider)

## Installation
    ```php
    php composer.phar install

##Configuration
You need to configure database credentials in src/bootstrap.php file:
    ```php
    $app->register(new DoctrineServiceProvider(), array(
        'db.options' => array(
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => 'scrilex',
            'user'      => 'root',
            'password'  => 'root',
        )
    ));

You will soon set up access to the database in a yml file