<?php

// Controller para o snapshot das VMs

$host = new LibvirtAdmin\Host();

$snapshot = $app['controllers_factory'];

$snapshot->get('/', function () {
    return 'Snapshots';
});

$snapshot->get('/create/{vm}', function ($vm) use ($host) {
    $domain = new \LibvirtAdmin\Domain($vm, $host->getConnection());
    return $domain->createSnapshot();
});

$snapshot->get('/delete/{vm}/$snapshot', function ($vm, $snapshot) use ($host) {
    $domain = new \LibvirtAdmin\Domain($vm, $host->getConnection());
    return $domain->createSnapshot();
});

$app->mount('/snapshot', $snapshot);