 <?php  

//Activamos el almacenamiento en el buffer
 ob_start();
 session_start();

 if (!isset($_SESSION["nombre"])) {
   header("Location: login.html");
 }
 else{


 require 'header.php';

 if ($_SESSION['almacen']==1) {

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
                          <h1 class="box-title">Articulo <button class="btn btn-success" onclick="mostrarForm(true)" id="btnagregar"><i class="fa fa-plus-circle"></i> Agregar</button> <a target="_blank" href="../reportes/rptarticulos.php"><button class="btn btn-info">Reporte</button></a></h1>
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
                            <th>Categoria</th>
                            <th>Codigo</th>
                            <th>Stock</th>
                            <th>Imagen</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Codigo</th>
                            <th>Stock</th>
                            <th>Imagen</th>
                            <th>Estado</th>
                          </tbody>
                        </table>
                    </div>
                    <div class="panel-body" " id="formularioRegistros">
                        <form  name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Nombre:</label>
                            <input type="hidden" name="idarticulo" id="idarticulo">
                            <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Categoria(*):</label>
                            <select name="idcategoria" id="idcategoria" class="form-control selectpicker"   required>
                            </select>

                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Stock(*):</label>
                            <input class="form-control" type="number" name="stock" id="stock" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Descripcion:</label>
                            <input class="form-control" type="text" name="descripcion" id="descripcion" maxlength="256" placeholder="Descripcion">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Imagen:</label>
                            <input class="form-control" type="file" name="imagen" id="imagen">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <img src="" width="150px" height="120px" id="imagemuestra">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Codigo:</label>
                            <input class="form-control" type="text" name="codigo" id="codigo" placeholder="Codigo de barras">
                            <button class="btn btn-success" type="button" onclick="generarbarcode()">Generar</button>
                            <button class="btn btn-info" type="button" onclick="imprimir()">Imprimir</button>
                            <div id="print">
                              <svg id="barcode"></svg>
                            </div>
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

<script type="text/javascript" src="../public/js/JsBarcode.all.min.js"></script>
<script type="text/javascript" src="../public/js/jquery.PrintArea.js"></script>
 <script type="text/javascript" src="scripts/articulo.js"></script>

 <?php 
//CERRAMOS EL ELSE
}
//Liberamos el espacio del buffer
ob_end_flush();
?>