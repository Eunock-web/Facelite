<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');
$input = file_get_contents("php://input");
$data = json_decode($input, true);


function generateVerificationCode(): string {
    return strval(rand(100000, 999999));
}

require_once __DIR__ . '/../../Database/database.php';

if (!$data) {
    echo json_encode(["success" => false, "message" => "Données JSON invalides"]);
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $verification_code = generateVerificationCode();
    $code_expiry = date('Y-m-d H:i:s', time() + 300); // 5 minutes d'expiration
    $email = $data['email'];
try {
    // Vérifier si l'email existe déjà
    $req = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $req->execute([$email]);
    
    if($req->rowCount() >= 1) {
        // Modifier la requête pour être plus explicite sur les colonnes
$query = $conn->prepare(" UPDATE users SET code_verification = ?, code_expiry = ? WHERE email = ?");

// 3. Exécuter avec les bonnes valeurs
$success = $query->execute([
    $verification_code, 
    $code_expiry, 
    $email, 
]);        
        if($success) {
            $mailResponse = sendConfirmationEmail($email, $verification_code);
            echo json_encode($mailResponse);
        } else {
            // Récupérer l'erreur PDO spécifique
            $errorInfo = $query->errorInfo();
            echo json_encode([
                "success" => false, 
                "message" => "Échec de l'inscription: " . $errorInfo[2]
            ]);
        }
        exit();
    } else {
        echo json_encode(["success" => false, "message" => "Cet email n'est pas valide"]);
        exit();
    }
} catch(PDOException $e) {
    // Afficher plus de détails sur l'erreur
    echo json_encode([
        "success" => false, 
        "message" => "Erreur de base de données: " . $e->getMessage(),
    ]);
    exit();
}
    } else {
        echo json_encode(["success" => false, "message" => "Tous les champs sont obligatoires"]);
        exit();
    }

function sendConfirmationEmail($email, $verification_code) {
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
        $mail->Subject = 'Confirmer votre compte';

        // Séparer le code en chiffres individuels pour l'affichage
        $codeDigits = str_split($verification_code);

        $mail->Body = '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification de compte FaceLite</title>
    <style>
        @import url(\'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap\');
        
        body {
            font-family: \'Inter\', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 42rem;
            margin: 2rem auto;
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .header {
            background-color: #2563eb;
            padding: 1.5rem;
            text-align: center;
        }
        
        .logo {
            height: 3rem;
            margin-bottom: 1rem;
        }
        
        .title {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin: 0;
        }
        
        .content {
            padding: 2rem;
        }
        
        .subtitle {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .verification-section {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .verification-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1rem;
        }
        
        .verification-text {
            color: #4b5563;
            margin-bottom: 1.5rem;
        }
        
        .code-container {
            display: flex;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }
        
        .code-digit {
            width: 3rem;
            height: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f3f4f6;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            transition: all 0.2s ease;
        }
        
        .expiry-text {
            color: #6b7280;
            font-size: 0.875rem;
        }
        
        .action-button {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #2563eb;
            color: white;
            font-weight: 500;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: background-color 0.2s;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .action-button:hover {
            background-color: #1d4ed8;
        }
        
        .footer {
            margin-top: 2.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 0.875rem;
        }
        
        .footer p {
            margin: 0;
        }
        
        .footer p + p {
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div style="display: flex; justify-content: center; margin-bottom: 1rem;">
                <img src="https://via.placeholder.com/150" alt="FaceLite Logo" class="logo">
            </div>
            <h1 class="title">FaceLite</h1>
        </div>

        <div class="content">
            <h3 class="subtitle">Bonjour, veuillez saisir se code pour changer votre mot de passe</h3>
            
            <div class="verification-section">
                <h2 class="verification-title">Verifiez votre compte</h2>
                <p class="verification-text">Voici votre code de verification :</p>
                
                <div class="code-container" id="code-container">';
        
        foreach ($codeDigits as $digit) {
            $mail->Body .= '<div class="code-digit">'.$digit.'</div>';
        }
        
        $mail->Body .= '</div>
                <p class="expiry-text">Ce code expirera dans 5 minutes</p>
            </div>    
            
            <div style="text-align: center; margin-top: 1.5rem;">
                <p>Veuillez entrer ce code dans l\'application pour confirmer votre compte.</p>
            </div>

            <div class="footer">
                <p>Si vous n\'avez pas demande ce code, vous pouvez ignorer cet email.</p>
                <p>© '.date('Y').' FaceLite. Tous droits réservés.</p>
            </div>
        </div>
    </div>
</body>
</html>';

        $mail->AltBody = "Bonjour\n\nVoici votre code de verification pour FaceLite : $verification_code\n\nCe code expirera dans 5 minutes.\n\nSi vous n'avez pas demandé ce code, veuillez ignorer cet email.";

        if($mail->send()) {
            return ["success" => true, "message" => "Un code de verification a été envoyé à votre adresse email. Veuillez l'entrer pour confirmer votre compte."];
        } else {
            return ["success" => false, "message" => "Échec d'envoi de l'email de verification."];
        }
    } catch (Exception $e) {
        return ["success" => false, "message" => "Erreur lors de l'envoi de l'email: " . $e->getMessage()];
    }
}
?>