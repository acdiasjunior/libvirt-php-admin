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

$domain->get('/listarInativas', function() use ($app, $name, $host) {
        return $app['twig']->render($name . '/listarInativas.twig', array(
                'dominios' => $host->getDomainsInactives(),
            ));
    });

$domain->get('/criar', function() use ($app, $name, $host) {
        return $app['twig']->render($name . '/criar.twig', array(
                'dominios' => $host->getDomainsActives(),
            ));
    });

$domain->get('/editar/{vm}', function($vm) use ($app, $name, $host) {
        return $app['twig']->render($name . '/editar.twig', array(
                'dominio' => $host->getDomain($vm),
            ));
    });

$domain->get('/createSnapshot/{vm}', function ($vm) use ($host) {
    return $host->getDomain($vm)->createSnapshot();
});

$domain->get('/resume/{vm}', function($vm) use ($host) {
        $host->getDomain($vm)->domainResume();
    });

$app->mount('/' . $name, $domain);