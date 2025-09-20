<?php
    
    
    require_once(__DIR__ . "/../../model/OrdemServico.php");
    require_once(__DIR__ . "/../../controller/OrdemServicoController.php");

    $ordemServicoCont = new OrdemServicoController();
    $lista = $ordemServicoCont->listar();
    //Incluir o header
    include_once(__DIR__ . "/../include/header.php");
    print_r($lista);

?>

<h3>Listagem de Clientes</h3> 

<div>
    <a href="inserir.php">Inserir</a>
</div>

<table class="table table-striped">
    <!-- Cabeçalho -->
    <tr>
        <th>ID</th>
        <th>Nome do Cliente</th>
        <th>Telefone do Cliente</th>
        <th>Email do Cliente</th>
        <th>algumaoutracoisa</th>
        <th></th>
        <th></th>
    </tr>

    <!-- Dados -->
    <?php foreach($lista as $cliente): ?>
        <tr>
            <td><?php echo $cliente->getId(); ?></td>
            <td><?php echo $cliente->getNome(); ?></td>
            <td><?php echo $cliente->getTelefone(); ?></td>
            <td><?php echo $cliente->getEmail(); ?></td>
            <td>
                <a href="alterar.php?id=<?= $cliente->getId() ?>">
                        <img src="../../img/btn_editar.png">
                    </a> 
            </td>
            <td>
                <a href="excluir.php?id=<?= $cliente->getId() ?>"
                    onclick="return confirm('Confirma a exclusão?');">
                    <img src="../../img/btn_excluir.png">
                </a>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<?php 
    //Inclui o footer
    include_once(__DIR__ . "/../include/footer.php");
?>
