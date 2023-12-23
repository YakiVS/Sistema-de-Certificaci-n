<?php
    class Usuario extends Conectar{
        /*TODO: Funcion para login de acceso del usuario */
        public function login(){
            $conectar=parent::conexion();
            parent::set_names();
            if(isset($_POST["enviar"])){
                $correo = $_POST["usu_correo"];
                $pass = $_POST["usu_pass"];
                if(empty($correo) and empty($pass)){
                    /*TODO: En caso esten vacios correo y contraseña, devolver al index con mensaje = 2 */
                    header("Location:".conectar::ruta()."index.php?m=2");
					exit();
                }else{
                    $sql = "SELECT * FROM tm_usuario WHERE usu_correo=? and usu_pass=? and est=1";
                    $stmt=$conectar->prepare($sql);
                    $stmt->bindValue(1, $correo);
                    $stmt->bindValue(2, $pass);
                    $stmt->execute();
                    $resultado = $stmt->fetch();
                    if (is_array($resultado) and count($resultado)>0){
                        $_SESSION["usu_id"]=$resultado["usu_id"];
                        $_SESSION["usu_nom"]=$resultado["usu_nom"];
                        $_SESSION["usu_ape"]=$resultado["usu_ape"];
                        $_SESSION["usu_correo"]=$resultado["usu_correo"];
                        $_SESSION["rol_id"]=$resultado["rol_id"];
                        /*TODO: Si todo esta correcto indexar en home */
                        header("Location:".Conectar::ruta()."view/UsuHome/");
                        exit();
                    }else{
                        /*TODO: En caso no coincidan el usuario o la contraseña */
                        header("Location:".conectar::ruta()."index.php?m=1");
                        exit();
                    }
                }
            }
        }

        /*TODO: Mostrar todos los cursos en los cuales esta inscrito un usuario */
        public function get_cursos_x_usuario($usu_dni){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
            td_curso_usuario.curd_id,
            tm_curso.cur_id,
            tm_curso.cur_nom,
            tm_curso.cur_descrip,
            tm_curso.cur_fechini,
            tm_curso.cur_fechfin,
            tm_usuario.usu_nom,
            tm_usuario.usu_apep,
            tm_usuario.usu_apem,
            tm_usuario.usu_dni
            FROM td_curso_usuario INNER JOIN 
            tm_curso ON td_curso_usuario.cur_id = tm_curso.cur_id INNER JOIN
            tm_usuario ON td_curso_usuario.usu_dni = tm_usuario.usu_dni
            WHERE 
            td_curso_usuario.usu_dni = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_dni);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /*TODO: Mostrar todos los cursos en los cuales esta inscrito un usuario */
        public function get_cursos_x_usuario_top10($usu_dni){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                td_curso_usuario.curd_id,
                tm_curso.cur_id,
                tm_curso.cur_nom,
                tm_curso.cur_descrip,
                tm_curso.cur_fechini,
                tm_curso.cur_fechfin,
                tm_usuario.usu_id,
                tm_usuario.usu_nom,
                tm_usuario.usu_apep,
                tm_usuario.usu_apem,
                tm_usuario.usu_dni
                FROM td_curso_usuario INNER JOIN 
                tm_curso ON td_curso_usuario.cur_id = tm_curso.cur_id INNER JOIN
                tm_usuario ON td_curso_usuario.usu_dni = tm_usuario.usu_dni
                WHERE 
                td_curso_usuario.usu_dni = ?
                AND td_curso_usuario.est=1
                LIMIT 10";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_dni);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }


        /*TODO: Cantidad de Cursos por Usuario */
        public function get_total_cursos_x_usuario($usu_dni){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT count(*) as total FROM td_curso_usuario WHERE usu_dni=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_dni);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /*TODO: Cantidad de Cursos por Usuario */
        public function obtener_usu_dni_por_usu_id($usu_id) {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT usu_dni FROM tm_usuario WHERE usu_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            $resultado = $sql->fetch(PDO::FETCH_ASSOC);

            return ($resultado) ? $resultado['usu_dni'] : null;
        }

        public  function get_cursos_usuario_x_id($cur_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                td_curso_usuario.curd_id,
                tm_curso.cur_id,
                tm_curso.cur_nom,
                tm_curso.cur_descrip,
                tm_curso.cur_fechini,
                tm_curso.cur_fechfin,
                tm_usuario.usu_id,
                tm_usuario.usu_nom,
                tm_usuario.usu_apep,
                tm_usuario.usu_apem,
                tm_usuario.usu_dni
                FROM td_curso_usuario INNER JOIN 
                tm_curso ON td_curso_usuario.cur_id = tm_curso.cur_id INNER JOIN
                tm_usuario ON td_curso_usuario.usu_dni = tm_usuario.usu_dni
                WHERE 
                tm_curso.cur_id = ?
                AND td_curso_usuario.est=1";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cur_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

         /*TODO: Mostrar todos los datos de un curso por su id de detalle */
         public function get_curso_x_id_detalle($curd_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                td_curso_usuario.curd_id,
                td_curso_usuario.curd_nota,
                td_curso_usuario.curd_fechemi,
                tm_curso.cur_id,
                tm_curso.cur_nom,
                tm_curso.cur_descrip,
                tm_curso.cur_fechini,
                tm_curso.cur_fechfin,
                tm_curso.cur_img,
                tm_usuario.usu_id,
                tm_usuario.usu_nom,
                tm_usuario.usu_apep,
                tm_usuario.usu_apem
                FROM td_curso_usuario INNER JOIN 
                tm_curso ON td_curso_usuario.cur_id = tm_curso.cur_id INNER JOIN
                tm_usuario ON td_curso_usuario.usu_dni = tm_usuario.usu_dni
                WHERE 
                td_curso_usuario.curd_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $curd_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }



        /*TODO: Mostrar los datos del usuario segun el ID */
        public function get_usuario_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_usuario WHERE est=1 AND usu_id=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /*TODO: Mostrar los datos del usuario segun el DNI*/
        public function get_usuario_x_dni($usu_dni){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_usuario WHERE est=1 AND usu_dni=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_dni);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /*TODO: Actualizar la informacion del perfil del usuario segun ID */
        public function update_usuario_perfil($usu_id,$usu_nom,$usu_apep,$usu_apem,$usu_pass,$usu_sex,$usu_telf){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_usuario 
                SET
                    usu_nom = ?,
                    usu_apep = ?,
                    usu_apem = ?,
                    usu_pass = ?,
                    usu_sex = ?,
                    usu_telf = ?
                WHERE
                    usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_nom);
            $sql->bindValue(2, $usu_apep);
            $sql->bindValue(3, $usu_apem);
            $sql->bindValue(4, $usu_pass);
            $sql->bindValue(5, $usu_sex);
            $sql->bindValue(6, $usu_telf);
            $sql->bindValue(7, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* Funcion para insertar un usuario nuevo */
        public function insert_usuario($usu_nom,$usu_apep,$usu_apem,$usu_correo,$usu_pass,$usu_sex,$usu_telf,$rol_id,$usu_dni){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO tm_usuario (usu_id,usu_nom,usu_apep,usu_apem,usu_correo,usu_pass,usu_sex,usu_telf,rol_id,usu_dni,fech_crea, est) VALUES (NULL,?,?,?,?,?,?,?,?,?,now(),'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_nom);
            $sql->bindValue(2, $usu_apep);
            $sql->bindValue(3, $usu_apem);
            $sql->bindValue(4, $usu_correo);
            $sql->bindValue(5, $usu_pass);
            $sql->bindValue(6, $usu_sex);
            $sql->bindValue(7, $usu_telf);
            $sql->bindValue(8, $rol_id);
            $sql->bindValue(9, $usu_dni);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* Funcion para actualizar un usuario */
        public function update_usuario($usu_id,$usu_nom,$usu_apep,$usu_apem,$usu_correo,$usu_pass,$usu_sex,$usu_telf,$rol_id,$usu_dni){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_usuario
                SET
                    usu_nom = ?,
                    usu_apep = ?,
                    usu_apem = ?,
                    usu_correo = ?,
                    usu_pass = ?,
                    usu_sex = ?,
                    usu_telf = ?,
                    rol_id = ?,
                    usu_dni = ?
                WHERE
                    usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_nom);
            $sql->bindValue(2, $usu_apep);
            $sql->bindValue(3, $usu_apem);
            $sql->bindValue(4, $usu_correo);
            $sql->bindValue(5, $usu_pass);
            $sql->bindValue(6, $usu_sex);
            $sql->bindValue(7, $usu_telf);
            $sql->bindValue(8, $rol_id);
            $sql->bindValue(9, $usu_dni);
            $sql->bindValue(10, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* Eliminar o cambiar el estado del usuario */
        public function delete_usuario($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_usuario
                SET
                    est = 0
                WHERE
                    usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        
        /*TODO: Listar todas las usuario */
        public function get_usuario(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_usuario WHERE est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /*TODO: Listar todas las categorias */
        public function get_usuario_modal($cur_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_usuario 
                WHERE est = 1
                AND usu_id not in (select usu_id from td_curso_usuario where cur_id=? AND est=1)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cur_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        // En el modelo, agregar la siguiente función para obtener el teléfono del usuario
        public function get_telefono_usuario($usu_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT usu_telf FROM tm_usuario WHERE usu_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado = $sql->fetchColumn();
        }

        // Función para obtener los certificados por el DNI del usuario
        function listarCertificadosPorDNI($usu_dni) {
            $conectar = parent::conexion();
            parent::set_names();

            $sql = "SELECT
                        td_curso_usuario.curd_id,
                        tm_curso.cur_id,
                        tm_curso.cur_nom,
                        tm_curso.cur_descrip,
                        tm_curso.cur_fechini,
                        tm_curso.cur_fechfin
                    FROM
                        td_curso_usuario
                        INNER JOIN tm_curso ON td_curso_usuario.cur_id = tm_curso.cur_id
                    WHERE
                        td_curso_usuario.usu_dni = ?
                        AND td_curso_usuario.est = 1";

            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $usu_dni);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        
    }
?>