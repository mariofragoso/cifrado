<?php
/**
 * Created by PhpStorm.
 * User: fragoso
 * Date: 4/03/19
 * Time: 01:04 PM */

//include_once('../sql/repositorio.php');

//	$transaccion=$_POST['valorEliminar'];
//	$sqlInsertarEtiqueta= "INSERT INTO herramientas VALUES (NULL, '".$descripcion."', '".$codigo."', '".$valorCategoria."')";
//	$aplicarTransaccion= $mysqli->query($sqlInsertarEtiqueta);
$table="<table  border=\"1\">
  <tr><th>Mensaje</th></tr>
  <tr><td>Hola soy un mensaje</td></tr>
  </table>";

        $email=$_POST['email'];
        $pass=$_POST['pass'];
         if ($email=='mario@gmail.com' and $pass == '123'){
             $data = array(
                 'tipo'=>1,
                 'msg'=>"bienvenido");
             echo json_encode($data);


         }
         else if ($email==''||$pass==''){
             $data = array(
                 'tipo'=>2,
                 'msg'=>"Ingresa Datos");
             echo json_encode($data);

         }

?>
