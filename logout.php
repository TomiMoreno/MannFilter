<?php 
	session_start();
	$varsesion = $_SESSION['usuario'];
	if($varsesion == null || $varsesion = ''){
		echo 'Usted no puede acceder a esta pagina';
		die();
	} 
	session_destroy();
	?>
    <script type="text/javascript">
        window.location="index.html"; 
    </script> 
<?php	
?>