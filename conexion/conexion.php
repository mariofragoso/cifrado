<?php

    session_start();

class Conectar {

    protected $dbh;

    protected function conexion(){


        try {

            $conectar = $this->dbh = new PDO("mysql:local=127.0.0.1;dbname=cifrado","root","");

            return $conectar;

        } catch (Exception $e) {

            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();

        }



    } //cierre de llave de la function conexion()


    public function set_names(){

        return $this->dbh->query("SET NAMES 'utf8'");
    }


    public function ruta(){

        return "http://127.0.0.1/cifrado/";
    }

}//cierre de llave conectar

?>
