var tabla;


//Funcion que se ejectua al inicio
function init() {
    listar();

    //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
    $("#usuario_form").on("submit",function(e)
    {

        guardaryeditar(e);
    })

    //cambia el titulo de la ventana modal cuando se da click al boton
    $("#add_button").click(function(){

        $(".modal-title").text("Agregar Usuario");

    });



}
//funcion que limpia los campos del formulario
function limpiar(){

    $('#nombre').val("");
    $('#apellidos').val("");
    $('#correo').val("");
    $('#pass').val("");
    $('#pass2').val("");
    $('#id').val("");
}
//function listar

function listar(){

    tabla=$('#usuario_data').dataTable({

        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla

        "ajax":

            {
                url: 'php/funcionajax.php?op=listar',
                type : "get",
                dataType : "json",
                error: function(e){
                    console.log(e.responseText);
                }
            },

        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 10,//Por cada 10 registros hace una paginación
        "order": [[ 0, "desc" ]],//Ordenar (columna,orden)

        //cerrando language
    }).DataTable();
}
//Mostrar datos del usuario en la ventana modal del formulario

function mostrar(id){

    $.post("php/funcionajax.php?op=mostrar",{id : id}, function(data, status)

    {

        data = JSON.parse(data);

        $("#usuarioModal").modal("show");
        $('#nombre').val(data.nombre);
        $('#apellidos').val(data.apellidos);
        $('#correo').val(data.correo);
        $('#pass').val(data.pass);
        $('#pass2').val(data.pass);
        $('.modal-title').text("Editar Usuario");
        $('#id').val(id);
        $('#action').val("Edit");


    });

}
//la funcion guardaryeditar(e); se llama cuando se da click al boton submit

function guardaryeditar(e) {

    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#usuario_form")[0]);

    var pass = $("#pass").val();
    var pass2 = $("#pass2").val();

    //si el password conincide entonces se envia el formulario
    if (pass == pass2) {

        $.ajax({

            url: "php/funcionajax.php?op=guardaryeditar",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function (datos) {

                console.log(datos);

                $('#usuario_form')[0].reset();
                $('#usuarioModal').modal('hide');

                $('#resultados_ajax').html(datos);
                $('#usuario_data').DataTable().ajax.reload();

                limpiar();

            }
        });

    } //cierre de la validacion


    else {
        
        bootbox.alert("Las contraseñas con coinciden");
        $('#pass').val("");
        $('#pass2').val("");
        
    }


}

function eliminar(id){

    bootbox.confirm("¿Está Seguro de eliminar el usuario?", function(result){
        if(result)
        {
            $.ajax({
                url:"php/funcionajax.php?op=eliminar_usuario",
                method:"POST",
                data:{id:id},

                success:function(data)
                {
                    //alert(data);
                    $("#resultados_ajax").html(data);
                    $("#usuario_data").DataTable().ajax.reload();
                }
            });

        }

    });


}





init();