 <?php  
 //Activamos el almacenamiento en el buffer
 ob_start();
 session_start();

 if (!isset($_SESSION["nombre"])) {
   header("Location: login.html");
 }
 else{
 require 'header.php';
 if ($_SESSION['ventas']==1) {
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
                          <h1 class="box-title">Cliente <button class="btn btn-success" onclick="mostrarForm(true)" id="btnagregar"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive"  id="listadoRegistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Numero</th>
                            <th>Telefono</th>
                            <th>Email</th>
                          </thead>
                          <tbody>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Numero</th>
                            <th>Telefono</th>
                            <th>Email</th>
                          </tbody>
                        </table>
                    </div>
                    <div class="panel-body" " id="formularioRegistros">
                        <form  name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Nombre:</label>
                            <input type="hidden" name="idpersona" id="idpersona" >
                            <input type="hidden" name="tipo_persona" id="tipo_persona" value="Cliente">
                            <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100" placeholder="Nombre del Proveedor" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Tipo Documento:</label>
                            <select name="tipo_documento" id="tipo_documento" class="form-control select-picker" required>
                              <option value="DNI">DNI</option>
                              <option value="RUC">RUC</option>
                              <option value="CEDULA">CEDULA</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">

                            <label for="">Numero Documento:</label>

                            <input class="form-control" type="text" name="num_documento" id="num_documento" maxlength="20" placeholder="Documento">

                          </div>

                           <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">

                            <label for="">Direccion:</label>

                            <input class="form-control" type="text" name="direccion" id="direccion" maxlength="70" placeholder="Documento" >

                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">

                            <label for="">Telefono:</label>

                            <input class="form-control" type="text" name="telefono" id="telefono" maxlength="20" placeholder="Telefono" >

                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">

                            <label for="">Email:</label>

                            <input class="form-control" type="email" name="email" id="email" maxlength="50" placeholder="Email" >

                          </div>


                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save">Guardar</i></button>
                            <button class="btn btn-danger" onclick="cancelarForm()" type="button" id="btnCancelar"><i class="fa fa-arrow-circle-left">Cancelar</i></button>

                          </div>
                        </form>
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

 <script type="text/javascript" src="scripts/cliente.js"></script>

 <?php 
//CERRAMOS EL ELSE
}
//Liberamos el espacio del buffer
ob_end_flush();
?>