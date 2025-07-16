
$("#form_login").submit(function () {
    let user = $("#usuario").val();
    let clave = $("#clave").val();
    var caso = "login";
    if(user != "" && clave != ""){
        $.ajax({
            url: 'login',
            type: 'get',
            data: {usuario:user, clave:clave, caso:caso},
            success: function (resp) {
                //alert(resp);
                var json = JSON.parse(resp);
                //alert(json.access);
                if(json.access == 1){
                    window.location.href = "menu";
                }else{
                    window.location.href = "login";
                }                
            }
        });
    }else{
        Swal.fire({
            title: "Debes llenar todos los campos!",
            text: " ",
            icon: "warning"
        });
    }
    return false;
});

/*menu gabinete - mostrar form */
$("#mgabinete").click(function () {
   //alert('hola');
    var caso = "mgabinete";
    $.ajax({
        url: 'form',
        type: 'get',
        data: {caso: caso },
        success: function (resp) {
            //alert(resp);
            $("#main").html("");
            $("#main").append(resp);
        }
    });    
    return false;
});
/*menu gabinete - reportes form */
$("#mgabineteReportes").click(function () {
    var caso = "mgabineteReportes";
    $.ajax({
        url: 'form',
        type: 'get',
        data: { caso: caso },
        success: function (resp) {
            $("#main").html("");
            $("#main").append(resp);
        }
    });
    return false;
});
/*menu personas - mostrar form */
$("#mpersonas").click(function () {
    var caso = "mpersonas";
    $.ajax({
        url: 'form',
        type: 'get',
        data: {caso: caso },
        success: function (resp) {
            $("#main").html("");
            $("#main").append(resp);
        }
    });
    
    return false;
});
/*menu personas - reportes form */
$("#mpersonasReportes").click(function () {
    var caso = "mpersonasReportes";
    $.ajax({
        url: 'form',
        type: 'get',
        data: { caso: caso },
        success: function (resp) {
            $("#main").html("");
            $("#main").append(resp);
        }
    });
    return false;
});

/*menu gabinete guardar */
$("#frmGabinete").submit(function () {
    
    var caso = $("#caso").val();
    //alert(caso);
    if(caso == "guardarGabinete"){
        //alert('guardar gabinete nuevo');
        $.ajax({
            url: 'gabinete'+'?caso='+caso,
            type: 'post',
            data: $("#frmGabinete").serialize(),
            success: function (resp) {
                Swal.fire({
                    title: "Registro almacenado!",
                    text: "Su registro fué almacenado exitosamente!" + resp,
                    icon: "success"
                  });           
                var caso = "mgabinete";
                $.ajax({
                    url: 'form',
                    type: 'get',
                    data: {caso: caso },
                    success: function (resp) {
                        $("#main").html("");
                        $("#main").append(resp);
                    }
                });
            }
        });
    }else{
       //alert('guardar la actualizacion de datos');
       $.ajax({
            url: 'gabinete'+'?caso='+caso+'&idgabinete='+$("#idgabinete").val(),
            type: 'put',
            data: $("#frmGabinete").serialize(),
            success: function (resp) {
                //alert(resp);
                Swal.fire({
                    title: "Registro actualizado!",
                    text: "Su registro fué actualizado exitosamente!" + resp,
                    icon: "success"
                });           
                var caso = "mgabinete";
                $.ajax({
                    url: 'form',
                    type: 'get',
                    data: {caso: caso },
                    success: function (resp) {
                        $("#main").html("");
                        $("#main").append(resp);
                    }
                });
            }
        });        
    }  
    return false;
});

/*eliminar gabinetes */
function eliminarGabinete(idgabinete) {
    Swal.fire({
        title: "Esta seguro de eliminar este registro?",
        text: "Esta acción no podrá revertirse!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar!"
      }).then((result) => {
        if (result.isConfirmed) {
            var caso = "eliminarGabinete";
            $.ajax({
                url: 'gabinete'+'?caso='+caso+'&idgabinete='+idgabinete,
                type: 'delete',
                success: function (resp) {
                    Swal.fire({
                        title: "Registro eliminado!",
                        text: "Su registro fué eliminado exitosamente!" + resp,
                        icon: "success"
                      });                      
                    var caso = "mgabinete";
                    $.ajax({
                        url: 'form',
                        type: 'get',
                        data: {caso: caso },
                        success: function (resp) {
                            $("#main").html("");
                            $("#main").append(resp);
                        }
                    });
                }
            });         
        }
      });
    return false;
}


/*editar gabinetes */
function editarGabinete(idgabinete) {
    Swal.fire({
        title: "Esta seguro de editar este registro?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, editar!"
      }).then((result) => {
        if (result.isConfirmed) {
            var caso = "buscarGabinete";
            $.ajax({
                url: 'gabinete'+'?caso='+caso+'&idgabinete='+idgabinete,
                type: 'put',
                success: function (resp) {
                    //alert(resp);
                    var json = JSON.parse(resp);
                   // alert(json);
                    $("#nombreGabinete").val(json.nombre);
                    $("#direccion").val(json.direccion);      
                    $("#telefono").val(json.telefono);
                    $("#correo").val(json.correo);
                    $("#caso").val("actualizarGabinete");
                    $("#idgabinete").val(idgabinete);

                }
            });         
        }
      });
    return false;
}