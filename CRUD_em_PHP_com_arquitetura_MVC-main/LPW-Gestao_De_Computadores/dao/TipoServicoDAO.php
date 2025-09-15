<?php

require_once(__DIR__ . "/../util/Connection.php");
require_once(__DIR__ . "/../model/TipoServico.php");

class TipoServicoDAO {

    private PDO $conexao;

    public function __construct() {
        $this->conexao = Connection::getConnection();
    }

    public function listar(): array {
        $sql = "SELECT * FROM tipo_servico ORDER BY nome";
        $stm = $this->conexao->prepare($sql);
        $stm->execute();
        $resultado = $stm->fetchAll();

        return $this->map($resultado);
    }

    public function buscarPorId(int $id) {
        $sql = "SELECT * FROM tipo_servico WHERE id = ?";
        $stm = $this->conexao->prepare($sql);
        $stm->execute([$id]);
        $resultado = $stm->fetchAll();

        $tipos = $this->map($resultado);

        return count($tipos) > 0 ? $tipos[0] : null;
    }

    public function inserir(TipoServico $tipo): ?PDOException {
        try {
            $sql = "INSERT INTO tipo_servico (nome, descricao) VALUES (?, ?)";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([
                $tipo->getNome(),
                $tipo->getDescricao()
            ]);
            return null;
        } catch(PDOException $e) {
            return $e;
        }
    }

    public function alterar(TipoServico $tipo): ?PDOException {
        try {
            $sql = "UPDATE tipo_servico SET nome = ?, descricao = ? WHERE id = ?";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([
                $tipo->getNome(),
                $tipo->getDescricao(),
                $tipo->getId()
            ]);
            return null;
        } catch(PDOException $e) {
            return $e;
        }
    }

    public function excluirPorId(int $id): ?PDOException {
        try {
            $sql = "DELETE FROM tipo_servico WHERE id = :id";
            $stm = $this->conexao->prepare($sql);
            $stm->bindValue(":id", $id);
            $stm->execute();
            return null;
        } catch(PDOException $e) {
            return $e;
        }
    }

    // Mapeia o resultado do banco para objetos TipoServico
    private function map(array $resultado): array {
        $tipos = [];
        foreach($resultado as $r) {
            $tipo = new TipoServico();
            $tipo->setId($r["id"]);
            $tipo->setNome($r["nome"]);
            $tipo->setDescricao($r["descricao"]);
            $tipos[] = $tipo;
        }
        return $tipos;
    }
}
