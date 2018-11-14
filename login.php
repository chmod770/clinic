<?php
session_start();
if(isset($_SESSION['id']) && isset($_SESSION['type']))
{
	header("Location: index.php");
	die();
}
?>

<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Patmed</title>

	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/simple.css" rel="stylesheet">
	  <style>
		  body
		  {
              background: #123456 url("img/background.jpg") no-repeat fixed center;
              background-size: 100% 100%;
          }
	  </style>
  </head>
  <body>
  <div class="login-box">
		<div class="login white">
			<h3>Logowanie</h3><hr>
			 <form action="login.php" enctype="multipart/form-data" method="post" class="top30">
				<label for="type">Typ konta</label>
				<select name="type">
					<option value="doctor">Lekarz</option>
					<option value="patient">Pacjent</option>
					<option value="admin">Aministrator/Recepcjonistka</option>
				</select><br><br>
				<label for="login">Pesel</label>
				<input type="text" name="login"><br><br>
				<label for="password">Hasło</label>
				<input type="password" name="password"><br>
				<input type="submit" name="submit" value="Zaloguj">
				 <?php
				 if(isset($_SESSION['error']))
					 echo '<br><div class="alert alert-danger top10"><strong>Danger!</strong> Błędny login lub hasło!<br> upewnij się że wybrałeś odpowiedni typ konta!</div>';
				 unset($_SESSION['error']);
				 ?>
			</form>
		</div>
  </div>
 
<?php

if(isset($_REQUEST['submit']))
{
			include "klasy.php";

			if($_REQUEST['type']=="admin")
			{
				if($_POST['login']=="0909091234567" && md5($_POST['password'])=="a66abb5684c45962d887564f08346e8d")
				{
					$_SESSION['id']="admin";
					$_SESSION['user_type']="admin";
					header("Location: index.php");
					die();
				}else
				{
					$_SESSION['error']=true;
					header("Location: login.php");
					die();
				}
			}

			if($_REQUEST['type']=="patient")
			{
				$connection = new Connection();
				$result=$connection->Set("SELECT * FROM pacjent WHERE Haslo='".md5($_POST['password'])."'");
				echo "SELECT * FROM pacjent WHERE Haslo='".md5($_POST['password'])."'";
				if($result->num_rows>0)
				{
					$_SESSION['id']=$_POST['login'];
					$_SESSION['user_type']="patient";
					header("Location: index.php");
					die();
				}else
				{
					$_SESSION['error']=true;
					header("Location: login.php");
					die();
				}
			}

			if($_REQUEST['type']=="doctor")
			{
					$connection = new Connection();
					$result=$connection->Set("SELECT * FROM lekarz WHERE Haslo='".md5($_POST['password'])."'");

					if($result->num_rows>0)
					{
						$_SESSION['id']=$_POST['login'];
						$_SESSION['user_type']="doctor";
						header("Location: index.php");
						die();
					}else
					{
						$_SESSION['error']=true;
						header("Location: login.php");
						die();
					}

			}

}
include "template/footer.php";

?>