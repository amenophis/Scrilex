<?php
// doctrine.php - Put in your application root

use Doctrine\ORM\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Symfony\Component\Console\Helper\HelperSet;

$app = require_once __DIR__.'/src/app.php';

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($app['db.orm.em']->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($app['db.orm.em'])
));

\Doctrine\ORM\Tools\Console\ConsoleRunner::run($helperSet);
