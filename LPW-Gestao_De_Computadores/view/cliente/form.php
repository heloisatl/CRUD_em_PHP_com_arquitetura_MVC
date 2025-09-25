<?php

include_once(__DIR__ . "/../include/header.php"); 
?>

<link rel="stylesheet" href="../estilo/style.css">


<style>

</style>


<div class="form-card">
    <div class="form-tabs">
        <div class="form-tab flex-fill text-center active" style="color:#000;border-radius:16px 16px 0 0; font-weight:bold;">Novo Cliente</div>
    </div>
    <div class="form-avatar">
        <div class="form-avatar-icon">
            <svg width="32" height="32" fill="#b0b0b0" viewBox="0 0 16 16">
                <path d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37c.69-1.19 2.065-2.37 5.468-2.37s4.778 1.18 5.468 2.37A7 7 0 0 0 8 1z"/>
            </svg>
        </div>
    </div>
    <form method="POST" action="">
        <div class="form-group">
            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone" required>
        </div>
        <div class="form-group">
            <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Salvar</button>
    </form>
    <div class="form-footer">
        <a href="listar.php">Voltar para listagem</a>
    </div>
</div>

<?php include_once(__DIR__ . "/../include/footer.php"); ?>