$(document).ready(function () {
    $("#google").on('click',function () {
        $("#email").hide();
        $("#pass").hide();
    });
    $('#facebook').on('click',function () {
        $('#email').show();
        $('#pass').show();
    });

/**    $('#ingresar').on('click',function () {
        var usr, pass, usuario="mario@gmail.com", password="123";
        usr=$("#email").val();
        pass=$("#pass").val();
        console.log(usr);

        if(usr == usuario &&  pass == password){
            document.getElementById("modalTitle").innerHTML="Bienvenido";
            document.getElementById("m-body").innerHTML="Usted esta ingresando";;
            $("#showModal").modal('show');
            $("#button-modal").on('click',function(){
                window.location.href="index.html";

            });
        }
        else if (usr=="" || pass==""){
            document.getElementById("m-body").innerHTML="Coloca tus datos";

            $("#showModal").modal('show');
            $("#button-modal").on('click',function(){
                window.location.href="login.html";

            });
        }
        else{
            document.getElementById("modalTitle").innerHTML="Verifica tus datos ";
            document.getElementById("m-body").innerHTML="Tus datos son incorrectos";
            $("#showModal").modal('show');
            $("#button-modal").on('click',function(){
                window.location.href="login.html";

            });
        }
    });

*/
    $('#ingresar').on('click', function (event) {
        event.preventDefault();
        var email= $('#email').val();
        var pass= $('#pass').val();
        var data = new FormData();
        data.append('email',email);
        data.append('pass',pass);

        var url= "/cifrado/php/transaccion.php";
        $.ajax({
            url: url,
            type:'POST',
            contentType: false,
            data: data,
            processData: false,
            cache: false,
            dataType: "json",
            success: function(data)
            {
                if (data.tipo==1)
                    alert(data.msg)



                {

                }
                if (data.tipo==2){
                    alert(data.msg)
                }
            },
            error: function(data)
            {
                alert ("Error");
            }

    });
});

});
