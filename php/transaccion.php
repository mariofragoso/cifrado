<?php
/**
 * Created by PhpStorm.
 * User: fragoso
 * Date: 4/03/19
 * Time: 01:04 PM */
require_once("../conexion/conexion.php");

class transaccion extends Conectar
{
    public function login(){

        $conectar=parent::conexion();
        parent::set_names();

        if(isset($_POST["enviar"])){

            //INICIO DE VALIDACIONES
            $pass = $_POST["pass"];

            $correo = $_POST["correo"];


            if(empty($correo) and empty($pass)){

                header("Location:".Conectar::ruta()."vistas/login.html");
                exit();


            }

            else if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){12,15}$/", $pass)) {

                header("Location:".Conectar::ruta()."index.html");
                exit();

            }

            else {

                $sql= "select * from usuarios where correo=? and pass=?";

                $sql=$conectar->prepare($sql);

                $sql->bindValue(1, $correo);
                $sql->bindValue(2, $pass);
                $sql->execute();
                $resultado = $sql->fetch();

                //si existe el registro entonces se conecta en session
                if(is_array($resultado) and count($resultado)>0){

                    /*IMPORTANTE: la session guarda los valores de los campos de la tabla de la bd*/
                    $_SESSION["id"] = $resultado["id"];
                    $_SESSION["correo"] = $resultado["correo"];
                    $_SESSION["nombre"] = $resultado["nombre"];

                    header("Location:".Conectar::ruta()."vistas/index.html");

                    exit();


                } else {

                    //si no existe el registro entonces le aparece un mensaje
                    header("Location:".Conectar::ruta()."vistas/login.html");
                    exit();
                }

            }//cierre del else


        }//condicion enviar
    }


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

    public function registrar_usuario($nombre, $apellidos, $correo, $pass)
    {

        $conectar = parent::conexion();
        parent::set_names();

        $sql = "insert into usuarios values(null,?,?,?,?);";

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, $_POST["nombre"]);
        $sql->bindValue(2, $_POST["apellidos"]);
        $sql->bindValue(3, $_POST["correo"]);
        $sql->bindValue(4, sha1($_POST["pass"]));
        $sql->execute();
    }

    //metodo para editar usuario
    public function editar_usuario($id, $nombre, $apellidos, $correo, $pass)
    {

        $conectar = parent::conexion();
        parent::set_names();

        $sql = "update usuarios set 

              nombre=?,
              apellidos=?,
              correo=?,
              pass=?
              where 
              id=?
              
              ";

        //echo $sql;

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, $_POST["nombre"]);
        $sql->bindValue(2, $_POST["apellidos"]);
        $sql->bindValue(3, $_POST["correo"]);
        $sql->bindValue(4, sha1($_POST["pass"]));
        $sql->bindValue(5, $_POST["id"]);

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
    public function eliminar_usuario($id){

        $conectar=parent::conexion();

        $sql="delete from usuarios where id=?";
        
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$id);
        $sql->execute();

        return $resultado=$sql->fetch();
    }




}

?>


