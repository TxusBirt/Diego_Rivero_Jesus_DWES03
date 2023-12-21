<?php
/*
    Autor:Jesus Diego Rivero
    Fecha: 21/12/2023
    Modulo: DWES
    UD: 03
    Clase lanza mensajes por redirecciones
*/  
class RedirectionCod {
    public static function multipleChoices($data = null) {
        http_response_code(300);
        echo self::generateResponse(300, 'Multiple Choices', $data);
    }

    public static function movedPermanently($data = null) {
        http_response_code(301);
        echo self::generateResponse(301, 'Moved Permanently', $data);
    }

    public static function found($data = null) {
        http_response_code(302);
        echo self::generateResponse(302, 'Found', $data);
    }

    public static function seeOther($data = null) {
        http_response_code(303);
        echo self::generateResponse(303, 'See Other', $data);
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
