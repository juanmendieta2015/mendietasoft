<?php
    date_default_timezone_set('America/Guayaquil');
    require 'vendor/autoload.php';
    
    // Constantes (API KEY de Sendgrid, Nombres e Email del receptor, etc...)
    require 'constants.php';


    // Recoge datos del cliente via POST

    $from_name      = ( empty($_POST["name"])       ) ? '' : $_POST["name"];
    $from_email     = ( empty($_POST["email"])      ) ? '' : $_POST["email"];
    $subject        = ( empty($_POST["subject"])    ) ? 'Nuevo Contacto' : $_POST["subject"];
    $telephone      = ( empty($_POST["telephone"])  ) ? '' : $_POST["telephone"];
    $message        = ( empty($_POST["message"])    ) ? '' : $_POST["message"]; 



    // Validacion de Datos   

    $cliente['from_name']   = $from_name;
    $cliente['from_email']  = $from_email;
    $cliente['telephone']   = $telephone;
    $cliente['message']     = $message;

    if ( validarDatos($cliente) == false ) {

        echo 2;     // 2 = No pasa la validacion
        return;        

    }


    
    // Plantilla HTML para enviar por email                        

    $content = '
        
        <!DOCTYPE html>
        <html>
        <head>
        </head>
        
        <body style="text-align: center;">
            <div id="container" style="width: 75%; height: 600px; background-color: #EDEDED; box-shadow: 0 1px 5px #999;margin: auto; ">
                <div id="title">
                    <h1 style="font-size: 30px; color: #FFFFFF; background-color: #96C43F;  padding: 5px;">Nueva Solicitud de Asistencia Legal</h1>
                </div>
                <div class="description" style="border: 0px solid blue; font-size: 18px; color: #666666; width: 90%; text-align: justify;margin:auto">
                    <p>Hola '   . TO_NAME .  ', has recibido un mensaje de parte de alguien interesado(a) en tus servicios profesionales.</p>
        
                    <p>Mensaje original: </p>
        
                    <hr>
                    <p>
                        '   . $message .    '
                    </p>
                    <hr>
        
                    <p><strong>Datos de contacto:</strong></p>
                    <ul>
                        <li>Nombres: '      . $from_name    . '</li>
                        <li>Telefono: '     . $telephone    . '</li>
                        <li>Email: '        . $from_email   . '</li>
                    </ul>        
         
                </div>        
            </div>
        </body>
        </html>     
        
    ';


    // Prepara el email para posteriormente ser enviado

    $from = new SendGrid\Email($from_name, $from_email);
    $to = new SendGrid\Email(TO_NAME, TO_EMAIL);
    $content = new SendGrid\Content("text/html",$content);
    $mail = new SendGrid\Mail($from, $subject, $to, $content);
    $sg = new \SendGrid(SENDGRID_API_KEY);



    // Envia email

    $response = $sg->client->mail()->send()->post($mail);  

    $success = false;

    if ($response->statusCode() == 202){        
        echo 1;     // 1 = El email se ha enviado satisfactoriamente
        $success = true;
    } else {        
        echo 0;     // 0 = Ha ocurrido un error al enviar el mensaje    
        $success = false;
    }


    $date       = date("Y-m-d H:i:s");
    // $name       = $from_name;
    // $telephone  = $telephone;
    // $email      = $from_email;
    // $message    = $message;
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $send_succes = $success ? "El mensaje ha sido enviado por email exitosamente" : "El mensaje no se ha podido enviar por email";

    $txt = "
        Fecha\t\t\t\t: {$date}
        Name\t\t\t\t: {$from_name}
        Telefono\t\t\t: {$telephone}
        Email\t\t\t\t: {$from_email}
        Mensaje \t\t\t: {$message}
        Direccion Ip\t\t: {$ip_address}
        Reporte de envio\t:{$send_succes}
        \n
    ";

    if (!log_save($txt)) {
        echo "3";       // 3 = No se ha podido guardar el archivo de log
    } 




    // Valida datos del clilente

    function validarDatos($cliente) 
    {
        extract($cliente);

        if ( empty($from_name) || empty($message) || ( empty($from_email) && empty($telephone) ) ) {

            return false;

        }   

        return true;     
    }    

    
    // Guarda un archivo de log

    function log_save($txt)
    {
        $myfile = fopen("logs.txt", "a") or die("Unable to open file!");
        fwrite($myfile, $txt);
        fclose($myfile);
        return true;        
    }       

?>