<!--INICIO del cont principal-->
<div class="container" style="max-width: 100%;">

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
            <button id="filtrarCategoria" class="btn btn-primary">filtrar</button>
        </div>
    </div>

    <div class="row mt-4 mb-5">
        <!--En este container se muestran los gráficos-->
        <div id="contenedor2" class="m-auto"></div>
        <!-- En este contenedor se muestra la tabla de datos -->
        <div id="contenedor_tabla" class="m-auto">
            <h5 class="text-center">Tabla de adaptabilidad a SLA</h5>
            <table id="categoriaSla" class="display" width="90%"></table>
            <h5 class="text-center mt-4">Tabla descriptiva de casos con categoria y SLA</h5>
            <table id="categoria" class="display" width="90%"></table>
        </div>
    </div>

</div>

<script type="text/javascript">
$("#filtrarCategoria").click(function(){
    let inicio1 = $("#fecha1").val()
    let fin1 = $("#fecha2").val()
    categoria(inicio1, fin1)

    table1 = $('#categoriaSla').DataTable()
    table1.destroy();
    $('#categoriaSla').empty();

    table = $('#categoria').DataTable()
    table.destroy();
    $('#categoria').empty();

    tablaCategoria(inicio1, fin1)
});
</script>