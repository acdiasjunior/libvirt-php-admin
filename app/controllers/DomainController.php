<?php

// Controller para o dominio das VMs

$lib = new LibvirtAdmin\Libvirt();

$name = 'dominios';

$domain = $app['controllers_factory'];

$domain->get('/', function () use ($app, $name) {
        return $app['twig']->render($name . '/index.twig');
    });

$domain->get('/listar', function() use ($app, $name, $lib) {
        return $app['twig']->render($name . '/listar.twig', array(
                'dominios' => $lib->getDomainsActives(),
            ));
    });

$domain->get('/criar', function() use ($app, $name, $lib) {
        return $app['twig']->render($name . '/criar.twig', array(
                'dominios' => $lib->getDomainsActives(),
            ));
    });

$app->mount('/' . $name, $domain);