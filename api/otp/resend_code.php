<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../../Database/database.php';

function generateVerificationCode(): string {
    return strval(rand(100000, 999999));
}

function sendConfirmationEmail($email, $verification_code, $firstname) {
    $mail = new PHPMailer(true);
    
    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = '2e44227fa78e65';
        $mail->Password = 'ae136cc65cc770';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 2525;

        $mail->setFrom('faceLite@gmail.com', 'FaceLite');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Nouveau code de vérification - FaceLite';

        $mail->Body = '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau code de vérification FaceLite</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background-color: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow: hidden; }
        .header { background-color: #2563eb; padding: 20px; text-align: center; }
        .logo { height: 40px; margin-bottom: 10px; }
        .title { font-size: 24px; font-weight: bold; color: white; margin: 0; }
        .content { padding: 30px; }
        .subtitle { font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 20px; text-align: center; }
        .verification-section { text-align: center; margin-bottom: 30px; }
        .verification-title { font-size: 24px; font-weight: bold; color: #111827; margin-bottom: 10px; }
        .verification-code { font-size: 32px; font-weight: bold; color: #2563eb; letter-spacing: 8px; margin: 20px 0; padding: 20px; background-color: #f3f4f6; border-radius: 8px; }
        .info { color: #6b7280; font-size: 14px; margin-top: 20px; }
        .footer { background-color: #f9fafb; padding: 20px; text-align: center; color: #6b7280; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="title">FaceLite</div>
        </div>
        <div class="content">
            <div class="subtitle">Nouveau code de vérification</div>
            <div class="verification-section">
                <div class="verification-title">Votre nouveau code de vérification</div>
                <div class="verification-code">' . $verification_code . '</div>
                <div class="info">
                    Ce code expirera dans 5 minutes.<br>
                    Si vous n\'avez pas demandé ce code, ignorez cet email.
                </div>
            </div>
        </div>
        <div class="footer">
            © 2024 FaceLite. Tous droits réservés.
        </div>
    </div>
</body>
</html>';

        $mail->send();
        return ["success" => true, "message" => "Nouveau code envoyé avec succès"];
    } catch (Exception $e) {
        return ["success" => false, "message" => "Erreur lors de l'envoi de l'email: " . $e->getMessage()];
    }
}

try {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);
    $type = $data['type'] ?? 'signup';
    
    // Récupérer l'email de l'utilisateur non validé le plus récent
    // (pour simplifier, on prend le dernier utilisateur non validé)
    $req = $conn->prepare("SELECT user_id, email, firstname FROM users WHERE is_validated = 0 ORDER BY user_id DESC LIMIT 1");
    $req->execute();
    
    if ($req->rowCount() > 0) {
        $user = $req->fetch();
        $newCode = generateVerificationCode();
        $codeExpiry = date('Y-m-d H:i:s', time() + 300); // 5 minutes
        
        // Mettre à jour le code de vérification
        $update = $conn->prepare("UPDATE users SET code_verification = ?, code_expiry = ? WHERE user_id = ?");
        $update->execute([$newCode, $codeExpiry, $user['user_id']]);
        
        // Envoyer le nouveau code par email
        $mailResponse = sendConfirmationEmail($user['email'], $newCode, $user['firstname']);
        
        if ($mailResponse['success']) {
            echo json_encode(['success' => true, 'message' => 'Nouveau code envoyé avec succès']);
        } else {
            echo json_encode(['success' => false, 'message' => $mailResponse['message']]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Aucun utilisateur en attente de validation trouvé']);
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur lors du renvoi du code: ' . $e->getMessage()]);
}
?> 