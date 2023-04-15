<?php

include_once("config.php");

if(isset($_POST['submit']))
	{
		$name = $_POST['emri'];
		$surname = $_POST['mbiemri'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$tempPass = $_POST['password'];
		$password = password_hash($tempPass, PASSWORD_DEFAULT);
        $repassword=$_POST=['confirm_password'];
        

		if(empty($name) || empty($surname) || empty($username) || empty($email) || empty($password))
		{
			echo "You need to fill all the fields.";
            header( "refresh:2; url=dashboard.php" ); 
		}
		else
		{
			$sql = "SELECT username FROM users WHERE username=:username";

			$tempSQL = $conn->prepare($sql);
			$tempSQL->bindParam(':username', $username);
			$tempSQL->execute();

			if($tempSQL->rowCount() > 0)
			{
				echo "Username exists!";
				header( "refresh:2; url=signup.php" ); 
			}
			else
			{
                if($tempPass!=$repassword){
                    echo "password do not match!";
                    header("refresh:2;url=index.php");
                }
				$sql = "insert into users (emri, mbiemri, username, email, password) values (:emri, :mbiemri, :username, :email, :password)";
				$insertSql = $conn->prepare($sql);
			
				$insertSql->bindParam(':emri', $name); 
				$insertSql->bindParam(':mbiemri', $surname); 
				$insertSql->bindParam(':username', $username);
				$insertSql->bindParam(':email', $email);
				$insertSql->bindParam(':password', $password);

				$insertSql->execute();

				echo "Data saved successfully ...";
				header( "refresh:2; url=login.php" ); 
			}
		}
	}

?>