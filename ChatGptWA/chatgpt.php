<?php
function preguntaChatgpt($pregunta)
{
    //API KEY DE CHATGPT
    $apiKey = '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';
    //INICIAMOS LA CONSULTA DE CURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey,
    ]);
    //INICIAMOS EL JSON QUE SE ENVIARA A META
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
        \"model\": \"gpt-3.5-turbo\",
        \"messages\": [
            {
                \"role\": \"system\",
                \"content\": \"Eres un asistente que me ayudara a obtener información sobre la satisfación que expresan mis clientes en sus mensajes. Quiero que proceses el mensaje y realices dos cosas: 1. calificar el mensaje con un rango de 0 a 100 donde 0 significa que el mensaje es totalmente negativo para mi empresa, 50 son mensajes neutros, y 100 que es un mensaje totalmente positivo para mi empresa. Debes considerar muchas cosas para la calificación, como ser los ánimos o emociones que los clientes puedan estar expresando, si el mensaje refleja deseos de compra, satisfacción, enojo, frustración, etc. 2. Si en el mensaje se menciona un producto, quiero que me lo menciones, pero en caso de no mencionarse ningun producto, puedes decir 'sin producto'. Dentro de tu respuesta, dime la calificación y el producto mencionado en este formato: 'calificación, producto'. (el formato debe estar en una sola linea separada por una coma). Ejemplos: si el mensaje es 'hola, buenas días' no expresa nada negativo, pero está siendo cordial, por lo que la respuesta puede ser '55, sin producto'. si el mensaje es 'hola, escuché que tiene el zapatos adidas bonitos'expresa deseos de compra por lo que la respuesta podría ser '85, zapatos adidas'. NOTA: SOLO DEBES RESPONDER CON LA RESPUESTA INDICADA Y EN EL FORMATO INDICADO. A PARTIR DE AHORA, TODOS LOS SIGUIENTES MENSAJES DEL ROLE 'USER' DEBES PROCESARLOS DE LA MISMA FORMA.\"
            },
            {
                \"role\": \"user\",
                \"content\": \"" . $pregunta . "\"
            }
        ]
    }");
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //OBTENEMOS EL JSON COMPLETO CON LA RESPUESTA
    $response = curl_exec($ch);
    curl_close($ch);
    var_dump($response);
    $decoded_json = json_decode($response, false);
    //RETORNAMOS LA RESPUESTA QUE EXTRAEMOS DEL JSON
    return  $decoded_json->choices[0]->message->content;
}
