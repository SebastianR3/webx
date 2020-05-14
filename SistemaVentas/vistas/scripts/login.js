$("#frmAcceso").on('submit',function(e)
{
    e.preventDefault();
    logina=$("#logina").val();
    clavea=$("#clavea").val();

    $.post("../ajax/usuario.php?op=verificar",
        {"logina":logina,"clavea":clavea},
        function(data)
        {

           arreglo=$.trim(data);
           
           if (arreglo!="null") 
           {
               $(location).attr("href","escritorio.php");
           }
           else
           {
               bootbox.alert("Usuario o contraseña incorrecta");
           }
          
          /*
          json=JSON.parse(data);
          
   
             if (json!=null) {
              $(location).attr("href","categoria.php");
             }
             else
             {
              bootbox.alert("Usuario o contraseña incorrecta");
          }

          console.log(data);
           console.log(typeof data);
           console.log(data.length);
          */
        });


});