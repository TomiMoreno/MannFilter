<?php

include 'conexion.php';

$id = $_GET['id'];

$sql = "DELETE FROM lista_negra WHERE usuario = '$id'";

$result = mysqli_query($conexion, $sql);

header('Location: blacklist.php');