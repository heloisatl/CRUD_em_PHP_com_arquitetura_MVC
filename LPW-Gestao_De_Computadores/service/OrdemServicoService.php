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
        } elseif (!in_array($ordemServico->getStatus(), ['Aberto', 'Em Progresso', 'Concluído', 'Cancelado'])) {
            $erros[] = "O status informado é inválido.";
        }

        if (empty($ordemServico->getIdCliente()) || !is_numeric($ordemServico->getIdCliente())) {
            $erros[] = "O ID do cliente é obrigatório e deve ser numérico.";
        }

        if (empty($ordemServico->getIdTipoServico()) || !is_numeric($ordemServico->getIdTipoServico())) {
            $erros[] = "O ID do tipo de serviço é obrigatório e deve ser numérico.";
        }

        return $erros;
    }
}
