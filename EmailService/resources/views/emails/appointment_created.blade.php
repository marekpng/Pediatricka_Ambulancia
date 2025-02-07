<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nový termín rezervácie</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
<div style="max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
    <h2 style="color: #333;">Bol vám vytvorený nový termín</h2>
    <p>Dobrý deň, <strong>{{ $details['name'] }}</strong>,</p>
    <p>Bol vám vytvorený nový termín na návštevu lekára. Nižšie sú uvedené detaily rezervácie:</p>

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Dátum:</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $details['date'] }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Čas:</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $details['time'] }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Kontakt:</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $details['contact_number'] }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Popis:</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $details['description'] ?? 'Žiadne dodatočné informácie' }}</td>
        </tr>
    </table>

    <p>Ak máte akékoľvek otázky, kontaktujte nás.</p>

    <p>S pozdravom,</p>
    <p><strong>Pediatrická Ambulancia Rišnovská</strong></p>
</div>
</body>
</html>
