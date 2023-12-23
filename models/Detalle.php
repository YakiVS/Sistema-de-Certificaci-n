<?php

    class Detalle extends Conectar {
        public function insert_detalle($cur_id,$usu_dni,$curd_nota,$curd_fechemi){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO td_curso_usuario (curd_id, cur_id, usu_dni, curd_nota,curd_fechemi, fech_crea, est) VALUES (NULL,?,?,?,?, now(),'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cur_id);
            $sql->bindValue(2, $usu_dni);
            $sql->bindValue(3, $curd_nota);
            $sql->bindValue(4, $curd_fechemi);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_detalle($curd_id,$cur_id,$usu_dni,$curd_nota,$curd_fechemi){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE td_curso_usuario
            SET
                cur_id = ?,
                usu_dni= ?,
                curd_nota = ?,
                curd_fechemi = ?
            WHERE
                curd_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cur_id);
            $sql->bindValue(2, $usu_dni);
            $sql->bindValue(3, $curd_nota);
            $sql->bindValue(4, $curd_fechemi);
            $sql->bindValue(5, $curd_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_detalle($curd_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE td_curso_usuario
            SET
                est = 0
            WHERE
                curd_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $curd_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_detalle(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
            td_curso_usuario.curd_id,
            td_curso_usuario.cur_id,
            td_curso_usuario.usu_dni,
            td_curso_usuario.curd_nota,
            td_curso_usuario.curd_fechemi,
            tm_curso.cur_nom
            FROM td_curso_usuario
            INNER JOIN tm_curso on td_curso_usuario.cur_id = tm_curso.cur_id
            WHERE td_curso_usuario.est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_curso(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT
                tm_curso.cur_id,
                tm_curso.cur_nom,
                tm_curso.cur_descrip,
                tm_curso.cur_fechini,
                tm_curso.cur_fechfin,
                tm_curso.cat_id,
                tm_curso.cur_img,
                tm_categoria.cat_nom
                FROM tm_curso
                INNER JOIN tm_categoria on tm_curso.cat_id = tm_categoria.cat_id
                WHERE tm_curso.est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_detalle_id($curd_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM td_curso_usuario WHERE est = 1 AND curd_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $curd_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
    }

?> 