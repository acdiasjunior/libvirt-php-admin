<?php

// Controller para o snapshot das VMs

$lib = new LibvirtAdmin\Libvirt();

$snapshot = $app['controllers_factory'];

$snapshot->get('/', function () {
    return 'Snapshots';
});

$snapshot->get('/create/{vm}', function ($vm) use ($lib) {
    $domain = new \LibvirtAdmin\Domain($vm, $lib->getConnection());
    return $domain->createSnapshot();
});

$snapshot->get('/delete/{vm}/$snapshot', function ($vm, $snapshot) use ($lib) {
    $domain = new \LibvirtAdmin\Domain($vm, $lib->getConnection());
    return $domain->createSnapshot();
});

$app->mount('/snapshot', $snapshot);