<?php
    /*TODO: Llamando a cadena de Conexion */
    require_once("../config/conexion.php");
    /*TODO: Llamando a la clase */
    require_once("../models/Curso.php");
    /*TODO: Inicializando Clase */
    $curso = new Curso();

    switch($_GET["op"]){
        /*TODO: Guardar y editar cuando se tenga el ID */
        case "guardaryeditarX":
            if(empty($_POST["cur_id"])){
                $curso->insert_curso($_POST["cat_id"],$_POST["cur_nom"],$_POST["cur_descrip"],$_POST["cur_mes"],$_POST["cur_anio"],$_POST["cur_fechini"],$_POST["cur_fechfin"]);
            }else{
                $curso->update_curso($_POST["cur_id"],$_POST["cat_id"],$_POST["cur_nom"],$_POST["cur_descrip"],$_POST["cur_mes"],$_POST["cur_anio"],$_POST["cur_fechini"],$_POST["cur_fechfin"]);
            }
            break;

        case "guardaryeditar":
            $cat_id = $_POST["cat_id"];
            $cur_nom = $_POST["cur_nom"];
            $cur_descrip = $_POST["cur_descrip"];
            $cur_mes = $_POST["cur_mes"];
            $cur_anio = $_POST["cur_anio"];
            $cur_fechini = $_POST["cur_fechini"];
            $cur_fechfin = $_POST["cur_fechfin"];

            // Verificar si ya existe un curso con el mismo nombre en el mismo mes y año, excluyendo el curso actual
            $curso_existente = $curso->verificar_curso_existente($cat_id, $cur_nom, $cur_mes, $cur_anio, $_POST["cur_id"]);

            if (empty($_POST["cur_id"]) && !$curso_existente) {
                $curso->insert_curso($cat_id, $cur_nom, $cur_descrip, $cur_mes, $cur_anio, $cur_fechini, $cur_fechfin);

                // Resto del código...
                echo "success"; // Puedes cambiar este mensaje si lo prefieres
            } else if (!empty($_POST["cur_id"])) {
                if (!$curso_existente) {
                    $curso->update_curso($_POST["cur_id"], $cat_id, $cur_nom, $cur_descrip, $cur_mes, $cur_anio, $cur_fechini, $cur_fechfin);

                    // Resto del código...
                    echo "success"; // Puedes cambiar este mensaje si lo prefieres
                } else {
                    // Mensaje de error indicando que ya existe un curso con el mismo nombre en el mismo mes y año
                    echo "Error: Ya existe un curso con el mismo nombre en el mismo mes y año.";
                }
            } else {
                // Mensaje de error indicando que ya existe un curso con el mismo nombre en el mismo mes y año
                echo "Error: Ya existe un curso con el mismo nombre en el mismo mes y año.";
            }
            break;

        /*TODO: Creando Json segun el ID */
        case "mostrar":
            $datos = $curso->get_curso_id($_POST["cur_id"]);
            if(is_array($datos)==true and count($datos)<>0){
                foreach($datos as $row){
                    $output["cur_id"] = $row["cur_id"];
                    $output["cat_id"] = $row["cat_id"];
                    $output["cur_nom"] = $row["cur_nom"];
                    $output["cur_descrip"] = $row["cur_descrip"];
                    $output["cur_mes"] = $row["cur_mes"];
                    $output["cur_anio"] = $row["cur_anio"];
                    $output["cur_fechini"] = $row["cur_fechini"];
                    $output["cur_fechfin"] = $row["cur_fechfin"];
                }
                echo json_encode($output);
            }
            break;
        
        /*TODO: Eliminar segun ID */
        case "eliminar":
            $curso->delete_curso($_POST["cur_id"]);
            break;
        
        /*TODO:  Listar toda la informacion segun formato de datatable */
        case "listar":
            $datos=$curso->get_curso();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = '<a href="'.$row["cur_img"].'" target="_blank">'.strtoupper($row["cur_nom"]).'</a>';
                $sub_array[] = $row["cur_fechini"];
                $sub_array[] = $row["cur_fechfin"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["cur_id"].');"  id="'.$row["cur_id"].'" class="btn btn-outline-warning btn-icon"><div><i class="fa fa-edit"></i></div></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["cur_id"].');"  id="'.$row["cur_id"].'" class="btn btn-outline-danger btn-icon"><div><i class="fa fa-close"></i></div></button>';                
                $sub_array[] = '<button type="button" onClick="imagen('.$row["cur_id"].');"  id="'.$row["cur_id"].'" class="btn btn-outline-success btn-icon"><div><i class="fa fa-file"></i></div></button>';                
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;
        /*TODO:  Listar toda la informacion segun formato de datatable */
        case "combo":
            $datos=$curso->get_curso();
            if(is_array($datos)==true and count($datos)>0){
                $html= " <option label='Seleccione'></option>";
                foreach($datos as $row){
                    $html.= "<option value='".$row['cur_id']."'>".$row['cur_nom']."</option>";
                }
                echo $html;
            }
            break;
        
        case "eliminar_curso_usuario":
            $curso->delete_curso_usuario($_POST["curd_id"]);
            break;
        
        /*TODO: Insetar detalle de curso usuario */
        
        /*TODO: Insetar detalle de curso usuario */
        case "insert_curso_usuario":
            /*TODO: Array de usuario separado por comas */
            $datos = explode(',', $_POST['usu_id']);
            /*TODO: Registrar tantos usuarios vengan de la vista */
            $data = Array();
            foreach($datos as $row){
                $sub_array = array();
                $idx=$curso->insert_curso_usuario($_POST["cur_id"],$row);
                $sub_array[] = $idx;
                $data[] = $sub_array;
            }

            echo json_encode($data);
            break;
        
        case "generar_qr":
            require 'phpqrcode/qrlib.php';
            //Primer Parametro - Text del QR
            //Segundo Parametro - Ruta donde se guardara el archivo
            QRcode::png(conectar::ruta()."view/Certificado/index.php?curd_id=".$_POST["curd_id"],"../public/qr/".$_POST["curd_id"].".png",'L',32,5);
            break;
        

        case "update_imagen_curso":
            $curso->update_imagen_curso($_POST["curx_idx"],$_POST["cur_img"]);
            break;
            
    }
?>