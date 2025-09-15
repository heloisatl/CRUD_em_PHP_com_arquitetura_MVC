<?php
// OrdemServicoController.php
require_once '../model/OrdemServico.php';
require_once '../dao/OrdemServicoDAO.php';
require_once '../service/OrdemServicoService.php';
require_once '../dao/ClienteDAO.php';
require_once '../dao/TipoServicoDAO.php';
require_once(__DIR__ . "/../dao/OrdemServicoDAO.php");

class OrdemServicoController
{
    private OrdemServicoService $ordemServicoService;
    private OrdemServicoDAO $ordemServicoDAO;
    private ClienteDAO $clienteDAO;
    private TipoServicoDAO $tipoServicoDAO;

    public function __construct()
    {
        $this->ordemServicoService = new OrdemServicoService();
        $this->ordemServicoDAO = new OrdemServicoDAO();
        $this->clienteDAO = new ClienteDAO();
        $this->tipoServicoDAO = new TipoServicoDAO();
    }

    public function listar()
    {
        $ordensServico = $this->ordemServicoService->listarTodos();
        include '../view/ordem_servico/listar.php';
    }

    public function cadastrar()
    {
        $clienteDAO = new ClienteDAO();
        $tipoServicoDAO = new TipoServicoDAO();

        $clientes = $clienteDAO->listarTodos();
        $tiposServico = $tipoServicoDAO->listarTodos();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ordemServico = new OrdemServico();
            $ordemServico->setDescricaoProblema($_POST['descricao_problema']);
            $ordemServico->setDataAbertura($_POST['data_abertura']);
            $ordemServico->setPrazoEstimado($_POST['prazo_estimado']);
            $ordemServico->setStatus($_POST['status']);
            $ordemServico->setIdCliente($_POST['id_cliente']);
            $ordemServico->setIdTipoServico($_POST['id_tipo_servico']);

            $resultado = $this->ordemServicoService->salvar($ordemServico);

            if ($resultado) {
                header('Location: listar.php?sucesso=1');
                exit;
            } else {
                $erro = "Erro ao cadastrar ordem de serviço";
            }
        }

        include '../view/ordem_servico/cadastrar.php';
    }

    public function alterar(OrdemServico $ordemServico)
    {
        $erros = [];

        // Chamando o service para validação
        $erros = $this->ordemServicoService->validarOrdemServico($ordemServico);
        if (count($erros) > 0) {
            return $erros;
        }

        // Se não houver erros de validação, tenta alterar no banco de dados
        $erro = $this->ordemServicoDAO->alterar($ordemServico);
        if ($erro) {
            $erros[] = "Erro ao atualizar a ordem de serviço!";
            // if(defined('AMB_DEV') && AMB_DEV) { // Exemplo de uso de constante para ambiente de desenvolvimento
            //     $erros[] = $erro->getMessage();
            // }
            $erros[] = $erro->getMessage();
        }

        return $erros;
    }

    // Outros métodos: editar, visualizar, excluir
}
