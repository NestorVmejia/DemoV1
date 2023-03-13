<?php   
    session_start();
    include('conexion.php');

    if (isset($_POST['usuario']) && isset($_POST['clave']) ) {

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $Usuario = validate($_POST['usuario']); 
    $Clave = validate($_POST['clave']);

    if (empty($Usuario)) {
        header("Location: index.php?error=El Usuario Es Requerido");
        exit();
    }elseif (empty($Clave)) {
        header("Location: index.php?error=La clave Es Requerida");
        exit();
    }else{
        $clave = md5($Clave);
        $Sqlu = "SELECT * FROM usuarios WHERE usuario = '$Usuario' AND clave='$Clave'";
        $result = mysqli_query($con, $Sqlu);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['usuario'] === $Usuario && $row['clave'] === $Clave) {
                $_SESSION['usuario'] = $row['usuario'];
                $_SESSION['Nombre'] = $row['Nombre'];
                $_SESSION['id'] = $row['id'];
                header("Location: inicio.php");
                exit();
            }else {
                header("Location: index.php?error=El usuario o la clave son incorrectas");
                exit();
            }

        }else {
            header("Location: index.php?error=El usuario o la clave son incorrectas");
            exit();
        }
    }

} else {
    header("Location: index.php");
            exit();
}