<!DOCTYPE html>
<html>
<head>
    <title>Vos identifiants de connexion</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; }
        h1, h2 { color: #0056b3; }
        p { margin-bottom: 10px; }
        .credentials { background-color: #e9ecef; border-left: 5px solid #0056b3; padding: 10px; margin-top: 20px; }
        .footer { margin-top: 20px; font-size: 0.8em; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bonjour {{ $user->prenom }} {{ $user->nom }},</h1>

        <p>Votre compte étudiant a été créé avec succès pour [Nom de votre Établissement].</p>
        <p>Vous pouvez maintenant vous connecter à votre espace étudiant en utilisant les identifiants ci-dessous :</p>

        <div class="credentials">
            <p><strong>Email de connexion :</strong> {{ $user->email }}</p>
            <p><strong>Mot de passe temporaire :</strong> {{ $password }}</p>
            <p>Nous vous recommandons de changer ce mot de passe dès votre première connexion.</p>
        </div>

        <p>Cliquez sur le lien ci-dessous pour accéder à la page de connexion :</p>
        <p><a href="{{ route('login') }}">{{ route('login') }}</a></p>

        <p>Si vous rencontrez des difficultés, n'hésitez pas à contacter notre support technique.</p>

        <div class="footer">
            <p>Cordialement,</p>
            <p>L'équipe de [Nom de votre Établissement]</p>
        </div>
    </div>
</body>
</html>
