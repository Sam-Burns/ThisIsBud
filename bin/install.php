<?php

$config = __DIR__ . '/../config/config.php';
$configDist = __DIR__ . '/../config/config.php.dist';

if (!file_exists($config)) {
    copy($configDist, $config);
}
