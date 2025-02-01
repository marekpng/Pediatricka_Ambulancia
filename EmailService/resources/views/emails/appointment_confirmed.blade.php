<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Potvrdenie rezervácie</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
<div style="max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
    <h2 style="color: #333;">✅ Vaša rezervácia bola potvrdená</h2>
    <p>Dobrý deň, <strong>{{ $name }}</strong>,</p>
    <p>Vaša rezervácia bola úspešne potvrdená. Nižšie sú uvedené detaily rezervácie:</p>

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Dátum:</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $date }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Čas:</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $time }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Kontakt:</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $contact_number }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Popis:</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $description ?? 'Nebol zadaný žiadny popis' }}</td>
        </tr>
    </table>

    <p>Ak máte akékoľvek otázky, kontaktujte nás.</p>

    <p>S pozdravom,</p>
    <p><strong>Pediatrická Ambulancia Rišnovská</strong></p>
</div>
</body>
</html>
