<?php

session_start();

include("C:xampp\htdocs\Portal_RH\database\conexao.php");

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM Usuarios 
        WHERE email = '$email' 
        AND senha = '$senha'";

$resultado = $conn->query($sql);

if($resultado->num_rows > 0){

    $_SESSION['usuario'] = $email;

    header("Location: ../dashboard.php");

}else{

    header("Location: ../login.php?erro=1");

}

?>