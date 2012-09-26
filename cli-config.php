<?php

$app = require __DIR__.'/src/app.php';

return array(
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($app['db.orm.em'])
);