<?php
    class Curso extends Conectar{
        
        public function insert_curso($cat_id,$cur_nom,$cur_descrip,$cur_mes,$cur_anio,$cur_fechini,$cur_fechfin){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO tm_curso (cur_id, cat_id, cur_nom, cur_descrip, cur_mes, cur_anio, cur_fechini, cur_fechfin, cur_img, fech_crea, est) VALUES (NULL,?,?,?,?,?,?,?,'../../public/1.png', now(),'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_id);
            $sql->bindValue(2, $cur_nom);
            $sql->bindValue(3, $cur_descrip);
            $sql->bindValue(4, $cur_mes);
            $sql->bindValue(5, $cur_anio);
            $sql->bindValue(6, $cur_fechini);
            $sql->bindValue(7, $cur_fechfin);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_curso($cur_id,$cat_id,$cur_nom,$cur_descrip,$cur_mes,$cur_anio,$cur_fechini,$cur_fechfin){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_curso
                SET
                    cat_id =?,
                    cur_nom = ?,
                    cur_descrip = ?,
                    cur_mes = ?,
                    cur_anio = ?,
                    cur_fechini = ?,
                    cur_fechfin = ?
                WHERE
                    cur_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_id);
            $sql->bindValue(2, $cur_nom);
            $sql->bindValue(3, $cur_descrip);
            $sql->bindValue(4, $cur_mes);
            $sql->bindValue(5, $cur_anio);
            $sql->bindValue(6, $cur_fechini);
            $sql->bindValue(7, $cur_fechfin);
            $sql->bindValue(8, $cur_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        
        public function verificar_curso_existente($cat_id, $cur_nom, $cur_mes, $cur_anio, $cur_id = null) {
            $conectar = parent::conexion();
            parent::set_names();
        
            // Construimos la base de la consulta
            $sqlBase = "SELECT COUNT(*) AS total FROM tm_curso WHERE cat_id = ? AND cur_nom = ? AND cur_mes = ? AND cur_anio = ?";
        
            // Si se proporciona un ID de curso, excluimos ese curso de la consulta
            if ($cur_id !== null) {
                $sqlBase .= " AND cur_id <> ?";
            }
        
            // Preparamos la consulta
            $sql = $conectar->prepare($sqlBase);
        
            // Asignamos los valores
            $sql->bindValue(1, $cat_id);
            $sql->bindValue(2, $cur_nom);
            $sql->bindValue(3, $cur_mes);
            $sql->bindValue(4, $cur_anio);
        
            // Si se proporciona un ID de curso, asignamos ese valor
            if ($cur_id !== null) {
                $sql->bindValue(5, $cur_id);
            }
        
            // Ejecutamos la consulta
            $sql->execute();
            
            // Obtenemos el resultado
            $resultado = $sql->fetch(PDO::FETCH_ASSOC);
        
            return $resultado['total'] > 0;
        }
        
        
        
        public function verificar_curso_existente_exclude($cat_id, $cur_nom, $cur_mes, $cur_anio, $cur_id) {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT COUNT(*) AS total FROM tm_curso WHERE cat_id = ? AND cur_nom = ? AND cur_mes = ? AND cur_anio = ? AND cur_id <> ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $cat_id);
            $sql->bindValue(2, $cur_nom);
            $sql->bindValue(3, $cur_mes);
            $sql->bindValue(4, $cur_anio);
            $sql->bindValue(5, $cur_id);
            $sql->execute();
            $resultado = $sql->fetch(PDO::FETCH_ASSOC);
        
            return $resultado['total'] > 0;
        }
        
                
        
        public function delete_curso($cur_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_curso
                SET
                    est = 0
                WHERE
                    cur_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cur_id);
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

        public function get_curso_id($cur_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_curso WHERE est = 1 AND cur_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cur_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_curso_usuario($curd_id){
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

        /*TODO: Insert Curso por Usuario */
        public function insert_curso_usuario($cur_id,$usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO td_curso_usuario (curd_id,cur_id,usu_id,fech_crea,est) VALUES (NULL,?,?,now(),1);";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cur_id);
            $sql->bindValue(2, $usu_id);
            $sql->execute();

            $sql1="select last_insert_id() as 'curd_id'";
            $sql1=$conectar->prepare($sql1);
            $sql1->execute();
            
            return $resultado=$sql1->fetch(pdo::FETCH_ASSOC);
        }

        public function update_imagen_curso($cur_id,$cur_img){
            $conectar= parent::conexion();
            parent::set_names();

            require_once("Curso.php");
            $curx = new Curso();
            $cur_img = '';
            if ($_FILES["cur_img"]["name"]!=''){
                $cur_img = $curx->upload_file();
            }

            $sql="UPDATE tm_curso
                SET
                    cur_img = ?
                WHERE
                    cur_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cur_img);
            $sql->bindValue(2, $cur_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function upload_file(){
            if(isset($_FILES["cur_img"])){
                $extension = explode('.', $_FILES['cur_img']['name']);
                $new_name = rand() . '.' . $extension[1];
                $destination = '../public/' . $new_name;
                move_uploaded_file($_FILES['cur_img']['tmp_name'], $destination);
                return "../../public/".$new_name;
            }
        }
    }
?>