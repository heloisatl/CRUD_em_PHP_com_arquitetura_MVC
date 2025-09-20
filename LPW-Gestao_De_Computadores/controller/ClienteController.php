<?php

// ClienteController.php
require_once '../model/Cliente.php';
require_once '../dao/ClienteDAO.php';

class ClienteController {

    private ClienteDAO $clienteDAO;
    
    public function __construct() {
        $this->clienteDAO = new ClienteDAO();
    }
    
    public function listar() {
        $clientes = $this->clienteDAO->listar();
        include '../view/cliente/listar.php';
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
        
        include '../view/cliente/cadastrar.php';
    }

    public function alterar() {
        $cliente = null;
        $erro = null;
    
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $cliente = $this->clienteDAO->buscarPorId($id);
            if (!$cliente) {
                // Redireciona se o cliente não for encontrado
                header('Location: listar.php');
                exit;
            }
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
        }
    
        include '../view/cliente/alterar.php';
    }
    
    public function excluir() {
        $erro = null;

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $erro = $this->clienteDAO->excluirPorId($id);

            if ($erro === null) {
                header('Location: listar.php?sucesso=1');
                exit;
            }
        }

        header('Location: listar.php?erro=' . urlencode($erro->getMessage()));
        exit;
    }
}
?>