<?php
/*TODO: Llamando a cadena de Conexion */
require_once("../config/conexion.php");
/*TODO: Llamando a la clase */
require_once("../models/Detalle.php");
/*TODO: Inicializando Clase */
$detalle = new Detalle();

/*TODO: Opcion de solicitud de controller */
switch ($_GET["op"]) {

    case "guardaryeditar":
        if (empty($_POST["curd_id"])) {
            $detalle->insert_detalle($_POST["cur_id"], $_POST["usu_dni"], $_POST["curd_nota"],$_POST["curd_fechemi"]);
        } else {
            $detalle->update_detalle($_POST["curd_id"], $_POST["cur_id"], $_POST["usu_dni"], $_POST["curd_nota"],$_POST["curd_fechemi"]);
        }
        break;
    case "mostrar":
        $datos = $detalle->get_detalle_id($_POST["curd_id"]);
        if (is_array($datos) == true and count($datos) <> 0) {
            foreach ($datos as $row) {
                $output["curd_id"] = $row["curd_id"];
                $output["cur_id"] = $row["cur_id"];
                $output["usu_dni"] = $row["usu_dni"];
                $output["curd_nota"] = $row["curd_nota"];
                $output["curd_fechemi"] = $row["curd_fechemi"];
            }
            echo json_encode($output);
        }
        break;
    
    case "eliminar":
        $detalle->delete_detalle($_POST["curd_id"]);
        break;
    
    case "listar":
        $datos=$detalle->get_detalle();
        $data= Array();
        foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["cur_nom"];
                $sub_array[] = $row["usu_dni"];
                $sub_array[] = $row["curd_nota"];
                $sub_array[] = $row["curd_fechemi"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["curd_id"].');"  id="'.$row["curd_id"].'" class="btn btn-outline-warning btn-icon"><div><i class="fa fa-edit"></i></div></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["curd_id"].');"  id="'.$row["curd_id"].'" class="btn btn-outline-danger btn-icon"><div><i class="fa fa-close"></i></div></button>';                
                $data[] = $sub_array;
            }

        $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

        case "guardar_desde_excel":
            $detalle->insert_detalle($_POST["cur_id"],$_POST["usu_dni"],$_POST["curd_nota"],$_POST["curd_fechemi"]);
            break;
}
