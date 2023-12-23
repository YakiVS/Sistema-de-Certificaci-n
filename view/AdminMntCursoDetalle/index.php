<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usu_id"])) {

?>

  <!DOCTYPE html>
  <html lang="es">

  <head>
    <?php require_once("../html/mainHead.php"); ?>
    <title>El Tecnologico : : MntDetalleCursoUsuario</title>
  </head>

  <body>

    <?php require_once("../html/mainMenu.php"); ?>

    <?php require_once("../html/mainHeader.php"); ?>

    <div class="br-mainpanel">
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="#">Detalle Trámite</a>
        </nav>
      </div>
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Detalle Trámite</h4>
        <p class="mg-b-0">Mantenimiento</p>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Detalle Trámite</h6>
          <p class="mg-b-30 tx-gray-600">Listado de los trámites de certificados</p>
         
            <button class="btn btn-outline-primary" id="add_button" onclick="nuevo()"><i class="fa fa-plus-square mg-r-10"></i> Nuevo Registro</button>
            <button class="btn btn-outline-primary" id="btnplantilla"><i class="fa fa-gear mg-r-10"></i> Subir Plantilla</button>

            <p></p>
          
                <div class="table-wrapper">
                  <table id="detalle_data" class="table display responsive nowrap">
                    <thead>
                      <tr>
                        <th class="wd-15p">Curso</th>
                        <th class="wd-15p">DNI</th>
                        <th class="wd-15p">Nota</th>
                        <th class="wd-15p">Fech. Emision</th>
                        <th class="wd-10p"></th>
                        <th class="wd-10p"></th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>
              
        </div>
      </div>
    </div>

    <?php require_once("modalmantenimiento.php") ?>
    <?php require_once("modalplantilla.php"); ?>
    
    <?php require_once("../html/mainJs.php") ?>
    <script type="text/javascript" src="adminmntcursodetalle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script>
  </body>

  </html>

<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>