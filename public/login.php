<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap" rel="stylesheet"> 
  <link rel="stylesheet" href="style.css"> 
  <title>E-Kirjasto - Kirjaudu</title>
</head>
<body>
  <?php 
    include_once "../includes/navbar.inc.php";
    include_once "../php/login.php";
  ?>

  <div class="sign content">
    <div class="sign-container">
      <div class="sign-wrapper">
        <div class="sign-content">
          <h1 class="sign-title title">Kirjaudu Sisään</h1>
          <form class="sign-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="username">Käyttäjänimi</label>
            <?php if(!empty($username_err)){echo "<span class='error'>$username_err</span>";} ?>
            <input class="input" type="text" name="username" class="<?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>">
            <label for="password">Salasana</label>
            <?php if(!empty($password_err)){echo "<span class='error'>$password_err</span>";} ?>
            <input class="input" type="password" name="password" class="<?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
            <!-- <div class="muista">
              <label for="remember_me">Muista minut?</label>
              <input type="checkbox" name="remember_me" id="remember_me">
            </div> -->
            <?php 
              if(!empty($login_err)){
                echo "<span class='invalid-feedback'>$login_err</span>";
              } 
            ?>
            <div class="login-btn-container">
              <button type="submit" class="sign-btn btn">Kirjaudu Sisään</button>
            </div>
            <span class="notice">Ei ole käyttäjätunnusta? <a href="register.php">Rekisteröidy</a></span>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>