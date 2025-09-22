<?php
require_once(__DIR__ . "/../../controller/ClienteController.php");
$clienteCont = new ClienteController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clienteCont->inserir();
    exit;
}
include_once(__DIR__ . "/form.php");
?>