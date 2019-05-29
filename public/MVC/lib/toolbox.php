<?php

/**
 * Envia una respuesta al cliente formateado de manera correcta.
 * Responde con un JSON con el contenido, y con un codigo HTTP de
 * respuesta indicando exito o un caso particular especificado
 * Codigo de respuestas rapidos:
 *      200 OK
 *      400 ERROR GENERICO
 *
 * @param int $status numero que representa la respuesta http
 * @param string $status_message mensaje de respuesta
 * @param array $data array con los datos de requeridos
 */
function response($status, $status_message, $data = null){
    header("HTTP/1.1 ".$status);
    $response['status'] = $status;
    $response['status_message'] = $status_message;
    $response['data'] = $data;
    echo json_encode($response);
}