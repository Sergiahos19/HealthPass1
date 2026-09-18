<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carnet médical</title>
</head>
<body style="margin:0; padding:0; background-color:#eef4f8; font-family:Arial, Helvetica, sans-serif; color:#1f2937;">
    <div style="max-width:640px; margin:32px auto; background:#ffffff; border:1px solid #dfe7ee; border-radius:14px; overflow:hidden;">
        <div style="background:linear-gradient(135deg, #0f766e 0%, #14b8a6 100%); padding:28px 24px; color:#ffffff; text-align:center;">
            <div style="display:inline-block; font-size:32px; font-weight:700; line-height:1.2; letter-spacing:0.04em; color:#ffffff; text-align:center;">Health Pass</div>
        </div>

        <div style="padding:30px 32px 26px;">
            <p style="margin:0 0 18px; font-size:16px; line-height:1.7; color:#1f2937;">
                Bonjour <strong>{{ $patientName }}</strong>,
            </p>

            <p style="margin:0 0 18px; font-size:16px; line-height:1.7; color:#1f2937;">
                Votre carnet médical est disponible en pièce jointe à ce message.
            </p>

            <p style="margin:0 0 20px; font-size:16px; line-height:1.7; color:#1f2937;">
                Ce document est confidentiel et doit être conservé dans un espace sécurisé. Il est destiné à votre suivi médical et à votre prise en charge.
            </p>

            <div style="background:#f0fdfa; border-left:4px solid #14b8a6; padding:14px 16px; border-radius:10px; margin:0 0 22px;">
                <p style="margin:0; font-size:14px; line-height:1.6; color:#0f172a;">
                    Pour toute question ou demande d’information, veuillez contacter votre établissement de santé : <strong>{{ $senderName }}</strong>
                </p>
            </div>

            <p style="margin:0; font-size:16px; line-height:1.7; color:#1f2937;">
                Cordialement,<br>
                <strong>{{ $senderName }}</strong>
            </p>
        </div>
    </div>
</body>
</html>
