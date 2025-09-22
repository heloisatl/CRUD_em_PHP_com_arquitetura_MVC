<?php

// ClienteController.php
require_once __DIR__ . '/../model/Cliente.php';
require_once __DIR__ . '/../dao/ClienteDAO.php';

class ClienteController {

    public ClienteDAO $clienteDAO;
    
    public function __construct() {
        $this->clienteDAO = new ClienteDAO();
    }
    
    public function listar() {
        $clientes = $this->clienteDAO->listar();
        include __DIR__ . '/../view/cliente/listar.php';
    }
    
    public function inserir() {
        $cliente = new Cliente();
        $erro = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente->setNome($_POST['nome']);
            $cliente->setTelefone($_POST['telefone']);
            $cliente->setEmail($_POST['email']);
            
            $erro = $this->clienteDAO->inserir($cliente);
            
            if ($erro === null) {
                header('Location: listar.php?sucesso=1');
                exit;
            }
        }
        
        include __DIR__ . '/../view/cliente/cadastrar.php';
    }

    public function alterar() {
        $cliente = null;
        $erro = null;

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $cliente = $this->clienteDAO->buscarPorId($id);
            if (!$cliente) {
                header('Location: listar.php');
                exit;
            }
            include __DIR__ . '/../view/cliente/alterar.php';
            return;
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente = new Cliente();
            $cliente->setId($_POST['id']);
            $cliente->setNome($_POST['nome']);
            $cliente->setTelefone($_POST['telefone']);
            $cliente->setEmail($_POST['email']);

            $erro = $this->clienteDAO->alterar($cliente);
            if ($erro === null) {
                header('Location: listar.php?sucesso=1');
                exit;
            }
            // Se houver erro, exibe o formulário novamente
            include __DIR__ . '/../view/cliente/alterar.php';
            return;
        }
        // Se não for GET nem POST, redireciona
        header('Location: listar.php');
        exit;
    }
    
    public function excluir() {
        $erro = null;

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $erro = $this->clienteDAO->excluirPorId($id);

            if ($erro === null) {
                header('Location: listar.php?sucesso=1');
                exit;
            } else {
                header('Location: listar.php?erro=' . urlencode($erro->getMessage()));
                exit;
            }
        }

        header('Location: listar.php?erro=ID não informado');
        exit;
    }

    public function buscarPorId($id) {
        return $this->clienteDAO->buscarPorId($id);
    }
}
?>