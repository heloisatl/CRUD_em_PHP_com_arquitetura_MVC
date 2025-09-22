<?php

require_once __DIR__ . '/../model/OrdemServico.php';

class OrdemServicoService
{

    public function validarOrdemServico($ordemServico)
    {
        $erros = [];

        if (empty($ordemServico->getDescricaoProblema())) {
            $erros[] = "A descrição do problema é obrigatória.";
        }

        if (empty($ordemServico->getDataEntrada())) {
            $erros[] = "A data de entrada é obrigatória.";
        } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $ordemServico->getDataEntrada())) {
            $erros[] = "A data de entrada deve estar no formato AAAA-MM-DD.";
        }

        if (empty($ordemServico->getPrazoEstimadoSaida())) {
            $erros[] = "O prazo estimado de saída é obrigatório.";
        } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $ordemServico->getPrazoEstimadoSaida())) {
            $erros[] = "O prazo estimado de saída deve estar no formato AAAA-MM-DD.";
        }

        if (empty($ordemServico->getStatus())) {
            $erros[] = "O status é obrigatório.";
        } elseif (!in_array($ordemServico->getStatus(), ['Aberta', 'Em andamento', 'Concluída', 'Cancelada'])) {
            $erros[] = "O status informado é inválido.";
        }

        if ($ordemServico->getCliente() === null || !is_numeric($ordemServico->getCliente()->getId())) {
            $erros[] = "Cliente é obrigatório.";
        }

        if ($ordemServico->getTipoServico() === null || !is_numeric($ordemServico->getTipoServico()->getId())) {
            $erros[] = "Tipo de serviço é obrigatório.";
        }

        return $erros;
    }
}