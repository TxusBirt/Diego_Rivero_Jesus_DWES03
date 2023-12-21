<?php
/*
    Autor:Jesus Diego Rivero
    Fecha: 21/12/2023
    Modulo: DWES
    UD: 03
    Clase lanza mensajes cuando se tiene exito en las acciones requeridas
*/  
class SuccessCod {
    public static function ok($data = null) {
        http_response_code(200);
        echo self::generateResponse(200, 'OK', $data);
        
    }

    public static function created($data = null) {
        http_response_code(201);
        echo self::generateResponse(201, 'Created', $data);
    }

    public static function accepted($data = null) {
        http_response_code(202);
        echo self::generateResponse(202, 'Accepted', $data);
    }

    public static function noContent() {
        http_response_code(204);
        echo self::generateResponse(204, 'No Content');
    }

    private static function generateResponse($statusCode, $statusText, $data = null) {
        $response = [
            'status' => $statusCode,
            'message' => $statusText,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }
        
        return json_encode($response);
    }
}
?>
