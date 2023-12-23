<div class="br-logo"><a href="../UsuHome/"><span></span>El Tecnológico<span></span></a></div>
<div class="br-sideleft overflow-y-auto">
  <label class="sidebar-label pd-x-15 mg-t-20">Menu</label>
  <div class="br-sideleft-menu">

    <a href="../UsuHome/" class="br-menu-link">
      <div class="br-menu-item">
        <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
        <span class="menu-item-label">Inicio</span>
      </div>
    </a>

    <?php
    if ($_SESSION['rol_id'] == 1) {

    ?>
      <a href="../UsuCurso/" class="br-menu-link">
        <div class="br-menu-item">
          <i class="menu-item-icon icon ion-ios-bookmarks-outline tx-24"></i>
          <span class="menu-item-label">Mis Cursos</span>
        </div><!-- menu-item -->
      </a>
    <?php

    } else {
      ?>
      <a href="../AdminMntUsuario/" class="br-menu-link">
        <div class="br-menu-item">
          <i class="menu-item-icon icon ion-ios-bookmarks-outline tx-24"></i>
          <span class="menu-item-label">Mnt. Usuario</span>
        </div><!-- menu-item -->
      </a>

      <a href="../AdminMntCurso/" class="br-menu-link">
        <div class="br-menu-item">
          <i class="menu-item-icon icon ion-ios-bookmarks-outline tx-24"></i>
          <span class="menu-item-label">Mnt. Curso</span>
        </div><!-- menu-item -->
      </a>

      <!-- <a href="../AdminMntInstructor/" class="br-menu-link">
        <div class="br-menu-item">
          <i class="menu-item-icon icon ion-ios-bookmarks-outline tx-24"></i>
          <span class="menu-item-label">Mnt. Instructor</span>
        </div>
      </a> -->

      <a href="../AdminMntCategoria/" class="br-menu-link">
        <div class="br-menu-item">
          <i class="menu-item-icon icon ion-ios-bookmarks-outline tx-24"></i>
          <span class="menu-item-label">Mnt. Categoria</span>
        </div><!-- menu-item -->
      </a>

      <a href="../AdminDetalleCertificado/" class="br-menu-link">
        <div class="br-menu-item">
          <i class="menu-item-icon icon ion-ios-bookmarks-outline tx-24"></i>
          <span class="menu-item-label">Detalle Certificado</span>
        </div><!-- menu-item -->
      </a>

      <a href="../AdminMntCursoDetalle/" class="br-menu-link">
        <div class="br-menu-item">
          <i class="menu-item-icon icon ion-ios-bookmarks-outline tx-24"></i>
          <span class="menu-item-label">Detalle Trámite</span>
        </div><!-- menu-item -->
      </a>

    <?php
    }
    ?>

    <a href="../UsuPerfil/" class="br-menu-link">
      <div class="br-menu-item">
        <i class="menu-item-icon icon ion-ios-gear-outline tx-20"></i>
        <span class="menu-item-label">Perfil</span>
      </div><!-- menu-item -->
    </a>

    <a href="../html/logout.php" class="br-menu-link">
      <div class="br-menu-item">
        <i class="menu-item-icon icon ion-power tx-20"></i>
        <span class="menu-item-label">Cerrar Sesion</span>
      </div><!-- menu-item -->
    </a>
  </div>
</div>