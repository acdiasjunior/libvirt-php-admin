<?php

// Controller para o snapshot das VMs

$host = new LibvirtAdmin\Host();

$name = 'snapshots';

$snapshots = $app['controllers_factory'];

$snapshots->get('/', function () {
    return 'Snapshots';
});

$snapshots->get('/delete/{domain}/{snapshot}', function ($domain, $snapshot) use ($host) {
    return $host->getSnapshot($snapshot, $host->getDomain($domain))->delete();
});

$snapshots->get('/xml/{domain}/{snapshot}', function ($snapshot, $domain) use ($host, $app, $name) {
    return $app['twig']->render($name . '/xml.twig', array(
            'snapshot' => $host->getSnapshot($snapshot, $host->getDomain($domain)),
        ));
});

$app->mount('/snapshots', $snapshots);