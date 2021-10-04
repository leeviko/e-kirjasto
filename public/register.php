<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap" rel="stylesheet"> 
  <link rel="stylesheet" href="style.css"> 
  <title>E-Kirjasto - Rekisteröidy</title>
</head>
<body>
  <?php 
    include_once "../includes/navbar.inc.php";
    include_once "../php/register.php";
  ?>

  <div class="sign content">
    <div class="sign-container">
      <div class="sign-wrapper">
        <div class="sign-content">
          <h1 class="sign-title title">Rekisteröidy</h1>
          <form class="sign-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="username">Käyttäjänimi</label>
            
            <?php if(!empty($username_err)){echo "<span class='error'>$username_err</span>";} ?>
            <input class="input" type="text" name="username" class="<?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>">
            <label for="email">Email</label>
            
            <?php if(!empty($email_err)){echo "<span class='error'>$email_err</span>";} ?>
            <input class="input" type="text" name="email" class="<?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
            <label for="password">Salasana</label>
            
            <?php if(!empty($password_err)){echo "<span class='error'>$password_err</span>";} ?>
            <input class="input" type="password" name="password" class="<?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
            <label for="confirm_password">Vahvista salasana</label>
            
            <?php if(!empty($confirm_password_err)){echo "<span class='error'>$confirm_password_err</span>";} ?>      
            <input class="input" type="password" name="confirm_password" class="<?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
            <?php 
              if(!empty($register_err)){
                echo "<span class='invalid-feedback'>$register_err</span>";
              } 
            ?>

            <div class="login-btn-container">
            <button type="submit" class="sign-btn btn">Rekisteröidy</button>
            </div>
            <span class="notice">On jo käyttäjätunnus? <a href="login.php">Kirjaudu Sisään</a></span>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>