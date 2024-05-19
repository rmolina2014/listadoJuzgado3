 <!--menu lateral-->
 <?php include("sesion.php");?>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->

    <a href="../../index3.html" class="brand-link ">
      <p class="text-center">
        <span class="brand-text font-weight-light font-weight-bold">Aplicaciones</span></p>
    </a>

    
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <!--img src="../img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"-->
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $NOMBRE_USUARIO;?></a>
        </div>
      </div>

     

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="../cpanel/index.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Panel de Control
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="../listado_comisarias/index.php" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Memorandum para Comisarías
              </p>
            </a>
            
          </li>

          <li class="nav-item">
            <a href="../listado_libre/index.php" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Notas Libres
              </p>
            </a>
            
          </li>

          <li class="nav-item">
            <a href="../plazos_vencidos/index.php" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Plazos Vencidos
              </p>
            </a>
            
          </li>

          <li class="nav-item">
            <a href="../oficio_remision/index.php" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Oficio de Remisíon 
              </p>
            </a>
            
          </li>


          <li class="nav-item">
            <a href="../rebeldias/index.php" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Rebeldias (Atajos) 
              </p>
            </a>
          </li>

         <li class="nav-item">
            <a href="../cedulas_sin_retorno/datos_imprimir.php" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p style="text-decoration-color: green ;">
                Cedulas Sin Retorno (desde Comisarias)
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="../listado_secuestros/index.php" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p style="text-decoration-color: green ;">
                Listado de Secuestro
              </p>
            </a>
          </li>

          
          <li class="nav-item">
            <a href="../salir.php" class="nav-link">
              <i class="nav-icon fas fa-times"></i>
              <p>Salir</p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>