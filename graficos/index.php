<?php include_once "consultas/index.php"; ?>
<!-- filtro de fechas -->
<div class="row mt-4 d-block">
    <div class="text-center mb-4">
        <input type="month" id="inicio" value="<?php echo $fechas[0][1]; ?>" 
            min="<?php echo $fechas[0][0]; ?>" max="<?php echo $fechas[0][1]; ?>">
        <input type="month" id="fin" value="<?php echo $fechas[0][1]; ?>" 
            min="<?php echo $fechas[0][0]; ?>" max="<?php echo $fechas[0][1]; ?>">
        <button id="filtrarMes" class="btn btn-primary">filtrar</button>
    </div>
</div>

<!-- cards tickets -->
<div class="row d-flex justify-content-between text-center">

    <div class="card text-white bg-info" style="width: 15%;">
        <div class="row no-gutters">
            <div class="col-md-3 align-self-center">
                <i class="fas fa-tags" style="font-size: 38px;"></i>
            </div>
            <div class="col-md-9">
            <div class="card-body" style="padding: 5px;">
                <p id="ticketMes" class="card-text" style="font-size: 25px; font-weight: bold; margin-bottom: 3px;">
                    <?php echo $ticketMes[0]; ?>
                </p>
                <h6 class="card-title">Ticetks generados mes</h6>
            </div>
            </div>
        </div>
    </div>

    <div class="card text-white bg-warning" style="width: 15%;">
        <div class="row no-gutters">
            <div class="col-md-3 align-self-center">
                <i class="far fa-clock" style="font-size: 38px;"></i>
            </div>
            <div class="col-md-9">
            <div class="card-body"  style="padding: 5px;">
                <p id="ticketsEnEspera" class="card-text" style="font-size: 25px; font-weight: bold; margin-bottom: 3px;">
                    <?php echo $ticketEspera[0]; ?>
                </p>
                <h6 class="card-title">Ticetks en espera</h6>
            </div>
            </div>
        </div>
    </div>

    <div class="card text-white bg-danger" style="width: 15%;">
        <div class="row no-gutters">
            <div class="col-md-3 align-self-center">
                <i class="fas fa-plus-square" style="font-size: 38px;"></i>
            </div>
            <div class="col-md-9">
            <div class="card-body"  style="padding: 5px;">
                <p id="ticketsNuevosAsignados" class="card-text" style="font-size: 25px; font-weight: bold; margin-bottom: 3px;">
                    <?php echo $ticketNuevosAsignados[0]; ?>
                </p>
                <h6 class="card-title">Ticetks por gestionar</h6>
            </div>
            </div>
        </div>
    </div>
    
    <div class="card text-white bg-success" style="width: 15%;">
        <div class="row no-gutters">
            <div class="col-md-3 align-self-center">
                <i class="fas fa-check-square" style="font-size: 38px;"></i>
            </div>
            <div class="col-md-9">
            <div class="card-body"  style="padding: 5px;">
                <p id="ticketsSolucionados" class="card-text" style="font-size: 25px; font-weight: bold; margin-bottom: 3px;">
                    <?php echo $ticketResueltos[0]; ?>
                </p>
                <h6 class="card-title">Tickets resueltos</h6>
            </div>
            </div>
        </div>
    </div>

    <div class="card text-white bg-secondary" style="width: 15%;">
        <div class="row no-gutters">
            <div class="col-md-3 align-self-center">
                <i class="fas fa-times-circle" style="font-size: 38px;"></i>
            </div>
            <div class="col-md-9">
            <div class="card-body"  style="padding: 5px;">
                <p id="ticketsCerrados" class="card-text" style="font-size: 25px; font-weight: bold; margin-bottom: 3px;">
                    <?php echo $ticketCerrados[0]; ?>
                </p>
                <h6 class="card-title">Ticetks cerrados</h6>
            </div>
            </div>
        </div>
    </div>

    <div class="card text-white bg-primary" style="width: 15%;">
        <div class="row no-gutters">
            <div class="col-md-3 align-self-center">
                <i class="fas fa-smile" style="font-size: 38px;"></i>
            </div>
            <div class="col-md-9">
            <div class="card-body"  style="padding: 5px;">
                <p id="satisfaccion" class="card-text" style="font-size: 25px; font-weight: bold; margin-bottom: 3px;">
                    <?php echo $satisfaccion[0]; ?> %
                </p>
                <h6 class="card-title">Satisfacción general</h6>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4 mb-5">
    <!--En este container se muestran los gráficos-->
    <div id="contenedor" class="m-auto"></div>
</div>

<script type="text/javascript">
let mes = document.getElementById("filtrarMes")
mes.addEventListener("click", function(){
    $.ajax({
        url:"consultas/casos/indexDashboard.php",
        type: "POST",
        dataType:"json",
        success:function(data){
            let inicio = document.getElementById("inicio").value
            let fin = document.getElementById("fin").value

            let ticketsMes = []
            let ticketsEnEspera = []
            let ticketsNuevosAsignados = []
            let ticketsSolucionados = []
            let ticketsCerrados = []
            let satisfaccion = []

            for (let j = 0; j < data.ticketsMes.length; j++) {
                if (data.ticketsMes[j].mes >= inicio && data.ticketsMes[j].mes <= fin) {
                    if(ticketsMes.length == 0){
                        ticketsMes.push(data.ticketsMes[j].casos)
                    }else{
                        ticketsMes[0] = data.ticketsMes[j].casos + ticketsMes[0]
                    }
                }
            }

            for (let j = 0; j < data.ticketsEnEspera.length; j++) {
                if (data.ticketsEnEspera[j].mes >= inicio && data.ticketsEnEspera[j].mes <= fin) {
                    if(ticketsEnEspera.length == 0){
                        ticketsEnEspera.push(data.ticketsEnEspera[j].casos)
                    }else{
                        ticketsEnEspera[0] = data.ticketsEnEspera[j].casos + ticketsEnEspera[0]
                    }
                }
            }

            for (let j = 0; j < data.ticketsNuevosAsignados.length; j++) {
                if (data.ticketsNuevosAsignados[j].mes >= inicio && data.ticketsNuevosAsignados[j].mes <= fin) {
                    if(ticketsNuevosAsignados.length == 0){
                        ticketsNuevosAsignados.push(data.ticketsNuevosAsignados[j].casos)
                    }else{
                        ticketsNuevosAsignados[0] = data.ticketsNuevosAsignados[j].casos + ticketsNuevosAsignados[0]
                    }
                }
            }

            for (let j = 0; j < data.ticketsSolucionados.length; j++) {
                if (data.ticketsSolucionados[j].mes >= inicio && data.ticketsSolucionados[j].mes <= fin) {
                    if(ticketsSolucionados.length == 0){
                        ticketsSolucionados.push(data.ticketsSolucionados[j].casos)
                    }else{
                        ticketsSolucionados[0] = data.ticketsSolucionados[j].casos + ticketsSolucionados[0]
                    }
                }
            }

            for (let j = 0; j < data.ticketsCerrados.length; j++) {
                if (data.ticketsCerrados[j].mes >= inicio && data.ticketsCerrados[j].mes <= fin) {
                    if(ticketsCerrados.length == 0){
                        ticketsCerrados.push(data.ticketsCerrados[j].casos)
                    }else{
                        ticketsCerrados[0] = data.ticketsCerrados[j].casos + ticketsCerrados[0]
                    }
                }
            }
            let x = 1;
            for (let j = 0; j < data.satisfaccion.length; j++) {
                if (data.satisfaccion[j].mes >= inicio && data.satisfaccion[j].mes <= fin) {
                    if(satisfaccion.length == 0){
                        satisfaccion.push(data.satisfaccion[j].promedio)
                    }else{
                        satisfaccion[0] = data.satisfaccion[j].promedio + satisfaccion[0]
                        x = x + 1
                    }
                }
            }

            promedio = (satisfaccion[0] / x).toFixed(2)
            $(document).ready(function()
            {
                $("#ticketMes").text(ticketsMes[0]);
                $("#ticketsEnEspera").text(ticketsEnEspera[0]);
                $("#ticketsNuevosAsignados").text(ticketsNuevosAsignados[0]);
                $("#ticketsSolucionados").text(ticketsSolucionados[0]);
                $("#ticketsCerrados").text(ticketsCerrados[0]);
                $("#satisfaccion").text(promedio + "%");
            })
        }
    });
})
</script>