<?php
/**
 * Created by PhpStorm.
 * User: fragoso
 * Date: 4/03/19
 * Time: 01:04 PM */
require_once("../conexion/conexion.php");

class transaccion extends Conectar
{
    //listar usuarios
    public function get_usuarios()
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "select * from usuarios";

        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $resultado = $sql->fetchAll();
    }

    //Registrar usuario

    public function registrar_usuario($nombre, $apellidos, $correo, $pass, $pass2)
    {

        $conectar = parent::conexion();
        parent::set_names();

        $sql = "insert into usuarios values(null,?,?,?,?,?);";

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, $_POST["nombre"]);
        $sql->bindValue(2, $_POST["apellidos"]);
        $sql->bindValue(3, $_POST["correo"]);
        $sql->bindValue(4, $_POST["pass"]);
        $sql->bindValue(5, $_POST["pass2"]);

        $sql->execute();
    }

    //metodo para editar usuario
    public function editar_usuario($id, $nombre, $apellidos, $correo, $pass, $pass2)
    {

        $conectar = parent::conexion();
        parent::set_names();

        $sql = "update usuarios set 

              nombre=?,
              apellidos=?,
              correo=?,
              pass=?,
              pass2=?
              where 
              id=?
              
              ";

        //echo $sql;

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, $_POST["nombre"]);
        $sql->bindValue(2, $_POST["apellidos"]);
        $sql->bindValue(3, $_POST["correo"]);
        $sql->bindValue(4, $_POST["pass"]);
        $sql->bindValue(5, $_POST["pass2"]);
        $sql->bindValue(6, $_POST["id"]);

        $sql->execute();


    }
    //mostrar los datos del usuario por el id
    public function get_usuario_por_id($id){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="select * from usuarios where id=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $id);
        $sql->execute();

        return $resultado=$sql->fetchAll();

    }
    //valida correo del usuario

    public function get_correo_del_usuario($correo){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="select * from usuarios where correo=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $correo);
        $sql->execute();

        return $resultado=$sql->fetchAll();

    }
}

?>


