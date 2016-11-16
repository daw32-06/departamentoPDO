<!--
/*---------------------------------------------------------------------------------------------
 *  Juan José Rubio Iglesias
 *  Practica de PHP de mantenimiento de tablas con PDO
 *  buscar.php - ventana para mostrar departamentos buscando por descripcion
 *--------------------------------------------------------------------------------------------*/
-->

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Departamento</title>

	<!-- Material design -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="https://code.getmdl.io/1.2.1/material.indigo-pink.min.css">
		<script defer src="https://code.getmdl.io/1.2.1/material.min.js"></script>
	<!-- Material design -->
	<style>
		body{
			background-image:url(bg.png);
			background-repeat: no-repeat;
			background-position: center;
		}
		#centrado{

			text-align: center;
			margin-right: auto;
			margin-left: auto;

		}
		table{
			margin-left: auto;
			margin-right: auto;
			min-width:650px;

		}
	</style>
</head>
<body>

<div id="centrado">
		<form action="buscar.php" method="post">

			<i class="material-icons">search</i> <!--<input type="text" name="patron" placeholder="Descripcion">-->
			<!-- Campo descripcion -->
			<div class="mdl-textfield mdl-js-textfield">
				<input class="mdl-textfield__input" type="text" name="patron" id="inputPatron">
				<label class="mdl-textfield__label" for="inputPatron">Descripcion</label>
			</div>
			 <input type="submit" name="buscar" value="Buscar" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
			<button formaction="insertar.php" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Nuevo departamento</button>

		</form>

	 <?php

		if(isset($_POST['buscar']))
		{

			print "
				<table class=\"mdl-data-table mdl-js-data-table\">
				<thead>
				<tr>
					<th class='mdl-data-table__cell--non-numeric'>Codigo</th>
					<th class='mdl-data-table__cell--non-numeric'>Descripcion</th>
					<th>Modificar</th>
					<th>Eliminar</th>
				</tr>
				</thead>
				<tbody>
			";




			//libreria con las variables con el host usuario password y base de datos
			include_once("conexiondb.php");

			//Conectamos con la base de datos
			try{
				$db = new PDO("mysql:host=$hostdb;dbname=$nombredb", $usuariodb,$passdb);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch (PDOException $e) {
				//!!!!!! $e->getCode() es una funcion no puede ir dentro del string tiene que concatenarse
				print "Error en la conexion con la base de datos, codigo: ".$e->getCode()."<br>";

				//En caso de encontrarse un error detenemos la ejecucion del codigo
				die();
			}


			try{
				// String de la consulta
				$str_query = "select * from Departamento where instr(descDepartamento,\"$_POST[patron]\")";

				// Guardamos el resultado del query
				$resultado = $db->query($str_query);

				// $obj es el equivalente a cada fila de la consulta
				while($obj = $resultado->fetch(PDO::FETCH_OBJ)){
					echo("<tr><td class='mdl-data-table__cell--non-numeric'>$obj->codDepartamento</td><td class='mdl-data-table__cell--non-numeric'>$obj->descDepartamento</td><td><a href=\"modificar.php?codDepartamento=".$obj->codDepartamento."\">Modificar</a></td><td><a href=\"eliminar.php?codDepartamento=".$obj->codDepartamento."\"><i class=\"material-icons\">delete</i></a></td></tr>");
				}

				//Mostramos el numero de resultados
				echo "Se han encontrado ".$resultado->rowCount()." resultados.";


			}catch(PDOException $e) {
				print "Error en la consulta, codigo: ".$e->getCode()."<br>";
			}



		}
	?>
	</tbody>
	</table>

</div>
</body>
</html>
