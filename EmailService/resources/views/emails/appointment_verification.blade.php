<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overenie rezervácie</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
<div style="max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
    <h2 style="color: #333;">🩺 Ďakujeme za vytvorenie rezervácie</h2>
    <p>Dobrý deň, <strong>{{ $name }}</strong>,</p>
    <p>Prosím, pre úspešné dokončenie vašej rezervácie kliknite na tlačidlo nižšie:</p>

    <a href="{{ $verification_url }}" style="display: inline-block; padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">Overiť rezerváciu</a>

    <p>Ak tlačidlo nefunguje, môžete použiť tento odkaz:</p>
    <p><a href="{{ $verification_url }}">{{ $verification_url }}</a></p>

    <p>Ak ste si túto rezerváciu nevytvorili, môžete tento e-mail ignorovať.</p>

    <p>S pozdravom,</p>
    <p><strong>Pediatrická Ambulancia Rišnovská</strong></p>
</div>
</body>
</html>
