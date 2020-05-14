 <?php  
 //Activamos el almacenamiento en el buffer
 ob_start();
 session_start();

 if (!isset($_SESSION["nombre"])) {
   header("Location: login.html");
 }
 else{

 require 'header.php';

if ($_SESSION['compras']==1) {
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
                          <h1 class="box-title">Ingreso <button class="btn btn-success" onclick="mostrarForm(true)" id="btnagregar"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive"  id="listadoRegistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Usuario</th>
                            <th>Documento</th>
                            <th>Numero</th>
                            <th>Total Compra</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Usuario</th>
                            <th>Documento</th>
                            <th>Numero</th>
                            <th>Total Compra</th>
                            <th>Estado</th>
                          </tbody>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioRegistros">
                        <form  name="formulario" id="formulario" method="POST">

                          <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <label for="">Proveedor(*):</label>
                            <input type="hidden" name="idingreso" id="idingreso">
                            <select name="idproveedor" id="idproveedor" class="form-control selectpicker" data-live-search="true" required>
                              
                            </select>
                          </div>

                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label for="">Fecha(*):</label>
                            <input class="form-control" type="date" name="fecha_hora" id="fecha_hora" maxlength="50" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Tipo Comprobante(*):</label>
                            <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required>
                              <option value="Boleta">Boleta</option>
                              <option value="Factura">Factura</option>
                              <option value="Ticket">Ticket</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="">Serie:</label>
                            <input class="form-control" type="text" name="serie_comprobante" id="serie_comprobante" maxlength="7" placeholder="Serie" required>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="">Numero:</label>
                            <input class="form-control" type="text" name="num_comprobante" id="num_comprobante" maxlength="10" placeholder="Número" required>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="">Impuesto:</label>
                            <input class="form-control" type="text" name="impuesto" id="impuesto" maxlength="10" placeholder="Número" required>
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a data-toggle="modal" href="#myModal">
                              <button id="btnAgregarArt" type="button" class="btn btn-primary">
                                <span class="fa fa-plus"></span>
                                Agregar Articulos
                              </button>
                            </a>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                <th>Opciones</th>
                                <th>Articulo</th>
                                <th>Cantidad</th>
                                <th>Precio Compra</th>
                                <th>Precio Venta</th>
                                <th>Subtotal</th>
                              </thead>
                              <tfoot>
                                <th>TOTAL </th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><h4 id="total">S/. 0.00</h4><input type="hidden" name="total_compra" id="total_compra"></th>
                              </tfoot>
                              <tbody>
                                
                              </tbody>
                            </table>
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

  <!--Modal-->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelleby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un Articulo</h4>
        </div>
        <div class="modal-body">
          <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
              <th>Opciones</th>
              <th>Nombre</th>
              <th>Categoria</th>
              <th>Codigo</th>
              <th>Stock</th>
              <th>Imagen</th>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
              <th>Opciones</th>
              <th>Nombre</th>
              <th>Categoria</th>
              <th>Codigo</th>
              <th>Stock</th>
              <th>Imagen</th>
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <!--Fin-Modal-->

 <?php  
 }

 else{
   require 'noacceso.php';
 }


  require 'footer.php';
 ?>

 <script type="text/javascript" src="scripts/ingreso.js"></script>

<?php 
//CERRAMOS EL ELSE
}
//Liberamos el espacio del buffer
ob_end_flush();
?>