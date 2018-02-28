<html>
	<head></head>
	<body>
		<div>
		<form name="userinput" action="save_userinput" method="post">
			Nombre de usuario: <input type='text' name="username" /><br>
			Contraseña: <input type='password'  name="password" /><br>
			<input type='submit'>
			
		</form>
		</div>
		<div>
			<?php
				foreach($query as $row){
					print $row->id;
					print $row->nombre;
					print $row->id_jerarquia;
					print "<br>";
				}
				
			?>
		</div>
	
	</body>
</html>