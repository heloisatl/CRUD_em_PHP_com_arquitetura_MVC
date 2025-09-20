<?php
// OrdemServicoController.php
// Replace all relative paths with absolute paths using __DIR__
require_once __DIR__ . '/../model/OrdemServico.php';
require_once __DIR__ . '/../service/OrdemServicoService.php';
require_once __DIR__ . '/../dao/ClienteDAO.php';
require_once __DIR__ . '/../dao/TipoServicoDAO.php';
require_once __DIR__ . '/../dao/OrdemServicoDAO.php';

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

        $lista = $this->ordemServicoDAO->listar();
        return $lista;
        // $ordensServico = $this->ordemServicoService->listarTodos();
        //include '../view/ordem_servico/listar.php';
    }

    public function cadastrar()
    {
        $clienteDAO = new ClienteDAO();
        $tipoServicoDAO = new TipoServicoDAO();

        $clientes = $clienteDAO->listar();
        $tiposServico = $tipoServicoDAO->listar();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ordemServico = new OrdemServico();
            $ordemServico->setDescricaoProblema($_POST['descricao_problema']);
            $ordemServico->setDataEntrada($_POST['data_abertura']);
            $ordemServico->setPrazoEstimadoSaida($_POST['prazo_estimado']);
            $ordemServico->setStatus($_POST['status']);

            //$ordemServico->setIdCliente($_POST['id_cliente']);
            //$ordemServico->setIdTipoServico($_POST['id_tipo_servico']);

            // Ao invés de passar apenas o ID do cliente ou do tipo de serviço para a OrdemServico, é necessário criar um objeto Cliente e um objeto TipoServico e associá-los à OrdemServico. Isso acontece porque o modelo OrdemServico foi projetado para trabalhar com objetos completos dessas classes, permitindo acessar facilmente outros dados do cliente ou do tipo de serviço(por exemplo, nome, email, etc.) a partir da ordem de serviço, se necessário. Assim, o relacionamento entre as entidades fica mais claro e alinhado ao padrão de orientação a objetos, facilitando a manutenção e a expansão do sistema no futuro.

            $cliente = new Cliente();
            $cliente->setId($_POST['id_cliente']);
            $ordemServico->setCliente($cliente);

            $tipoServico = new TipoServico();
            $tipoServico->setId($_POST['id_tipo_servico']);
            $ordemServico->setTipoServico($tipoServico);

            $resultado = $this->ordemServicoService->validarOrdemServico($ordemServico);

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
            $erros[] = $erro;
        }

        return $erros;
    }

    // Outros métodos: editar, visualizar, excluir
}
