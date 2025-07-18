<?php
function sendConfirmationEmail($email, $token, $firstname) {
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

        $mail->setFrom('erwin@face-lite.com', 'FaceLite');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Confirmation de votre compte FaceLite';

        // Utilisation du template amélioré avec token intégré
        $mail->Body = '
        <!DOCTYPE html>
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
                    line-height: 1.6;
                }
                
                .container {
                    max-width: 42rem;
                    margin: 2rem auto;
                    background-color: #ffffff;
                    border-radius: 0.75rem;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                    overflow: hidden;
                }
                
                .header {
                    background-color: #2563eb;
                    padding: 1.5rem;
                    text-align: center;
                }
                
                .logo-container {
                    display: flex;
                    justify-content: center;
                    margin-bottom: 1rem;
                }
                
                .logo {
                    height: 3rem;
                }
                
                .title {
                    font-size: 1.5rem;
                    font-weight: 700;
                    color: #ffffff;
                    margin: 0;
                }
                
                .content {
                    padding: 2rem;
                }
                
                .greeting {
                    font-size: 1.25rem;
                    font-weight: 600;
                    color: #1f2937;
                    margin-bottom: 1.5rem;
                }
                
                .btn {
                    display: inline-block;
                    padding: 0.75rem 1.5rem;
                    background-color: #2563eb;
                    color: #ffffff;
                    font-weight: 500;
                    border-radius: 0.5rem;
                    text-decoration: none;
                    transition: background-color 0.2s;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                }
                
                .btn:hover {
                    background-color: #1d4ed8;
                }
                
                .footer {
                    margin-top: 2.5rem;
                    padding-top: 1.5rem;
                    border-top: 1px solid #e5e7eb;
                    text-align: center;
                    font-size: 0.875rem;
                    color: #6b7280;
                }
                
                .footer p {
                    margin: 0.5rem 0;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <div class="logo-container">
                        <img src="https://votre-domaine.com/assets/images/facebook.png" alt="FaceLite Logo" class="logo">
                    </div>
                    <h1 class="title">FaceLite</h1>
                </div>

                <div class="content">
                    <h3 class="greeting">Bonjour '.htmlspecialchars($firstname).', veuillez confirmer votre compte</h3>
                    
                    <div style="text-align: center; margin-top: 1.5rem;">
                        <a href="http://localhost/Facelite/api/otp/confirm.php?token='.urlencode($token).'" class="btn">
                            Confirmer mon compte
                        </a>
                    </div>

                    <div class="footer">
                        <p>Si vous n\'avez pas demande ce code, vous pouvez ignorer cet email.</p>
                        <p>© '.date('Y').' FaceLite. Tous droits reserves.</p>
                    </div>
                </div>
            </div>
        </body>
        </html>';

        // Version texte alternative
        $mail->AltBody = "Bonjour $firstname,\n\nMerci de confirmer votre compte FaceLite en cliquant sur ce lien :\nhttp://localhost/Facelite/api/otp/confirm.php?token=$token\n\nSi vous n'avez pas créé de compte, ignorez cet email.";

        if($mail->send()) {
            return ["success" => true, "message" => "Inscription réussie. Vérifiez votre email pour confirmer."];
        } else {
            return ["success" => false, "message" => "Inscription réussie mais échec d'envoi de l'email de confirmation."];
        }
    } catch (Exception $e) {
        return ["success" => false, "message" => "Erreur lors de l'envoi de l'email: " . $e->getMessage()];
    }
}?>