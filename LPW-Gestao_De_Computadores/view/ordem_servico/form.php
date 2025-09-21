<?php include_once(__DIR__ . "/../include/header.php"); ?>

<h3>Inserir Ordem de Serviço</h3>

<div class="row">
    <div class="col-6">
        <form method="POST" action="">
            <div class="mb-3">
                <label for="descricao_problema" class="form-label">Descrição do Problema</label>
                <input type="text" class="form-control" id="descricao_problema" name="descricao_problema" required value="<?= isset($descricaoProblema) ? htmlspecialchars($descricaoProblema) : '' ?>">
            </div>
            <div class="mb-3">
                <label for="data_entrada" class="form-label">Data de Entrada</label>
                <input type="date" class="form-control" id="data_entrada" name="data_entrada" required value="<?= isset($dataEntrada) ? htmlspecialchars($dataEntrada) : '' ?>">
            </div>
            <div class="mb-3">
                <label for="prazo_estimado_saida" class="form-label">Prazo Estimado de Saída</label>
                <input type="date" class="form-control" id="prazo_estimado_saida" name="prazo_estimado_saida" required value="<?= isset($prazoEstimado) ? htmlspecialchars($prazoEstimado) : '' ?>">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="">Selecione</option>
                    <option value="Aberto" <?= (isset($status) && $status == 'Aberto') ? 'selected' : '' ?>>Aberto</option>
                    <option value="Em Progresso" <?= (isset($status) && $status == 'Em Progresso') ? 'selected' : '' ?>>Em Progresso</option>
                    <option value="Concluído" <?= (isset($status) && $status == 'Concluído') ? 'selected' : '' ?>>Concluído</option>
                    <option value="Cancelado" <?= (isset($status) && $status == 'Cancelado') ? 'selected' : '' ?>>Cancelado</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_cliente" class="form-label">Cliente</label>
                <select class="form-control" id="id_cliente" name="id_cliente" required>
                    <option value="">Selecione</option>
                    <?php foreach ($clientes as $cliente): ?>
                        <option value="<?= $cliente->getId() ?>" <?= (isset($idCliente) && $idCliente == $cliente->getId()) ? 'selected' : '' ?>><?= htmlspecialchars($cliente->getNome()) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_tipo_servico" class="form-label">Tipo de Serviço</label>
                <select class="form-control" id="id_tipo_servico" name="id_tipo_servico" required>
                    <option value="">Selecione</option>
                    <?php foreach ($tiposServico as $tipo): ?>
                        <option value="<?= $tipo->getId() ?>" <?= (isset($idTipoServico) && $idTipoServico == $tipo->getId()) ? 'selected' : '' ?>><?= htmlspecialchars($tipo->getNome()) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-success">Gravar</button>
            </div>
        </form>
    </div>
    <div class="col-6">
        <?php if ($msgErro): ?>
            <div class="alert alert-danger">
                <?= $msgErro ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="mt-2">
    <a href="listar.php" class="btn btn-outline-primary">Voltar</a>
</div>

<?php include_once(__DIR__ . "/../include/footer.php"); ?>