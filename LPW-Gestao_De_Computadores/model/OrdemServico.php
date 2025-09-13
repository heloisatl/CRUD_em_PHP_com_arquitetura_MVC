<?php


class OrdemServico {
    private $id;
    private $descricao_problema;
    private $data_entrada;
    private $prazo_estimado_saida;
   


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of descricao_problema
     */
    public function getDescricaoProblema()
    {
        return $this->descricao_problema;
    }

    /**
     * Set the value of descricao_problema
     */
    public function setDescricaoProblema($descricao_problema): self
    {
        $this->descricao_problema = $descricao_problema;

        return $this;
    }

    /**
     * Get the value of data_entrada
     */
    public function getDataEntrada()
    {
        return $this->data_entrada;
    }

    /**
     * Set the value of data_entrada
     */
    public function setDataEntrada($data_entrada): self
    {
        $this->data_entrada = $data_entrada;

        return $this;
    }

    /**
     * Get the value of prazo_estimado_saida
     */
    public function getPrazoEstimadoSaida()
    {
        return $this->prazo_estimado_saida;
    }

    /**
     * Set the value of prazo_estimado_saida
     */
    public function setPrazoEstimadoSaida($prazo_estimado_saida): self
    {
        $this->prazo_estimado_saida = $prazo_estimado_saida;

        return $this;
    }
}