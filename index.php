<?php
if(!empty($_POST)){
		if(!isset($_POST['username'])){
			die('Falta usuario');
		}
		if(!isset($_POST['password'])){
			die('Falta password');
		}
		if(empty($_POST['username'])){
			die('Debes ingresar el usuario');
		}
		if(empty($_POST['password'])){
			die('Debes ingresar el password');
		}


		$conexion = mysqli_connect('localhost', 'profe93_test', 'Kennedy2020', 'profe93_test');
		$usuario = $_POST['username'];
		$password = $_POST['password'];
		$sql = "SELECT * FROM login WHERE usuario = '$usuario'";
		$respuesta = mysqli_query($conexion, $sql);
		$fila = mysqli_fetch_array($respuesta);
		if($fila){
			$password_en_db = $fila['pass'];
			if($password == $password_en_db){
				session_start();
				$_SESSION['login_ok'] = true;
				$_SESSION['usuario_id'] = $fila['id'];
				header("Location: pedidos.html");
				//die();

			}
			else{
				die("Contraseña incorrecta");
			}
		}
		else{
			die("Ususario inexistente");
		}
	}
?>

<html>
<head><meta charset="euc-jp">
    <script src="js/moscontra.js"></script>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

</head>
<body>
	<h1>Login</h1>

	<form method="POST">
		
        <input type="text" name="username" id="username" placeholder="Nombre de usuario...">
        <br>
        <input type="password" name="password" id="password" placeholder="Contraseña...">
        <button type="button" onclick="mostrarcontrasena()">Mostrar contraseña</button>
        <script>
		    function mostrarcontrasena(){
                var tipo = document.getElementById("password");
                if(tipo.type == "password"){
                    tipo.type = "text";
                }
                else{
                    tipo.type = "password";
                }
		    }

        </script>
        <br>
		<button type="submit">Loguearse</button>


	</form>

</body>
</html>