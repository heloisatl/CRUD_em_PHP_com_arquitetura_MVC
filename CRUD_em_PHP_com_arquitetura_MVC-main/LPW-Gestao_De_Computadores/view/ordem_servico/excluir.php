<?php

require_once(__DIR__ . "/../../controller/OrdemServicoController.php");

$msgErro = "";
$ordemServico = null;

// Verifica se o ID foi fornecido via GET
$id = 0;
if (isset($_GET['id'])) 
    $id = $_GET['id'];




