<?php
	require_once("../_header.php");
	
	$login = (isset($_GET['login'])) ? $_GET['login'] : "false";
	
	if($login != "true") {
		$user = (isset($_SESSION['username'])) ? $_SESSION['username']: "";
		$pass = (isset($_SESSION['sha1_password'])) ? $_SESSION['sha1_password']: "";		
		
		if (!isset($user) || !isset($pass)) {
			die(header("Location: ./index.php?login=true"));
		}
		elseif (empty($user) || empty($pass)) {
			die(header("Location: ./index.php?login=true"));
		} else {
			// Deze querie is er om te kijken of de gevenens in de database voor komen
			$result = "SELECT * FROM gegevens WHERE username='{$user}' AND password='{$pass}' AND admin = 1";
			// Hier wordt gekeken of de gegevens kloppen
			if(!$result = $mysqli->query($result)) trigger_error('Fout in query: '.$mysqli->error);
			else {
				$count = mysqli_num_rows($result);
				// Als de gegevens bestaan word je doorverwezen naar de pagina van de bestellingen
				if($count <= 0) die(header("Location: ./?login=true"));
				
				$q = "SELECT * FROM gegevens";
				
				if(!$people = $mysqli->query($q)) trigger_error('Fout in query: '.$mysqli->error);
				else {
				 	echo '
					<table class = "table table-fields">
						<thead>
							<tr>
								<td>#</td>
								<td>Gebruikersnaam</td>
								<td>E-mail</td>
								<td>Delete</td>
							</tr>
						</thead>
						<tbody>
						';
					
					while ($r = $people->fetch_array(MYSQLI_ASSOC)) {
						$timestamp = strtotime($r['timestamp']);
					?>
						<tr>
							<td><?php echo $r['id']; ?></td>
							
							<td><?php echo '<a href="http://snelkoppeling.info/user/?user='.$r['username'].'">'.$r['name'].'</a>'; ?></td>
							<td><?php echo $r['email']; ?></td>
							<td>
								<?php echo '<a href="delete.php?id='.$r['id'].'">X</a>'; ?>
							</td>
						</tr>
					<?php
					}
					echo "</tbody></table>";
				}
 

			}
		}
	} else {
?>
		<form enctype="multipart/form-data" action="login/sessions/create/" method="POST" class="questions-form">
			<fieldset>
				<label for="wachtwoord">Gebruikersnaam*</label>
				<input type="text" id="user" name="user" placeholder="Gebruikersnaam"/>
			</fieldset>
			
			<fieldset>
				<label for="wachtwoord">Wachtwoord*</label>
				<input type="password" id="wachtwoord" name="password" placeholder="Wachtwoord"/>
			</fieldset>
			
			<fieldset class="form-actions">
				<input type="submit" id="submit" name="submit" value="Inloggen"/>
			</fieldset>
		</form>
<?php	
	}
	require_once("../_footer.php");
?>		