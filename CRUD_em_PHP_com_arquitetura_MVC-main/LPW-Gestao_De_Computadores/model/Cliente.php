<?php


class Cliente
{
    private $id;
    private $nome;
    private $telefone;
    private $email;
    private ?TipoServico $tipoServico;
    private ?OrdemServico $ordem_servico;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNome()
    {
        return $this->nome;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getTipoServico(): ?TipoServico
    {
        return $this->tipoServico;
    }
    public function setTipoServico(?TipoServico $tipoServico): self
    {
        $this->tipoServico = $tipoServico;
        return $this;
    }

    public function getOrdemServico(): ?OrdemServico {
        return $this->ordem_servico;
    }
    public function setOrdemServico(?OrdemServico $ordem_servico): self
    {
        $this->ordem_servico = $ordem_servico;
        return $this;
    }
}
