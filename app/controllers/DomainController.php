<?php

// Controller para o dominio das VMs

$lib = new LibvirtAdmin\Libvirt();

$name = 'dominio';

$domain = $app['controllers_factory'];

$domain->get('/', function () use ($app, $name) {
        return $app['twig']->render($name . '/index.twig');
    });

$domain->get('/lista', function() use ($app, $name, $lib) {
        return $app['twig']->render($name . '/lista.twig', array(
                'dominios' => $lib->getDomainsActives(),
            ));
    });

$app->mount('/' . $name, $domain);