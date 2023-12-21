<?php
/*
    Autor:Jesus Diego Rivero
    Fecha: 21/12/2023
    Modulo: DWES
    UD: 03
    Clase lanza mensajes por errores por parte del servidor
*/  
class ServerErrorCod {
    public static function internalServerError($data = null) {
        http_response_code(500);
        echo self::generateResponse(500, 'Internal Server Error', $data);
    }

    public static function notImplemented($data = null) {
        http_response_code(501);
        echo self::generateResponse(501, 'Not Implemented', $data);
    }

    public static function badGateway($data = null) {
        http_response_code(502);
        echo self::generateResponse(502, 'Bad Gateway', $data);
    }

    public static function serviceUnavailable($data = null) {
        http_response_code(503);
        echo self::generateResponse(503, 'Service Unavailable', $data);
    }

    // Puedes agregar más métodos según sea necesario para otros códigos 5xx...

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
