<?php
require_once __DIR__ . "/../../controller/OrdemServicoController.php";
require_once __DIR__ . "/../../model/OrdemServico.php";
require_once __DIR__ . "/../../model/Cliente.php";
require_once __DIR__ . "/../../model/TipoServico.php";
require_once __DIR__ . "/../../model/TipoServico.php";

$msgErro = "";
$cliente = null;

// Instanciar o controller
$ordemServicoCont = new OrdemServicoController();

$clientes = $ordemServicoCont->listarClientes();
$tiposServico = $ordemServicoCont->listarTiposServico();



// Verificar o método HTTP
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Capturar dados do formulário
    //VERIFICAR AQUI SE OS NOMES ESTÃO IGUAIS AOS DO FORMULÁRIO!!!!!!!!!!!
    //E SE OS ATRIBUTOS ESTÃO IGUAIS AOS DO OBJETO!!!!!!!!!!!!!!!!!
    $descricaoProblema = trim($_POST['descricao_problema']) ? trim($_POST['descricao_problema']) : NULL;

    $dataEntrada = trim($_POST['data_entrada']) ? $_POST['data_entrada'] :  NULL;

    $prazoEstimado = trim($_POST['prazo_estimado_saida']) ? $_POST['prazo_estimado_saida'] : NULL;

    $status = trim($_POST['status']) ? trim($_POST['status']) : NULL;

    $idCliente = trim($_POST['id_cliente']) ? trim($_POST['id_cliente']) : NULL;

    $idTipoServico = trim($_POST['id_tipo_servico']) ? trim($_POST['id_tipo_servico']) : NULL;

    // Criar objeto OrdemServico para persistí-lo
    $ordemServico = new OrdemServico();
    $ordemServico->setDescricaoProblema($descricaoProblema);
    $ordemServico->setDataEntrada($dataEntrada);
    $ordemServico->setPrazoEstimadoSaida($prazoEstimado);
    $ordemServico->setStatus($status);


    //SEM VALIDAÇÕES POIS O SERVICE JÁ FAZ ISSO
    // Configurar Cliente
    $cliente = new Cliente();
    $cliente->setId($idCliente);
    $ordemServico->setCliente($cliente);

    // Configurar TipoServico
    $tipoServico = new TipoServico();
    $tipoServico->setId($idTipoServico);
    $ordemServico->setTipoServico($tipoServico);

    $erro = $ordemServicoCont->cadastrar($ordemServico);
    print_r($ordemServico);

    if ($erro === null) {
        header("location: listar.php");
        exit;
    } else {
        // Se for array de erros (do service) ou mensagem de erro (do DAO)
        if (is_array($erro)) {
            $msgErro = implode("<br>", $erro);
        } else {
            $msgErro = "Erro: " . $erro->getMessage();
        }
    }
}
include_once(__DIR__ . "/form.php");