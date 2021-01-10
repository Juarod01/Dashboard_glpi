<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Dashboard</title>
  <!-- icon -->
  <link rel="icon" type="image/vnd.microsoft.icon" href="img/favicon.ico">

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="stylesheet" href="vendor/Bootstrap_4/css/bootstrap.min.css" >
  <!--datables CSS básico-->
  <link rel="stylesheet" type="text/css" href="vendor/datatables/datatables.min.css"/>
  <!--datables estilo bootstrap 4 CSS-->  
  <link rel="stylesheet"  type="text/css" href="vendor/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
    
</head>

<body>

  <!-- Main Content -->
  <div id="content">

    <!-- Topbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark topbar mb-4 static-top shadow">
      <div class="container d-flex justify-content-between">
        <div class="row">
          <div id="principal" class="navbar-brand align-self-center" style="cursor: pointer;">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard Helpy</span>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <!-- <li class="nav-item ">
                <a class="nav-link" href="#">Home</a>
              </li> -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Casos</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a id="" class="dropdown-item" onclick="javascript:porEstado();" style="cursor: pointer;">Por estado</a>
                  <a id="" class="dropdown-item" onclick="javascript:porTipo();" style="cursor: pointer;">Por tipo</a>
                  <a id="" class="dropdown-item" onclick="javascript:porLocalizacion();" style="cursor: pointer;">Por localización</a>
                  <a id="" class="dropdown-item" onclick="javascript:porTecnico();" style="cursor: pointer;">Por técnico</a>
                  <a id="" class="dropdown-item" onclick="javascript:porSatisfaccion();" style="cursor: pointer;">Satisfacción</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="align-self-center" style="color: rgba(255,255,255,.5);"> 
            <?php 
                setlocale(LC_ALL, 'Spanish.UTF-8');
                echo ucfirst(strftime("%A") . " - " . strftime("%d") . " " . strftime("%B") . " de " . strftime("%Y"));
            ?>
          </div>
        </div>
      </div>
    </nav>  
    <!-- End of Topbar -->
