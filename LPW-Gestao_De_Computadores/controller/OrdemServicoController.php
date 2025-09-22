<?php
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

    public function listar(): array
    {
        return $this->ordemServicoDAO->listar();
    }

    public function listarClientes(): array
    {
        return $this->clienteDAO->listar();
    }

    public function listarTiposServico(): array
    {
        return $this->tipoServicoDAO->listar();
    }

    public function buscarClientePorId(int $id): ?Cliente
    {
        return $this->clienteDAO->buscarPorId($id);
    }

    public function buscarTipoServicoPorId(int $id): ?TipoServico
    {
        return $this->tipoServicoDAO->buscarPorId($id);
    }

    // ✅ CORRETO - método que apenas processa o cadastro (sem incluir view)
    public function cadastrar(OrdemServico $ordemServico)
    {
        // Validação
        $erros = $this->ordemServicoService->validarOrdemServico($ordemServico);
        
        if (!empty($erros)) {
            return $erros; // Retorna array de erros de validação
        }

        // Inserção no banco
        $erro = $this->ordemServicoDAO->inserir($ordemServico);
        
        if ($erro !== null) {
            return [$erro->getMessage()]; // Retorna array com erro do banco
        }

        return null; // Sucesso
    }

    // ✅ NOVO método para exibir o formulário
    public function exibirFormularioCadastro()
    {
        $clientes = $this->listarClientes();
        $tiposServico = $this->listarTiposServico();
        
        include '../view/ordem_servico/cadastrar.php';
    }

    public function alterar(OrdemServico $ordemServico): array
    {
        $erros = $this->ordemServicoService->validarOrdemServico($ordemServico);
        
        if (count($erros) > 0) {
            return $erros;
        }

        $erro = $this->ordemServicoDAO->alterar($ordemServico);
        if ($erro !== null) {
            $erros[] = "Erro ao atualizar: " . $erro->getMessage();
        }

        return $erros;
    }

    // ✅ Adicione este método para exclusão
   // public function excluir(int $id): ?string
    //{
      //  $erro = $this->ordemServicoDAO->excluirPorId($id);
        //if ($erro !== null) {
          //  return $erro->getMessage();
        //}
        //return null;
    //}

    public function buscarPorId(int $id): ?OrdemServico
    {
        return $this->ordemServicoDAO->buscarPorId($id);
    }

   
    public function excluir($id) {
        return $this->ordemServicoDAO->excluirPorId($id);
    }

}
