<?php

require_once(__DIR__ . "/../util/Connection.php");
require_once(__DIR__ . "/../model/OrdemServico.php");
require_once(__DIR__ . "/../model/Cliente.php");
require_once(__DIR__ . "/../model/TipoServico.php");

class OrdemServicoDAO {

    private PDO $conexao;

    public function __construct() {
        $this->conexao = Connection::getConnection();
    }

    public function listar(): array {
        $sql = "SELECT os.*, 
                       cl.id AS cl_id, cl.nome AS cl_nome, cl.telefone, cl.email,
                       ts.id AS ts_id, ts.nome AS ts_nome, ts.descricao AS ts_descricao
                  FROM ordem_servico os
                  LEFT JOIN clientes cl ON os.id_cliente = cl.id
                  LEFT JOIN tipo_servico ts ON os.id_tipo_servico = ts.id
                 ORDER BY os.data_entrada";
        $stm = $this->conexao->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->map($result);
    }

    public function buscarPorId(int $id) {
        $sql = "SELECT os.*, 
                       cl.id AS cl_id, cl.nome AS cl_nome, cl.telefone, cl.email,
                       ts.id AS ts_id, ts.nome AS ts_nome, ts.descricao AS ts_descricao
                  FROM ordem_servico os
                  LEFT JOIN clientes cl ON os.id_cliente = cl.id
                  LEFT JOIN tipo_servico ts ON os.id_tipo_servico = ts.id
                 WHERE os.id = ?";
        $stm = $this->conexao->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $ordens = $this->map($result);

        return count($ordens) > 0 ? $ordens[0] : null;
    }

    public function inserir(OrdemServico $ordem): ?PDOException {
        try {
            $sql = "INSERT INTO ordem_servico 
                        (descricao_problema, data_entrada, prazo_estimado_saida, id_cliente, id_tipo_servico)
                    VALUES (?, ?, ?, ?, ?)";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([
                $ordem->getDescricaoProblema(),
                $ordem->getDataEntrada(),
                $ordem->getPrazoEstimadoSaida(),
                $ordem->getCliente()?->getId(),
                $ordem->getTipoServico()?->getId()
            ]);
            return null;
        } catch(PDOException $e) {
            return $e;
        }
    }

    public function alterar(OrdemServico $ordem): ?PDOException {
        try {
            $sql = "UPDATE ordem_servico
                       SET descricao_problema = ?, data_entrada = ?, prazo_estimado_saida = ?, 
                           id_cliente = ?, id_tipo_servico = ?
                     WHERE id = ?";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([
                $ordem->getDescricaoProblema(),
                $ordem->getDataEntrada(),
                $ordem->getPrazoEstimadoSaida(),
                $ordem->getCliente()?->getId(),
                $ordem->getTipoServico()?->getId(),
                $ordem->getId()
            ]);
            return null;
        } catch(PDOException $e) {
            return $e;
        }
    }

    public function excluirPorId(int $id): ?PDOException {
        try {
            $sql = "DELETE FROM ordem_servico WHERE id = :id";
            $stm = $this->conexao->prepare($sql);
            $stm->bindValue(":id", $id);
            $stm->execute();
            return null;
        } catch(PDOException $e) {
            return $e;
        }
    }

    // Mapeia o resultado do banco para objetos OrdemServico
    private function map(array $result): array {
        $ordens = [];
        foreach($result as $r) {
            $ordem = new OrdemServico();
            $ordem->setId($r["id"]);
            $ordem->setDescricaoProblema($r["descricao_problema"]);
            $ordem->setDataEntrada($r["data_entrada"]);
            $ordem->setPrazoEstimadoSaida($r["prazo_estimado_saida"]);

            if(isset($r["cl_id"])) {
                $cliente = new Cliente();
                $cliente->setId($r["cl_id"]);
                $cliente->setNome($r["cl_nome"]);
                $cliente->setTelefone($r["telefone"]);
                $cliente->setEmail($r["email"]);
                $ordem->setCliente($cliente);
            }

            if(isset($r["ts_id"])) {
                $tipoServico = new TipoServico();
                $tipoServico->setId($r["ts_id"]);
                $tipoServico->setNome($r["ts_nome"]);
                $tipoServico->setDescricao($r["ts_descricao"]);
                $ordem->setTipoServico($tipoServico);
            }

            $ordens[] = $ordem;
        }
        return $ordens;
    }
}
