<?php include __DIR__ . '/includes/pdo.php'; ?>

<?php

$error="";

if ($_SERVER['REQUEST_METHOD']==='POST'){
  $username=$_POST['username'];
  $password=$_POST['password'];
  

  if(empty($username)|| empty($password))
  {$error="Compila tutti i campi";} 
  else {
$stmt=$pdo->prepare("SELECT COUNT(*) FROM users WHERE username=? ");
  $stmt->execute([$username]);
  $count =$stmt->fetchColumn();


  if ($count > 0){

    $error= "L'username è gia in uso, cambialo";
  } else {

$hashedPassword=password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->execute([$username, $hashedPassword]);

header("Location: index.php");
        exit;

    }
  }
}


?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <?php if (!empty($error)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <form action="" method="post" class="mt-5">
      <h1>Register with your Info</h1>
        <div class="mb-3">
            <label for="exampleInputUsername1" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" id="exampleInputusername1" aria-describedby="usernameHelp">
            <div id="usernameHelp" class="form-text">We'll never share your username with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="exampleInputPassword1">
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
        <a href="index.php" class="btn btn-secondary">Log in</a>
    </form>
</div>
</body>
</html>