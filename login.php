<?php
include_once("Conexion.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = CConexion::conexionBD();

    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $query = "SELECT * FROM public.usuarios WHERE usuario = :usuario AND password = :password";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Inicio de sesión exitoso
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['rol'] = $user['rol'];
        header("Location: dashboard.php"); // Redirige a la página del panel de control
    } else {
        echo "Credenciales incorrectas";
    }
}
?>