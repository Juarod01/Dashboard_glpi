<!--INICIO del cont principal-->
<div class="container">

    <?php include_once "consultas/index.php"; ?>

    <!-- filtro de fechas -->
    <div class="row mt-4 d-block">
        <div class="text-center">
            <input type="month" id="inicio1" value="<?php echo $fechas[0][2]; ?>" 
                min="<?php echo $fechas[0][0]; ?>" max="<?php echo $fechas[0][1]; ?>">
            <input type="month" id="fin1" value="<?php echo $fechas[0][1]; ?>" 
                min="<?php echo $fechas[0][0]; ?>" max="<?php echo $fechas[0][1]; ?>">
        </div>
        <div class="mt-2 text-center">
            <button id="filtrarLocalizacion" class="btn btn-primary">filtrar</button>
        </div>
    </div>

    <div class="row mt-4 mb-5">
        <!--En este container se muestran los gráficos-->
        <div id="contenedor2" class="m-auto"></div>
        <!-- En este contenedor se muestra la tabla de datos -->
        <div class="m-auto">
            <h5 class="text-center">Tabla de casos por localización</h5>
            <table id="casosLocalizacion" class="display" width="95%"></table>
        </div>
    </div>

</div>

<script type="text/javascript">
$("#filtrarLocalizacion").click(function(){
    let inicio = document.getElementById("inicio1").value
    let fin = document.getElementById("fin1").value
    localizacion(inicio, fin)

    table = $('#casosLocalizacion').DataTable()
    table.destroy();
    $('#casosLocalizacion').empty();

    tablaLocalizacion(inicio, fin)
});
</script>