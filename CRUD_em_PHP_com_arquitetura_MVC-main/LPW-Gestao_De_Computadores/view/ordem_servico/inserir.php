<?php


require_once '../../model/Cliente.php';
require_once '/../../controller/OrdemServicoController.php';


$msgErro = "";
$cliente = null;

//recebendo os dados do formulário
if(isset($_POST['nome'])) {

    //Usuário já clicou no botão de gravar

    $nome = trim($_POST['nome']) ? trim($_POST['nome']) : NULL ;
    $telefone = trim($_POST['telefone']) ? trim($_POST['telefone']) : NULL ;
    $email = trim($_POST['email']) ? trim($_POST['email']) : NULL;


    //Criando um objeto Cliente para persistí-lo e atribuindo os dados do formulário:
    $cliente = new Cliente();
    $cliente->setNome($nome);
    $cliente->setTelefone($telefone);
    $cliente->setEmail($email);
    

    if($idOrdemServico) {
        $ordemServico = new OrdemServico(); //MAY AINDA VAI FAZER O DAO DE CADA UM
        $ordemServico->setId($idOrdemServico);
        $cliente->setOrdemServico($ordemServico);

    } else{
        $cliente->setOrdemServico(NULL);
    }
    //print_r($cliente);   

    if($tipoServico) {
        $tipoServico = new TipoServico(); //MAY AINDA VAI FAZER O DAO DE CADA UM
        $tipoServico->setId($idTipoServico);
        $cliente->setTipoServico($tipoServico);
        
    } else{
        $cliente->setTipoServico(NULL);
    }
    //print_r($cliente); 

    //Chamar  o DAO para salvar o objeto cliente
    $clienteCont = new ClienteController();
    $erros = $clienteCont->inserir($cliente);

    
    if(! $erros) {
        //Redirecionar para o listar
        header("location: listar.php");
    } else {
        //Converter o array de erros para string
        $msgErro = implode("<br>", $erros);
    }
}
include_once(__DIR__ . "/form.php");
?>