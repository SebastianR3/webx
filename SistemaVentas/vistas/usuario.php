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
                          <h1 class="box-title">Usuario <button class="btn btn-success" onclick="mostrarForm(true)" id="btnagregar"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
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
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Login</th>
                            <th>Foto</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Numero</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Login</th>
                            <th>Foto</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" " id="formularioRegistros">
                        <form  name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="">Nombre:</label>
                            <input type="hidden" name="idusuario" id="idusuario">
                            <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Documento(*):</label>
                            <select name="tipo_documento" id="tipo_documento" class="form-control selectpicker"   required>
                              <option value="">Seleccion un tipo de documento...</option>
                              <option value="DNI">DNI</option>
                              <option value="RUC">RUC</option>
                              <option value="CEDULA">CEDULA</option>
                            </select>

                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Numero(*):</label>
                            <input class="form-control" type="text" name="numero" id="numero" placeholder="Numero" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Direccion:</label>
                            <input class="form-control" type="text" name="direccion" id="direccion" maxlength="70" placeholder="Direccion">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Telefono:</label>
                            <input class="form-control" type="text" name="telefono" id="telefono" maxlength="20" placeholder="Telefono">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">E-mail:</label>
                            <input class="form-control" type="email" name="email" id="email" maxlength="50" placeholder="Email">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Cargo:</label>
                            <input class="form-control" type="text" name="cargo" id="cargo" maxlength="20" placeholder="Cargo">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Login:</label>
                            <input class="form-control" type="text" name="login" id="login" maxlength="20" placeholder="Login" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Clave:</label>
                            <input class="form-control" type="password" name="clave" id="clave" maxlength="64" placeholder="Clave" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Permisos</label>
                            <ul id="permiso" style="list-style: none">
                              
                            </ul>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Imagen:</label>
                            <input class="form-control" type="file" name="imagen" id="imagen">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <img src="" width="150px" height="120px" id="imagemuestra">
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
 <script type="text/javascript" src="scripts/usuario.js"></script>

 <?php 
//CERRAMOS EL ELSE
}
//Liberamos el espacio del buffer
ob_end_flush();
?>