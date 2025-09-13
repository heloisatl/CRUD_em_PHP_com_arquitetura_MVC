<?php
// OrdemServicoController.php
require_once '../model/OrdemServico.php';
require_once '../dao/OrdemServicoDAO.php';
require_once '../service/OrdemServicoService.php';
require_once '../dao/ClienteDAO.php';
require_once '../dao/TipoServicoDAO.php';

class OrdemServicoController {
    private $ordemServicoService;
    
    public function __construct() {
        $this->ordemServicoService = new OrdemServicoService();
    }
    
    public function listar() {
        $ordensServico = $this->ordemServicoService->listarTodos();
        include '../view/ordem_servico/listar.php';
    }
    
    public function cadastrar() {
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
    
    // Outros métodos: editar, visualizar, excluir
}
?>