<?php

// Controller para o dominio das VMs

$lib = new \LibvirtAdmin\Libvirt();

$domain = $app['controllers_factory'];

$domain->get('/', function () {
        return 'Maquinas Virtuais';
    });

$domain->get('/lista', function() use ($lib) {
        foreach ($lib->getDomainsActives() as $dominio) {
            echo sprintf("<li>%s <a href=\"/snapshot/create/%s\">Criar snapshot</a></li>\n", $dominio->getName(), $dominio->getName());
            if ($dominio->countSnapshots() > 0) {
                echo '<ul>';
                foreach ($dominio->listSnapshots() as $snapshot) {
                    echo sprintf("<li>Snapshot %s (%s) <a href=\"removersnapshot.php?domain=%s&snapshot=%s\">Remover</a></li>\n", $snapshot, date('d/m/Y H:i:s', $snapshot), $dominio->getName(), $snapshot);
                }
                echo '</ul>';
            }
        }
    });

$app->mount('/dominio', $domain);