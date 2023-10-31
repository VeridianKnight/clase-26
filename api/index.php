<?php
// IMPORTACION DE ARCHIVOS PHP //
    include ("utilidades/Auth.php");

// CONEXION //
    $server = "localhost";
    $username = "root"; 
    $dbname = "api_rn";
    $password = "";
    $conexion = new BaseDeDatos($server, $username, $dbname, $password);

// CONFIGURACION ENCABEZADO PARA ESTABLECER QUE EL CONTENIDO VA A SER TYPO JSON //
    header("content-type: application/json");

// CATCH DE LOS METHODOS QUE ESTAN SIENDO ENVIADOS //
    $metodos = $_SERVER['REQUEST_METHOD'];
    print_r($metodos . ' ');// ESTO ESTA PARA CONFIRMAR QUE FUNCIONA

// OBJETO DE LA CLASE auth //
    $auth= new Auth($conexion);
    $api = new API($conexion);

    switch ($metodos){//reconocimiento y manejo de los tipos de metodos
        case 'GET':
            $api->endpointObtener();
            break;
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            if (isset($data['accion'])) {
                $accion = $data['accion'];
                if ($accion === 'register') {
                    $token = bin2hex(random_bytes(16));
                    $auth->register($token,$data);
                } elseif ($accion === 'login') {
                    $token = bin2hex(random_bytes(16));
                    $auth->login($token, $data);
                } else {
                    echo('Acción no reconocida');
                }
            }
            break;
        case 'PUT'://acordate de cambiar la logica del put para que requiera el token de autentificacion correcto para editar!!!
            $token = bin2hex(random_bytes(16));
            $api->endpointActualizar($token);
            break;
        case 'DELETE':
            $api->endpointBorrar();
            break;
        default:
            echo('Error, metodo no reconocido');
            break;
    }

?>
