<?php
require_once __DIR__ . '/../model/OrdemServico.php';

class OrdemServicoService
{
    public function validarOrdemServico($ordemServico)
    {
        $erros = [];

        $descricao = trim($ordemServico->getDescricaoProblema());
        if (empty($descricao)) {
            $erros[] = "A descrição do problema é obrigatória.";
        } elseif (strlen($descricao) < 10) {
            $erros[] = "A descrição do problema deve ter pelo menos 10 caracteres.";
        } elseif (strlen($descricao) > 1000) {
            $erros[] = "A descrição do problema deve ter no máximo 1000 caracteres.";
        }

        if (empty($ordemServico->getDataEntrada())) {
            $erros[] = "A data de entrada é obrigatória.";
        } else {
            $dataEntrada = DateTime::createFromFormat('d-m-Y', $ordemServico->getDataEntrada());
            
            // verifica se a data foi criada corretamente
            if (!$dataEntrada) {
                // Se falhou, tenta outro formato
                $dataEntrada = DateTime::createFromFormat('Y-m-d', $ordemServico->getDataEntrada());
            }
            
            // se mesmo assim n criou, a data é invalida
            if (!$dataEntrada) {
                $erros[] = "A data de entrada '{$ordemServico->getDataEntrada()}' é inválida.";
            } else {

                $hoje = new DateTime('today');
                if ($dataEntrada > $hoje) {
                    $erros[] = "A data de entrada não pode ser futura.";
                }
            }
        }

        if (empty($ordemServico->getPrazoEstimadoSaida())) {
            $erros[] = "O prazo estimado de saída é obrigatório.";
        } else {
            //mesma validação da data de entrada
            $prazoEstimado = DateTime::createFromFormat('d-m-Y', $ordemServico->getPrazoEstimadoSaida());
            
            if (!$prazoEstimado) {
               
                $prazoEstimado = DateTime::createFromFormat('Y-m-d', $ordemServico->getPrazoEstimadoSaida());
            }
            
            if ($dataEntrada && $prazoEstimado && $prazoEstimado <= $dataEntrada) {
                $erros[] = "O prazo estimado deve ser posterior à data de entrada.";
            }
        }

        if (empty($ordemServico->getStatus())) {
            $erros[] = "O status é obrigatório.";
        } elseif (!in_array($ordemServico->getStatus(), ['Aberta', 'Em andamento', 'Concluída', 'Cancelada'])) {
            $erros[] = "O status informado é inválido.";
        }

        if ($ordemServico->getCliente() === null) {
            $erros[] = "Cliente é obrigatório.";
        } elseif (!is_numeric($ordemServico->getCliente()->getId()) || $ordemServico->getCliente()->getId() <= 0) {
            $erros[] = "Cliente selecionado é inválido.";
        }

        if ($ordemServico->getTipoServico() === null) {
            $erros[] = "Tipo de serviço é obrigatório.";
        } elseif (!is_numeric($ordemServico->getTipoServico()->getId()) || $ordemServico->getTipoServico()->getId() <= 0) {
            $erros[] = "Tipo de serviço selecionado é inválido.";
        }

        return $erros;
    }
}