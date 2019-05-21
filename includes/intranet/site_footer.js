
$(document).ready(function () {
  $("#buscador").click(function () {
    console.log($("#input-search").val());
    $("#input-search").val() == "" ? $(".highlight").css("background-color", "initial") : $('body').highlight($("#input-search").val());
  });

  $(".añadirObject").click(function () {
    $(".listar").addClass("ocultar");
    $(".añadir").removeClass("ocultar");
    $(".editarFormulario").removeClass("mostrar");
    $(".editarFormulario").addClass("ocultar");
  });

  $(".listarObject").click(function () {
    $(".añadir").addClass("ocultar");
    $(".listar").removeClass("ocultar");
    $(".editarFormulario").removeClass("mostrar");
    $(".editarFormulario").addClass("ocultar");

  });



});//fin 

function delete_post(id, categoria) {

  var ok = confirm("¿ Seguro que desea borrar ? ");
  if (!ok) {
    return false;
  }
  else {
    //location.href = "../lib/api.php?apiMethod=delete&categoria="+categoria+"&id="+ id;
    alert("entro en else"+id+"-"+categoria);
    $.ajax({
      url: "../lib/api.php",
      method: "post",
      data: { apiMethod: 'delete', id: id, categoria: categoria },
      error: function(data){
          alert("peto");
      },
      success: function (data) {
        if (data['type'] == 'ok') {
          alert("entro aqui");
          // window.location.href = "intranet/index.php?page=Administradores";
          location.reload();
        }
        if (data['type'] == 'error') {
          window.location.href = "intranet/index.php?page=Administradores";
          location.reload();
        }

      }
    });
  }
  return false;
}
