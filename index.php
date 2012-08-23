<?php

//ini_set('error_reporting', E_ERROR);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//ini_set('log_errors_max_len', 0);
//ini_set('error_log', 'syslog');

define('LIBVIRT_DIR',__DIR__);

set_include_path(implode(PATH_SEPARATOR, array(__DIR__, __DIR__ . '/app/classes', __DIR__ . '/app/controllers')));

require_once __DIR__ . '/vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.options' => array('debug' => true),
    'twig.path' => __DIR__ . '/app/views',
));

$app['twig']->addFilter('var_dump', new \Twig_Filter_Function('var_dump'));

require_once __DIR__ . '/app/classes/LibvirtAdmin/Autoloader.php';

LibvirtAdmin\Autoloader::register();

require_once 'IndexController.php';
require_once 'DomainController.php';
require_once 'SnapshotController.php';

$app->error(function (\Exception $e, $code) {
        if ($code == 404) {
            return "Erro ao processar a requisição.\n" . $e->getMessage();
        }

        return $e->getMessage();
    });

$app->run();
