<?php
ini_set('error_reporting', E_ERROR);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('log_errors_max_len', 0);
ini_set('error_log', 'syslog');

require_once 'classes/libvirt.php';

$lib = new LibVirt();
$lib->connect();

if ($lib->isConnected()) {
    $dom = new Domain($_REQUEST['domain'], $lib->getConnection(), true);
    $snapshot = $dom->createSnapshot();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Planejar - pcavm</title>
        <link rel="stylesheet" href="padrao.css" type="text/css" />
    </head>
    <body>
        <h2>Virtualização KVM</h2>
        <h4>
            Criar snapshot:
        </h4>
        Domínio: <?= $_REQUEST['domain'] ?>
        <?= var_dump($snapshot) ?>
        <br />
    </body>
</html>
