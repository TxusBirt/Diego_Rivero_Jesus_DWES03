<?php
/*
    Autor:Jesus Diego Rivero
    Fecha: 21/12/2023
    Modulo: DWES
    UD: 03
    Clase lanza mensajes por errores por parte del cliente
*/  
class ClientErrorCod {
    public static function badRequest($data = null) {
        http_response_code(400);
        echo self::generateResponse(400, 'Bad Request', $data);
    }

    public static function unauthorized($data = null) {
        http_response_code(401);
        echo (self::generateResponse(401, 'Unauthorized', $data));
    }

    public static function forbidden($data = null) {
        http_response_code(403);
        echo self::generateResponse(403, 'Forbidden', $data);
    }

    public static function notFound($data = null) {
        http_response_code(404);
        echo self::generateResponse(404, 'Not Found', $data);
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
