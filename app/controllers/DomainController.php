<?php

// Controller para o dominio das VMs

$host = new LibvirtAdmin\Host();

$name = 'dominios';

$domain = $app['controllers_factory'];

$domain->get('/', function () use ($app, $name) {
        return $app['twig']->render($name . '/index.twig');
    });

$domain->get('/listar', function() use ($app, $name, $host) {
        return $app['twig']->render($name . '/listar.twig', array(
                'dominios' => $host->getDomainsActives(),
            ));
    });

$domain->get('/criar', function() use ($app, $name, $host) {
        return $app['twig']->render($name . '/criar.twig', array(
                'dominios' => $host->getDomainsActives(),
            ));
    });

$app->mount('/' . $name, $domain);