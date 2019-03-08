<?php
/**
 * Created by PhpStorm.
 * User: fragoso
 * Date: 7/03/19
 * Time: 05:29 PM
 */

//Llamar a la base de datos
require_once("../conexion/conexion.php");
//llamar a las consultas
require_once("transaccion.php");

$transaccion = new transaccion();
//declaramos las variables de los valores que se envian por el formulario y que recibimos por ajax y
// decimos que si existe el parametro que estamos recibiendo

$id = isset($_POST["id"]);
$nombre = isset($_POST["nombre"]);
$apellidos = isset($_POST["apellidos"]);
$correo = isset($_POST["correo"]);
$pass = isset($_POST["pass"]);
$pass2 = isset($_POST["pass2"]);

switch ($_GET["op"]) {

    case "guardaryeditar":

//verificamos si existe el correo en la base de datos, si ya existe un registro con la cedula o correo entonces no se registra el usuario

        $datos = $transaccion->get_correo_del_usuario($_POST["correo"]);

        //validacion de la contraseña
        if ($pass == $pass2) {

            /*si el id no existe entonces lo registra
             importante: se debe poner el $_POST sino no funciona*/

            if (empty($_POST["id"])) {

                /*si coincide pass1 y pass2 entonces verificamos si existe el correo en la base de datos, si ya existe un registro con el correo entonces no se registra el usuario*/

                if (is_array($datos) == true and count($datos) == 0) {

                    //no existe el usuario por lo tanto hacemos el registros

                    $transaccion->registrar_usuario($nombre, $apellidos, $correo, $pass, $pass2);

                    $messages[] = "El usuario se registró correctamente";

                    /*si ya exista el correo entonces aparece el mensaje*/

                } else {

                    $messages[] = "El correo ya existe";

                }

            } //cierre de la validacion empty

            else {

                /*si ya existe entonces editamos el usuario*/

                $transaccion->editar_usuario($id, $nombre, $apellidos, $correo, $pass, $pass2);

                $messages[] = "El usuario se editó correctamente";
            }


        } else {

            /*si el password no conincide, entonces se muestra el mensaje de error*/

            $errors[] = "Las contraseñas no coinciden ";
        }


        //mensaje success
        if (isset($messages)) {

            ?>
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>¡Bien hecho!</strong>
                <?php
                foreach ($messages as $message) {
                    echo $message;
                }
                ?>
            </div>
            <?php
        }
        //fin success

        //mensaje error
        if (isset($errors)) {

            ?>
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error!</strong>
                <?php
                foreach ($errors as $error) {
                    echo $error;
                }
                ?>
            </div>
            <?php

        }

        //fin mensaje error


        break;

    case "mostrar":

        //selecciona el id del usuario

        //el parametro id_usuario se envia por AJAX cuando se edita el usuario

        $datos = $transaccion->get_usuario_por_id($_POST["id"]);

        //validacion del id del usuario

        if (is_array($datos) == true and count($datos) > 0) {

            foreach ($datos as $row) {

                $output["nombre"] = $row["nombre"];
                $output["apellidos"] = $row["apellidos"];
                $output["correo"] = $row["correo"];
                $output["pass"] = $row["pass"];
                $output["pass2"] = $row["pass2"];
            }

            echo json_encode($output);

        } else {

            //si no existe el registro entonces no recorre el array
            $errors[] = "El usuario no existe";

        }


        //inicio de mensaje de error

        if (isset($errors)) {

            ?>
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error!</strong>
                <?php
                foreach ($errors as $error) {
                    echo $error;
                }
                ?>
            </div>
            <?php
        }

        //fin de mensaje de error

        break;
    case "listar":

        $datos = $transaccion->get_usuarios();

        //declaramos el array

        $data = Array();


        foreach ($datos as $row) {


            $sub_array = array();

            $sub_array[] = $row["nombre"];
            $sub_array[] = $row["apellidos"];
            $sub_array[] = $row["correo"];


            $sub_array[] = '<button type="button" onClick="mostrar(' . $row["id"] . ');"  id="' . $row["id"] . '" class="btn btn-warning btn-md update"><i class="glyphicon glyphicon-edit"></i> Editar</button>';


            $sub_array[] = '<button type="button" onClick="eliminar(' . $row["id"] . ');"  id="' . $row["id"] . '" class="btn btn-danger btn-md"><i class="glyphicon glyphicon-edit"></i> Eliminar</button>';


            $data[] = $sub_array;


        }

        $results = array(

            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data);
        echo json_encode($results);


        break;


}

?>