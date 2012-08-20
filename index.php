<?php

//ini_set('error_reporting', E_ERROR);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//ini_set('log_errors_max_len', 0);
//ini_set('error_log', 'syslog');

set_include_path(implode(PATH_SEPARATOR, array(__DIR__, __DIR__ . '/app/classes')));

require_once __DIR__ . '/vendor/autoload.php';

$app = new Silex\Application();

require_once __DIR__ . '/app/classes/LibvirtAdmin/Autoloader.php';

LibvirtAdmin\Autoloader::register();

require_once __DIR__ . '/app/controllers/DomainController.php';
require_once __DIR__ . '/app/controllers/SnapshotController.php';

$app->get('/', function () {
        return 'Libvirt Admin';
    });

$app->run();