<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Bienvenue sur HealthPass</title></head>
<body style="margin:0;background:#f3f7fa;font-family:Arial,sans-serif;color:#17324d">
<div style="max-width:620px;margin:32px auto;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 8px 28px rgba(15,42,67,.1)">
    <div style="background:#0c6b78;padding:28px 34px;color:#fff"><div style="font-size:25px;font-weight:700">HealthPass<span style="color:#9de1d6">.</span></div><div style="margin-top:10px;font-size:14px;opacity:.9">Plateforme médicale sécurisée</div></div>
    <div style="padding:34px"><p style="font-size:18px">Bonjour <strong>{{ $name }}</strong>,</p><p>Votre compte HealthPass a été créé par l’administration de votre établissement en tant que <strong>{{ $roleLabel }}</strong>.</p>
        <div style="margin:24px 0;padding:20px;background:#eef8f7;border-left:4px solid #0c6b78;border-radius:8px"><p style="margin:0 0 10px;font-weight:700">Vos identifiants temporaires</p><p style="margin:6px 0">Adresse : <strong>{{ $email }}</strong></p><p style="margin:6px 0">Mot de passe : <strong>{{ $temporaryPassword }}</strong></p></div>
        <p style="font-size:14px;line-height:1.6"><strong>Important :</strong> pour protéger vos données, vous devrez obligatoirement choisir un nouveau mot de passe dès votre première connexion.</p>
        <p style="text-align:center;margin:28px 0"><a href="{{ $loginUrl }}" style="display:inline-block;padding:13px 24px;background:#0c6b78;color:#fff;text-decoration:none;border-radius:8px;font-weight:700">Accéder à mon espace</a></p>
        <p style="font-size:13px;color:#607487">Si vous n’êtes pas à l’origine de cette demande, contactez l’administration de votre établissement.</p>
    </div>
    <div style="padding:18px 34px;background:#f7fafb;color:#607487;font-size:12px">HealthPass — Vos données médicales, protégées.</div>
</div>
</body>
</html>
