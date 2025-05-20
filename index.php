<?php
session_start();
if (isset($_SESSION['user'])) {
  header("Location: dashboard.php");
  exit();
}
if($_SERVER['REQUEST_METHOD'] === "GET")
{
  if(isset($_GET['result']))
  {
    if($_GET['result'] === "incorrect")
    {
      ?>
      <script>alert('Identifiants incorrects');</script>
      <?php
    }
  }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>GetScooter - Connexion</title>
  <script src="./assets/script/script.js"></script>
  <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .square {
            position: absolute;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            animation: float 15s infinite linear;
            opacity: 1;
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
            }
        }

        .login-container {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 100, 255, 0.3);
            width: 350px;
            text-align: center;
            position: relative;
            z-index: 10;
            border: 1px solid rgba(0, 100, 255, 0.2);
            backdrop-filter: blur(5px);
        }

        .login-container h1 {
            color: #0064ff;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 600;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-group input {
            width: 100%;
            padding: 12px 15px;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: white;
            font-size: 14px;
            transition: all 0.3s;
        }

        .input-group input:focus {
            outline: none;
            border-color: #0064ff;
            box-shadow: 0 0 10px rgba(0, 100, 255, 0.3);
        }

        .input-group label {
            position: absolute;
            left: 15px;
            top: 12px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            transition: all 0.3s;
            pointer-events: none;
        }

        .input-group input:focus + label,
        .input-group input:not(:placeholder-shown) + label {
            top: -10px;
            left: 10px;
            font-size: 12px;
            background-color: #000;
            padding: 0 5px;
            color: #0064ff;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background-color: #0064ff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .login-btn:hover {
            background-color: #0052cc;
            box-shadow: 0 0 15px rgba(0, 100, 255, 0.5);
        }

        .forgot-password {
            display: block;
            margin-top: 15px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 13px;
            text-decoration: none;
            transition: color 0.3s;
        }

        .forgot-password:hover {
            color: #0064ff;
        }
    </style>
    <script src="./assets/icons/fontawesome-free-6.7.2-web/js/all.min.js" defer></script>
</head>
<body class="login-body">
  
  <div id="squares-container">

  </div>

    <!-- Login form -->
  <div class="login-container">
      <h1>Connexion getScooter</h1>
      <form action="login.php" method="POST">
          <div class="input-group">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <label for="username">Nom d'utilisateur</label>
          </div>
          <div class="input-group">
            <input type="password" name="password" placeholder="Mot de passe" required>
            <label for="password">Mot de passe</label>
          </div>
          <button type="submit" class="login-btn">Se connecter</button>
      </form>
  </div>
</body>
</html>
