<?php
require_once(__DIR__ . "/../../controller/OrdemServicoController.php");

$ordemServicoCont = new OrdemServicoController();
$lista = $ordemServicoCont->listar();
include_once(__DIR__ . "/../include/header.php");
?>

<h3>Listagem de Ordens de Serviço</h3> 

<div>
    <a href="inserir.php">Inserir</a>
</div>

<table class="table table-striped">
    <tr>
        <th>ID</th>
        <th>Descrição do Problema</th>
        <th>Cliente</th>
        <th>Data Entrada</th>
        <th>Prazo Estimado</th>
        <th>Status</th>
        <th>Ações</th>
    </tr>

    <?php foreach($lista as $ordem): ?>
        <tr>
            <td><?= $ordem->getId() ?></td>
            <td><?= $ordem->getDescricaoProblema() ?></td>
            <td><?= $ordem->getCliente()->getNome() ?></td>
            <td><?= $ordem->getDataEntrada() ?></td>
            <td><?= $ordem->getPrazoEstimadoSaida() ?></td>
            <td><?= $ordem->getStatus() ?></td>
            <td>
                <a href="alterar.php?id=<?= $ordem->getId() ?>">
                    <img src="../../img/btn_editar.png" alt="Editar">
                </a> 
                <a href="excluir.php?id=<?= $ordem->getId() ?>"
                    onclick="return confirm('Confirma a exclusão?');">
                    <img src="../../img/btn_excluir.png" alt="Excluir">
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include_once(__DIR__ . "/../include/footer.php"); ?>