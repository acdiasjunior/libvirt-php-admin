<?php

// Controller para o dominio das VMs

$name = 'index';

$host = new \LibvirtAdmin\Host();

$app->get('/', function () use ($app, $name, $host) {
        return $app['twig']->render($name . '/index.twig', array(
                'hostInfo' => $host->getInfo(),
            ));
    });

$app->get('/dashboard', function () use ($app, $name) {
        return $app['twig']->render($name . '/dashboard.twig');
    });

$app->get('/sobre', function () use ($app, $name) {
        return $app['twig']->render($name . '/sobre.twig');
    });