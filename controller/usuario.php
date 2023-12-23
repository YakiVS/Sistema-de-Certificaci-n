<?php
    /*TODO: Llamando a cadena de Conexion */
    require_once("../config/conexion.php");
    /*TODO: Llamando a la clase */
    require_once("../models/Usuario.php");
    /*TODO: Inicializando Clase */
    $usuario = new Usuario();

    /*TODO: Opcion de solicitud de controller */
    switch($_GET["op"]){

        /*TODO: MicroServicio para poder mostrar el listado de cursos de un usuario con certificado */
        case "listar_cursos_consulta":
            $datos=$usuario->get_cursos_x_usuario($_POST["usu_dni"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["cur_nom"];
                $sub_array[] = $row["cur_fechini"];
                $sub_array[] = $row["cur_fechfin"];
                $sub_array[] = '<button type="button" onClick="certificado('.$row["curd_id"].');"  id="'.$row["curd_id"].'" class="btn btn-outline-primary btn-icon"><div><i class="fa fa-id-card-o"></i></div></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            
            break;

        case "listar_cursos":
            $usu_id = $_POST["usu_id"];
            
            // Obtener el usu_dni por usu_id
            $usu_dni = $usuario->obtener_usu_dni_por_usu_id($usu_id);

            if ($usu_dni) {
                // Obtener los cursos según el usu_dni
                $datos = $usuario->get_cursos_x_usuario($usu_dni);
                $data = Array();

                // Procesar los datos para la DataTable
                foreach ($datos as $row) {
                    $sub_array = array();
                    $sub_array[] = $row["cur_nom"];
                    $sub_array[] = $row["cur_fechini"];
                    $sub_array[] = $row["cur_fechfin"];
                    $sub_array[] = '<button type="button" onClick="certificado(' . $row["curd_id"] . ');"  id="' . $row["curd_id"] . '" class="btn btn-outline-primary btn-icon"><div><i class="fa fa-id-card-o"></i></div></button>';
                    $data[] = $sub_array;
                }

                // Enviar los resultados a DataTable
                $results = array(
                    "sEcho" => 1,
                    "iTotalRecords" => count($data),
                    "iTotalDisplayRecords" => count($data),
                    "aaData" => $data
                );
                echo json_encode($results);
            } else {
                // Manejar el caso donde no se pudo obtener el usu_dni
                echo json_encode(["error" => "No se pudo obtener el usu_dni"]);
            }

            break;


        /* TODO: MicroServicio para poder mostrar el listado de cursos de un usuario con certificado */
        case "listar_cursos_top10":
            // Obtener el usu_dni correspondiente al usu_id
            $usu_id = $_POST["usu_id"];
            $usu_dni = $usuario->obtener_usu_dni_por_usu_id($usu_id);

            // Verificar que se obtuvo el usu_dni
            if ($usu_dni) {
                // Obtener los cursos según el usu_dni
                $datos = $usuario->get_cursos_x_usuario_top10($usu_dni);
                $data = Array();

                // Procesar los datos para la DataTable
                foreach ($datos as $row) {
                    $sub_array = array();
                    $sub_array[] = $row["cur_nom"];
                    $sub_array[] = $row["cur_fechini"];
                    $sub_array[] = $row["cur_fechfin"];
                    $sub_array[] = '<button type="button" onClick="certificado(' . $row["curd_id"] . ');"  id="' . $row["curd_id"] . '" class="btn btn-outline-primary btn-icon"><div><i class="fa fa-id-card-o"></i></div></button>';
                    $data[] = $sub_array;
                }

                // Enviar los resultados a DataTable
                $results = array(
                    "sEcho" => 1,
                    "iTotalRecords" => count($data),
                    "iTotalDisplayRecords" => count($data),
                    "aaData" => $data
                );
                echo json_encode($results);
            } else {
                // Manejar el caso donde no se pudo obtener el usu_dni
                echo json_encode(["error" => "No se pudo obtener el usu_dni"]);
            }

            break;
        
        
        /*TODO: Total de Cursos por usuario para el dashboard */
        case "total":
            $usu_id = $_POST["usu_id"];
            $usu_dni = $usuario->obtener_usu_dni_por_usu_id($usu_id);
            $datos = $usuario->get_total_cursos_x_usuario($usu_dni);
            
            if (is_array($datos) == true and count($datos) > 0) {
                foreach ($datos as $row) {
                    $output["total"] = $row["total"];
                }
                echo json_encode($output);
            }
            break;

            
        /*TODO: Microservicio para mostar informacion del certificado con el curd_id */
        case "mostrar_curso_detalle":
            $datos = $usuario->get_curso_x_id_detalle($_POST["curd_id"]);
            if(is_array($datos)==true and count($datos)<>0){
                foreach($datos as $row){
                    $output["curd_id"] = $row["curd_id"];
                    $output["curd_nota"] = $row["curd_nota"];
                    $output["curd_fechemi"] = $row["curd_fechemi"];
                    $output["cur_id"] = $row["cur_id"];
                    $output["cur_nom"] = $row["cur_nom"];
                    $output["cur_descrip"] = $row["cur_descrip"];
                    $output["cur_fechini"] = $row["cur_fechini"];
                    $output["cur_fechfin"] = $row["cur_fechfin"];
                    $output["cur_img"] = $row["cur_img"];
                    $output["usu_id"] = $row["usu_id"];
                    $output["usu_nom"] = $row["usu_nom"];
                    $output["usu_apep"] = $row["usu_apep"];
                    $output["usu_apem"] = $row["usu_apem"];
                    
                }
                echo json_encode($output);
            }
            break;

        /*TODO: Mostrar informacion del usuario en la vista perfil */
        case "mostrar":
            $datos = $usuario->get_usuario_x_id($_POST["usu_id"]);
            if(is_array($datos)==true and count($datos)<>0){
                foreach($datos as $row){
                    $output["usu_id"] = $row["usu_id"];
                    $output["usu_nom"] = $row["usu_nom"];
                    $output["usu_apep"] = $row["usu_apep"];
                    $output["usu_apem"] = $row["usu_apem"];
                    $output["usu_correo"] = $row["usu_correo"];
                    $output["usu_sex"] = $row["usu_sex"];
                    $output["usu_pass"] = $row["usu_pass"];
                    $output["usu_telf"] = $row["usu_telf"];
                    $output["rol_id"] = $row["rol_id"];
                    $output["usu_dni"] = $row["usu_dni"];
                }
                echo json_encode($output);
            }
            break;

        /*TODO: Mostrar informacion segun el DNI del usuario Registrado */
        case "consulta_dni":
            $datos = $usuario->get_usuario_x_dni($_POST["usu_dni"]);
            if(is_array($datos)==true and count($datos)<>0){
                foreach($datos as $row){
                    $output["usu_dni"] = $row["usu_dni"];
                    $output["usu_nom"] = $row["usu_nom"];
                    $output["usu_apep"] = $row["usu_apep"];
                    $output["usu_apem"] = $row["usu_apem"];
                    $output["usu_correo"] = $row["usu_correo"];
                    $output["usu_sex"] = $row["usu_sex"];
                    $output["usu_pass"] = $row["usu_pass"];
                    $output["usu_telf"] = $row["usu_telf"];
                    $output["rol_id"] = $row["rol_id"];
                }
                echo json_encode($output);
            }
            break;
                
        /*TODO: Actualizar datos de perfil */
        case "update_perfil":
            $usuario->update_usuario_perfil(
                $_POST["usu_id"],
                $_POST["usu_nom"],
                $_POST["usu_apep"],
                $_POST["usu_apem"],
                $_POST["usu_pass"],
                $_POST["usu_sex"],
                $_POST["usu_telf"]
            );
            break;

        /* Guardar y editar cuando se tenga el ID */

        case "guardaryeditarX":
            if(empty($_POST["usu_id"])){
                $usuario->insert_usuario($_POST["usu_nom"],$_POST["usu_apep"],$_POST["usu_apem"],$_POST["usu_correo"],$_POST["usu_pass"],$_POST["usu_sex"],$_POST["usu_telf"],$_POST["rol_id"],$_POST["usu_dni"]);
            }else{
                $usuario->update_usuario($_POST["usu_id"],$_POST["usu_nom"],$_POST["usu_apep"],$_POST["usu_apem"],$_POST["usu_correo"],$_POST["usu_pass"],$_POST["usu_sex"],$_POST["usu_telf"],$_POST["rol_id"],$_POST["usu_dni"]);
            }
            break;
        
        case "guardaryeditar":
            $usu_id = $_POST["usu_id"];
            $usu_dni = $_POST["usu_dni"];
                
            // Verificar si el DNI ya existe en la base de datos
            $existe_dni = $usuario->get_usuario_x_dni($usu_dni);
            
            if ($existe_dni && $usu_id == "") {
                // Si el DNI existe y es una inserción (no una actualización), muestra un mensaje de error
                echo "dni_existente";
            } else {
                if (empty($usu_id)) {
                    // Insertar el nuevo usuario
                    $usuario->insert_usuario($_POST["usu_nom"], $_POST["usu_apep"], $_POST["usu_apem"], $_POST["usu_correo"], $_POST["usu_pass"], $_POST["usu_sex"], $_POST["usu_telf"], $_POST["rol_id"], $_POST["usu_dni"]);
                        echo "exito"; // Inserción exitosa, enviar respuesta de éxito
                } else {
                    // Actualizar el usuario
                    $usuario->update_usuario($usu_id, $_POST["usu_nom"], $_POST["usu_apep"], $_POST["usu_apem"], $_POST["usu_correo"], $_POST["usu_pass"], $_POST["usu_sex"], $_POST["usu_telf"], $_POST["rol_id"], $_POST["usu_dni"]);
                        echo "exito"; // Actualización exitosa, enviar respuesta de éxito
                    }
                }
                break;
            
                
        /* Eliminar segun ID */
        case "eliminar":
            $usuario->delete_usuario($_POST["usu_id"]);
            break;
        
        
        /* Listar toda la informacion segun formato del datatable */
        case "listar":
            $datos=$usuario->get_usuario();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["usu_nom"];
                $sub_array[] = $row["usu_apep"];
                $sub_array[] = $row["usu_apem"];
                $sub_array[] = $row["usu_correo"];
                $sub_array[] = $row["usu_telf"];
                if($row["rol_id"]==1){
                    $sub_array[]="Usuario";
                }else{
                    $sub_array[]="Admin";
                }
                $sub_array[] = '<button type="button" onClick="editar('.$row["usu_id"].');"  id="'.$row["usu_id"].'" class="btn btn-outline-warning btn-icon"><div><i class="fa fa-edit"></i></div></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["usu_id"].');"  id="'.$row["usu_id"].'" class="btn btn-outline-danger btn-icon"><div><i class="fa fa-close"></i></div></button>';                
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;
        /* Listar todos los usuarios pertenecientes a un curso */

        case "listar_cursos_usuario":
            $datos=$usuario->get_cursos_usuario_x_id($_POST["cur_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["cur_nom"];
                $sub_array[] = $row["usu_nom"]." ".$row["usu_apep"]." ".$row["usu_apem"];
                $sub_array[] = $row["cur_fechini"];
                $sub_array[] = $row["cur_fechfin"];
                $sub_array[] = '<button type="button" onClick="certificado('.$row["curd_id"].');"  id="'.$row["curd_id"].'" class="btn btn-outline-primary btn-icon"><div><i class="fa fa-id-card-o"></i></div></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["curd_id"].');"  id="'.$row["curd_id"].'" class="btn btn-outline-danger btn-icon"><div><i class="fa fa-close"></i></div></button>';
                $sub_array[] = '<button type="button" onClick="enviar('.$row["usu_id"].', '.$row["curd_id"].');"  id="'.$row["usu_id"].'" class="btn btn-outline-success btn-icon"><div><i class="fa fa-whatsapp"></i></div></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;

        case "listar_detalle_usuario":
            $datos=$usuario->get_usuario_modal($_POST["cur_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = "<input type='checkbox' name='detallecheck[]' value='". $row["usu_id"] ."'>";
                $sub_array[] = $row["usu_nom"];
                $sub_array[] = $row["usu_apep"];
                $sub_array[] = $row["usu_apem"];
                $sub_array[] = $row["usu_correo"];
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
            $usuario->insert_usuario($_POST["usu_nom"],$_POST["usu_apep"],$_POST["usu_apem"],$_POST["usu_correo"],$_POST["usu_pass"],$_POST["usu_sex"],$_POST["usu_telf"],$_POST["rol_id"],$_POST["usu_dni"]);
            break;
        case "obtener_telefono_usuario":
                $usu_id = $_POST["usu_id"];
                $telefono = $usuario->get_telefono_usuario($usu_id);

                $response = array("telefono" => $telefono);
                echo json_encode($response);
            break;

    
    }
