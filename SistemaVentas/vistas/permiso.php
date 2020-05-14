 <?php  
 //Activamos el almacenamiento en el buffer
 ob_start();
 session_start();

 if (!isset($_SESSION["nombre"])) {
   header("Location: login.html");
 }
 else{
 require 'header.php';
  if ($_SESSION['acceso']==1) {
 ?>

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Permiso <button class="btn btn-success" onclick="mostrarForm(true)" id="btnagregar"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive"  id="listadoRegistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Nombre</th>
                          </thead>
                          <tbody>
                            <th>Nombre</th>
                          </tbody>
                        </table>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

 <?php  
 }

 else{
     require 'noacceso.php';
 }
 
 require 'footer.php';
 ?>

 <script type="text/javascript" src="scripts/permiso.js"></script>

 <?php 
//CERRAMOS EL ELSE
}
//Liberamos el espacio del buffer
ob_end_flush();
?>