<!--
/*---------------------------------------------------------------------------------------------
 *  Juan José Rubio Iglesias
 *  Practica de PHP de mantenimiento de tablas con PDO
 *  modificar.php - ventana para borrar un departamento
 *                  recibe como parametro el codigo del departamento mediante GET
 *                  ?codDepartamento=XXX
 *--------------------------------------------------------------------------------------------*/
-->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<!-- Material design -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="https://code.getmdl.io/1.2.1/material.indigo-pink.min.css">
		<script defer src="https://code.getmdl.io/1.2.1/material.min.js"></script>
	<!-- Material design -->
	<style>
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
		body{
			background-image:url(bg.png);
			background-repeat: no-repeat;
			background-position: center;
		}
	</style>
</head>

<body>
<div id="centrado">
	<?php
		//libreria con las variables con el host usuario password y base de datos
		include_once("conexiondb.php");

		// Comprobamos si recibimos por parametro el codigo del departamento
		if(isset($_GET['codDepartamento']))
		{
			try{
				$db = new PDO("mysql:host=$hostdb;dbname=$nombredb", $usuariodb,$passdb);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				// Almacenamos la consulta en un string
				$str_query="select * from Departamento where codDepartamento='".$_GET['codDepartamento']."'";

				// Ejecutamos la consulta -- En caso de que salte algun error sera capturada por el try catch
				$resultado = $db->query($str_query);

				if($resultado->rowCount()>0)
				{

					$obj = $resultado->fetch(PDO::FETCH_OBJ);


					//Mostramos los campos del input con sus respectivos valores de la base de datos
					print" <form action=\"eliminar.php\" method=\"post\" >
							<p>¿Esta seguro de borrar el departamento?</p>
							<div class='mdl-textfield mdl-js-textfield'>
								<input readonly class='mdl-textfield__input' type='text' name='codDepartamento' id='inputCod' maxlength='3' value=\"$obj->codDepartamento\" >
							</div>

							<br>
							<div class='mdl-textfield mdl-js-textfield'>
								<textarea readonly maxlength='255'  class='mdl-textfield__input' type='text' rows= '3' id='inputDesc' name='descDepartamento' >$obj->descDepartamento</textarea>
								<label class='mdl-textfield__label' for='inputDesc'></label>

							</div>
							<br>
							<input type='submit' name='enviar' value='Eliminar' class='mdl-button mdl-js-button mdl-button--raised mdl-button--colored'>
							<button formaction='buscar.php' class='mdl-button mdl-js-button mdl-button--raised mdl-button--colored'>Volver</button>
							</form>";
				}else{
					echo "No se ha encontrado ningun registro con ese codigo<br>";
					echo "<button onclick='window.location.href=\"buscar.php\"' class='mdl-button mdl-js-button mdl-button--raised mdl-button--colored'>Volver</button>";
				}

			}catch (PDOException $e) {

					switch($e->getCode())
					{
						case 23000:
							echo "Error 23000: El registro ya existe";
							break;
						default:
							print "Se ha producido un error con la base de datos, codigo: ".$e->getCode()."<br>";
							break;
					}
					echo "Error al ejecutar la consulta es probable que el campo no exista";
					echo "<button onclick='window.location.href=\"buscar.php\"'>Volver</button>";
					//En caso de encontrarse un error detenemos la ejecucion del codigo

					die();
				}





		}else{
			echo "¿Que intentas hacer?";
		}


	   if(isset($_POST['enviar']))
		{
			try{
				$db = new PDO("mysql:host=$hostdb;dbname=$nombredb", $usuariodb,$passdb);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				// Almacenamos la consulta en un string
				$str_query="DELETE FROM Departamento WHERE codDepartamento=\"".$_POST['codDepartamento']."\"";

				// Ejecutamos la consulta -- En caso de que salte algun error sera capturada por el try catch
				$resultado = $db->exec($str_query);


				// Mostramos el alert de que todo ha ido correctamente
				echo "<script>alert('Campo eliminado correctamente'); window.location.href='buscar.php';</script>";



			}catch (PDOException $e) {
				print "Se ha producido un error con la base de datos, codigo: ".$e->getCode()."<br>";
				echo "<button onclick='window.location.href=\"buscar.php\"'>Volver</button>";
				//En caso de encontrarse un error detenemos la ejecucion del codigo
				die();
			}

		}
	?>
</div>
</body>
</html>
