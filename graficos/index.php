<?php include_once "consultas/index.php"; ?>

<!-- cards tickets -->
<div class="row d-flex justify-content-between text-center">

    <div class="card col-md-2 text-white bg-info">
        <div class="row no-gutters">
            <div class="col-md-3 align-self-center">
                <i class="fas fa-tags" style="font-size: 38px;"></i>
            </div>
            <div class="col-md-9">
            <div class="card-body" style="padding: 5px;">
                <p class="card-text" style="font-size: 25px; font-weight: bold; margin-bottom: 3px;">
                    <?php echo $ticketMes[0]; ?>
                </p>
                <h6 class="card-title">Ticetks del mes</h6>
            </div>
            </div>
        </div>
    </div>

    <div class="card col-md-2 text-white bg-warning">
        <div class="row no-gutters">
            <div class="col-md-3 align-self-center">
                <i class="far fa-clock" style="font-size: 38px;"></i>
            </div>
            <div class="col-md-9">
            <div class="card-body"  style="padding: 5px;">
                <p class="card-text" style="font-size: 25px; font-weight: bold; margin-bottom: 3px;">
                    <?php echo $ticketEspera[0]; ?>
                </p>
                <h6 class="card-title">Ticetks en espera</h6>
            </div>
            </div>
        </div>
    </div>

    <div class="card col-md-2 text-white bg-danger">
        <div class="row no-gutters">
            <div class="col-md-3 align-self-center">
                <i class="fas fa-plus-square" style="font-size: 38px;"></i>
            </div>
            <div class="col-md-9">
            <div class="card-body"  style="padding: 5px;">
                <p class="card-text" style="font-size: 25px; font-weight: bold; margin-bottom: 3px;">
                    <?php echo $ticketNuevosAsignados[0]; ?>
                </p>
                <h6 class="card-title">Ticetks por gestionar</h6>
            </div>
            </div>
        </div>
    </div>
    
    <div class="card col-md-2 text-white bg-success">
        <div class="row no-gutters">
            <div class="col-md-3 align-self-center">
                <i class="fas fa-check-square" style="font-size: 38px;"></i>
            </div>
            <div class="col-md-9">
            <div class="card-body"  style="padding: 5px;">
                <p class="card-text" style="font-size: 25px; font-weight: bold; margin-bottom: 3px;">
                    <?php echo $ticketResueltos[0]; ?>
                </p>
                <h6 class="card-title">Tickets resueltos</h6>
            </div>
            </div>
        </div>
    </div>

    <div class="card col-md-2 text-white bg-primary">
        <div class="row no-gutters">
            <div class="col-md-3 align-self-center">
                <i class="fas fa-times-circle" style="font-size: 38px;"></i>
            </div>
            <div class="col-md-9">
            <div class="card-body"  style="padding: 5px;">
                <p class="card-text" style="font-size: 25px; font-weight: bold; margin-bottom: 3px;">
                    <?php echo $ticketCerrados[0]; ?>
                </p>
                <h6 class="card-title">Ticetks cerrados</h6>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4 mb-5">
    <!--En este container se muestran los gráficos-->
    <div id="contenedor" class="m-auto"></div>
</div>