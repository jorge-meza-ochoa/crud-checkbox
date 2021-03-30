				<?php 
				
				include'../autoload.php';
				$conexion = new Conexion();
				$conexion = $conexion->get_conexion();
				
				$option = $_REQUEST['op'];
				
				switch ($option) {
				case '1':
				try {
				$query = "SELECT * FROM usuarios ";
				$statement = $conexion->prepare($query);
				$statement->execute();
				$result = $statement->fetchAll(PDO::FETCH_ASSOC);
				$json = [
				
				"sEcho" => 1,
				"iTotalRecords" =>count($result),
				"iTotalDisplayRecords"=>count($result),
				"aaData" =>$result
				];
				echo json_encode($json);
				} catch (Exception $e) {
				echo "error".$e->getMessage();
				}
				
				break;
				
				case 2:
				
				$nombre      = $_REQUEST['nombre'];
				$apellido    = $_REQUEST['apellido'];
				$accion      = $_REQUEST['accion'];
				$archivo     = $_FILES['imagen'];
				$extension   = pathinfo($archivo['name'],PATHINFO_EXTENSION);
				$name_file   = $nombre.'.'.$extension;
				
				$filename    = $archivo['tmp_name'];
				$destination = "../uploads/".$name_file;
				
				//Subir Archivo
				if(move_uploaded_file($filename, $destination))
				{
				echo "archivo subido";
				}
				else
				{
				echo "error al subir archivo";
				}
				
				//Subir Ruta al PDF
				if($accion=="agregar"){
				
				try {
				
				$query     = "INSERT INTO usuarios(nombres,apellidos,imagen)VALUES(:nombre,:apellido,:imagen)";
				$statement = $conexion->prepare($query);
				$statement->bindParam(':nombre',$nombre);
				$statement->bindParam(':apellido',$apellido);
				$statement->bindParam(':imagen',$name_file);
				$statement->execute();
				echo "Archivo Agregado";
				
				
				} catch (Exception $e) {
				
				echo "Error: ".$e->getMessage();
				
				}
				}else{
				
				
				
				}
				break;
				
				case '3':  
				
				$id = $_REQUEST['id'];
				
				try {

				
				$query = "DELETE FROM usuarios WHERE id=:id ";
				$statement = $conexion->prepare($query);
				$statement->bindParam(':id',$id);
				$statement->execute();
				echo "se elimino";
			
				} catch (Exception $e) {
					echo "error".$e->getMessage();
				}
				
				break;
				
				
				default:
				# code...
				break;
				}

               

 ?>