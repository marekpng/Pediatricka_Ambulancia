<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upravenie rezervácie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
<div class="email-container">
    <h2>Vaša rezervácia bola upravená</h2>
    <p>Dobrý deň, <strong>{{ $details['name'] }}</strong>,</p>
    <p>Vaša rezervácia bola upravená lekárom. Nižšie sú uvedené podrobnosti:</p>

    <table>
        <tr>
            <td><strong>Predchádzajúci dátum:</strong></td>
            <td>{{ $details['old_date'] }}</td>
        </tr>
        <tr>
            <td><strong>Predchádzajúci čas:</strong></td>
            <td>{{ $details['old_time'] }}</td>
        </tr>
        <tr>
            <td><strong>Nový dátum:</strong></td>
            <td>{{ $details['new_date'] }}</td>
        </tr>
        <tr>
            <td><strong>Nový čas:</strong></td>
            <td>{{ $details['new_time'] }}</td>
        </tr>
        <tr>
            <td><strong>Kontakt:</strong></td>
            <td>{{ $details['contact_number'] }}</td>
        </tr>
        <tr>
            <td><strong>Popis:</strong></td>
            <td>{{ $details['description'] ?? 'Nebol zadaný žiadny popis.' }}</td>
        </tr>
    </table>

    <p>Ak máte akékoľvek otázky, kontaktujte nás.</p>

    <p class="footer">S pozdravom,</p>
    <p class="footer"><strong>Pediatrická Ambulancia Rišnovská</strong></p>
</div>
</body>
</html>
