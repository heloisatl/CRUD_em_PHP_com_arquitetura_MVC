<?php

require_once(__DIR__ . "/../../model/OrdemServico.php");
require_once(__DIR__ . "/../../controller/OrdemServicoController.php");

$msgErro = "";
$ordemServico = null;

// Verifica se o formulário foi enviado (método POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Captura os dados do formulário
    $id = $_POST['id'];
    $descricaoProblema = $_POST['descricao_problema'];
    $dataAbertura = $_POST['data_abertura'];
    $prazoEstimado = $_POST['prazo_estimado'];
    $status = $_POST['status'];
    $idCliente = $_POST['id_cliente'];
    $idTipoServico = $_POST['id_tipo_servico'];
    
    // Cria um objeto OrdemServico com os dados
    $ordemServico = new OrdemServico();
    $ordemServico->setId($id);
    $ordemServico->setDescricaoProblema($descricaoProblema);
    $ordemServico->setDataEntrada($data_entrada);
    $ordemServico->setPrazoEstimadoSaida($prazo_estimado_saida);
    
    // Configura os IDs de cliente e tipo de serviço
    $cliente = new Cliente();
    $cliente->setId($idCliente);
    $ordemServico->setCliente($cliente);

    $tipoServico = new TipoServico();
    $tipoServico->setId($idTipoServico);
    $ordemServico->setTipoServico($tipoServico);

    // Chama o controller para alterar
    $ordemServicoCont = new OrdemServicoController();
    $erros = $ordemServicoCont->alterar($ordemServico);

    // Se não houver erro, redireciona para a página de listagem
    if ($erros === null) {
        header('Location: listar.php');
        exit;
    } else {
        // Se houver erro, redireciona com a mensagem de erro
       header('Location: listar.php?erro=' . urlencode(implode(', ', $erros)));
        exit;
    }
}
?>