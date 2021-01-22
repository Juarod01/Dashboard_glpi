<!--INICIO del cont principal-->
<div class="container" style="max-width: 95%;">

    <?php include_once "consultas/index.php"; ?>

    <!-- filtro de fechas -->
    <div class="row mt-4 d-block">
        <div class="text-center">
            <input type="month" name="fecha1" id="fecha1" value="<?php echo $fechas[0][2]; ?>" 
                min="<?php echo $fechas[0][0]; ?>" max="<?php echo $fechas[0][1]; ?>">
            <input type="month" name="fecha2" id="fecha2" value="<?php echo $fechas[0][1]; ?>" 
                min="<?php echo $fechas[0][0]; ?>" max="<?php echo $fechas[0][1]; ?>">
        </div>
        <div class="mt-2 text-center">
            <button id="filtrarSatisfaccion" class="btn btn-primary">filtrar</button>
        </div>
    </div>

    <div class="row mt-4 mb-5">
        <!--En este container se muestran los gráficos-->
        <div id="contenedor2" class="m-auto"></div>
        <!-- En este contenedor se muestra la tabla de datos -->
        <div class="m-auto">
            <h5 class="text-center">Tabla de casos por satisfacción</h5>
            <table id="casosSatisfaccion" class="display"></table>
        </div>
    </div>

</div>

<script type="text/javascript">
$("#filtrarSatisfaccion").click(function(){
    let inicio1 = $("#fecha1").val()
    let fin1 = $("#fecha2").val()
    satisfaccion(inicio1, fin1)

    table = $('#casosSatisfaccion').DataTable()
    table.destroy();
    $('#casosSatisfaccion').empty();

    tablaSatisfaccion(inicio, fin)
});
</script>