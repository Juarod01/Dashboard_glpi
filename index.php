<?php require_once "vistas/parte_superior.php"; ?>

<!--INICIO del cont principal-->
<div id="chartPpal" class="container">
    <?php 
        require_once "graficos/index.php";
    ?>
</div>

<div id="chartSdo" class="container" style="max-width: 100%;"></div>
<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php"?>