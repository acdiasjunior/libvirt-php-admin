<?php
ini_set('error_reporting', E_ERROR);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('log_errors_max_len', 0);
ini_set('error_log', 'syslog');

require_once 'classes/libvirt.php';

$lib = new LibVirt();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Planejar - pcavm</title>
        <link rel="stylesheet" href="padrao.css" type="text/css" />
    </head>
    <body>
        <h2>Virtualização KVM - <?= $lib->getHostName() ?></h2>
        <h4>
            Domínios ativos:
        </h4>
        <ul>
            <?php
            foreach ($lib->getDomainsActives() as $dominio) {
                echo '<li>' . $dominio->getName() . '<a href="criarsnapshot.php?domain=' . $dominio->getName() . '">Criar snapshot</a></li>';
                $snapshots = $dominio->listSnapshots();
                if (count($snapshots) > 0) {
                    echo '<ul>';
                    foreach ($snapshots as $snapshot) {
                        echo sprintf('<li>Snapshot %s (%s)</li>', $snapshot, date('d/m/Y H:i:s', $snapshot));
                    }
                    echo '</ul>';
                }
            }
            ?>
        </ul>
        <br />
    </body>
</html>
