<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Configuración - Ваши email адреса
    $to = "tiktokshopaacc@gmail.com"; // Сюда будут приходить заявки для проверки
    $admin_email = "protect-homee@protect-homee.com"; // Email домена для отправки писем
    
    // Obtener datos del formulario
    $firstName = isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $whatsapp = isset($_POST['whatsapp']) ? htmlspecialchars($_POST['whatsapp']) : '';
    
    // Verificar campos obligatorios
    if (empty($firstName) || empty($email) || empty($whatsapp)) {
        echo json_encode(["status" => "error", "message" => "Por favor complete todos los campos obligatorios"]);
        exit;
    }
    
    // Verificar email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Formato de email inválido"]);
        exit;
    }
    
    // Verificar formato de WhatsApp
    $whatsapp_clean = preg_replace('/[^0-9+]/', '', $whatsapp);
    if (!preg_match('/^\+34[67][0-9]{8}$|^[67][0-9]{8}$|^\+[0-9]{10,15}$/', $whatsapp_clean)) {
        $whatsapp_warning = " (Verificar formato de WhatsApp)";
    } else {
        $whatsapp_warning = "";
    }
    
    // Crear el mensaje del email
    $subject = "Nueva solicitud de registro 365Bet - " . $firstName;
    
    $message = "
    <html>
    <head>
        <title>Nueva solicitud de registro 365Bet</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #22c55e, #10b981); color: white; padding: 20px; border-radius: 10px 10px 0 0; }
            .content { background: #f9f9f9; padding: 20px; }
            .field { margin-bottom: 15px; }
            .label { font-weight: bold; color: #22c55e; }
            .value { margin-left: 10px; }
            .footer { background: #e5e7eb; padding: 15px; border-radius: 0 0 10px 10px; font-size: 12px; color: #666; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>🎰 Nueva solicitud de registro 365Bet</h2>
                <p>Solicitud recibida el " . date('d/m/Y H:i:s') . "</p>
            </div>
            <div class='content'>
                <h3>📋 Datos del solicitante:</h3>
                
                <div class='field'>
                    <span class='label'>👤 Nombre:</span>
                    <span class='value'>" . $firstName . "</span>
                </div>
                
                <div class='field'>
                    <span class='label'>📧 Email:</span>
                    <span class='value'>" . $email . "</span>
                </div>
                
                <div class='field'>
                    <span class='label'>📱 WhatsApp:</span>
                    <span class='value'>" . $whatsapp . $whatsapp_warning . "</span>
                </div>
                
                <div class='field'>
                    <span class='label'>⏰ Fecha de solicitud:</span>
                    <span class='value'>" . date('d/m/Y H:i:s') . "</span>
                </div>
                
                <div class='field'>
                    <span class='label'>🌐 IP del solicitante:</span>
                    <span class='value'>" . $_SERVER['REMOTE_ADDR'] . "</span>
                </div>
            </div>
            <div class='footer'>
                <p><strong>Próximos pasos:</strong></p>
                <p>1. Contactar por WhatsApp: " . $whatsapp . "</p>
                <p>2. Confirmar datos y ayudar con el registro</p>
                <p>3. Guiar en la obtención de bonos de bienvenida</p>
                <br>
                <p><em>Este email fue generado automáticamente desde el formulario de registro de ayuda 365Bet España.</em></p>
            </div>
        </div>
    </body>
    </html>";
    
    // Headers para email HTML
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: " . $admin_email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    // Enviar email
    if (mail($to, $subject, $message, $headers)) {
        $user_subject = "Confirmación de solicitud - Ayuda registro 365Bet";
        $user_message = "
        <html>
        <head>
            <title>Confirmación de solicitud</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #22c55e, #10b981); color: white; padding: 20px; border-radius: 10px 10px 0 0; text-align: center; }
                .content { background: #f9f9f9; padding: 20px; }
                .footer { background: #e5e7eb; padding: 15px; border-radius: 0 0 10px 10px; font-size: 12px; color: #666; }
                .highlight { background: #dcfce7; padding: 15px; border-radius: 8px; border-left: 4px solid #22c55e; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>🎉 ¡Solicitud recibida con éxito!</h2>
                    <p>Hola " . $firstName . ", hemos recibido tu solicitud</p>
                </div>
                <div class='content'>
                    <div class='highlight'>
                        <h3>✅ Tu solicitud ha sido procesada</h3>
                        <p>Nos pondremos en contacto contigo por WhatsApp dentro de las próximas 24-48 horas para ayudarte con el proceso de registro de tu nueva cuenta 365Bet.</p>
                    </div>
                    
                    <h3>📋 Resumen de tu solicitud:</h3>
                    <p><strong>Nombre:</strong> " . $firstName . "</p>
                    <p><strong>Email:</strong> " . $email . "</p>
                    <p><strong>WhatsApp:</strong> " . $whatsapp . "</p>
                    <p><strong>Fecha de solicitud:</strong> " . date('d/m/Y H:i:s') . "</p>
                    
                    <h3>🚀 Qué esperar:</h3>
                    <p>• Te contactaremos por WhatsApp</p>
                    <p>• Te guiaremos paso a paso en el proceso</p>
                    <p>• Te ayudaremos a acceder a los bonos de bienvenida</p>
                    <p>• Soporte completamente gratuito en español</p>
                </div>
                <div class='footer'>
                    <p><strong>Importante:</strong> Si no recibes noticias nuestras en 48 horas, revisa tu carpeta de spam o contacta con nosotros.</p>
                    <p><em>Este email fue enviado automáticamente. Por favor no respondas a este mensaje.</em></p>
                </div>
            </div>
        </body>
        </html>";
        
        $user_headers = "MIME-Version: 1.0" . "\r\n";
        $user_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $user_headers .= "From: " . $admin_email . "\r\n";
        $user_headers .= "X-Mailer: PHP/" . phpversion();
        
        // Enviar email de confirmación al usuario
        mail($email, $user_subject, $user_message, $user_headers);
        
        // Opcional: Guardar en archivo de log
        $log_entry = date('Y-m-d H:i:s') . " - Nueva solicitud: " . $firstName . " (" . $email . ") - WhatsApp: " . $whatsapp . "\n";
        file_put_contents('registrations.log', $log_entry, FILE_APPEND | LOCK_EX);
        
        // Respuesta exitosa
        echo json_encode([
            "status" => "success", 
            "message" => "Solicitud enviada correctamente. Te contactaremos por WhatsApp pronto.",
            "data" => [
                "name" => $firstName,
                "email" => $email,
                "whatsapp" => $whatsapp,
                "timestamp" => date('Y-m-d H:i:s')
            ]
        ]);
        
    } else {
        echo json_encode(["status" => "error", "message" => "Error al enviar el email. Inténtalo de nuevo."]);
    }
    
} else {
    // Método no permitido
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
?>