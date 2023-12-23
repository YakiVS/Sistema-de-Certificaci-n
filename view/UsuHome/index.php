<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usu_id"])) {

?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php require_once("../html/mainHead.php"); ?>
    <title>El Tecnologico : : Home</title>
  </head>

  <body>

    <?php require_once("../html/mainMenu.php"); ?>

    <?php require_once("../html/mainHeader.php"); ?>

    <div class="br-mainpanel">
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="#">Inicio</a>
        </nav>
      </div>
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Inicio</h4>
        <p class="mg-b-0">Pantalla Inicio</p>
      </div>

      <!-- Contenido del proyecto -->
      <div class="br-pagebody mg-t-5 pd-x-30">

        <!--  Resumen del total de cursos -->
        <div class="row row-sm">
        <img src="../../public/inicio.png" alt="" style="max-width: 95%; padding-left:110px">
        </div>
      </div>
    </div>
    <?php require_once("../html/mainJs.php") ?>
    <script type="text/javascript" src="usuHome.js"></script>
  </body>

  </html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>