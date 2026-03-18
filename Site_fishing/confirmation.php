<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion réussie</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            background-color: #000;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .box {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.75);
            padding: 60px;
            border-radius: 8px;
            width: 450px;
        }
        
        .icon {
            font-size: 48px;
            color: #2ecc71;
            margin-bottom: 20px;
        }
        
        h1 {
            margin-bottom: 20px;
        }
        
        .btn {
            display: inline-block;
            background-color: #e50914;
            color: #fff;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        
        .btn:hover {
            background-color: #f40612;
        }
    </style>
</head>
<body>
    <div class="box">
        <div class="icon">✓</div>
        <h1>Connexion réussie !</h1>
        <p>Vous êtes maintenant connecté.</p>
        <a href="Formulaire.php" class="btn">Retour</a>
    </div>
</body>
</html>