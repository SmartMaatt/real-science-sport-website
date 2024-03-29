<?php
	/*SECURED*/
	if (session_status() == PHP_SESSION_NONE) {
		header('Location: ../../logowanie.php');
	}

	require_once "rozchodniaczki/connect.php";
	
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
	}
	else
	{
		$id_klienta = $_SESSION['id_klienta'];
		
		foreach($_POST as $key => $name)
		{
			$id_badania = $key;
		}
		$sql = "SELECT * FROM beep_test WHERE id_badania = '$id_badania'";
		if($result = @$connection->query($sql))
		{
			$row = $result->fetch_assoc();
			$display_type = "wykres_szczegolowy";
			$name = "Beep test";
			$date = $row['data'];
			$chart_type = "bar";
			$labels = array('level','hr_max');
			$data = array($row['level'],$row['hr_max']);
				
			$dane_badania = array($display_type, $name, $date, $chart_type, $labels, $data);			
			$result->free_result();
		}
		
		$connection->close();
	}
?>

<div class="row">
		<div class="col-12">
			<div class="card" >
				<div class="card-header">
				  <h2 class="card-title" id="basic-layout-tooltip"><?php echo $name." - badanie ".$date;?></h2>
					<div class="card-text">
						<p>Brak dodatkowych informacji na temat badania.</p>
					</div>
				</div>
				<div style="padding-top:0;" class="card-body">
					<?php
						//Canvas wykresu i przycisk powrotny
						echo "<canvas id='RSS_chart'></canvas>";
						echo '<a href="rozchodniaczki/id_opcji.php?o='.$_SESSION['id_opcji'].'&p='.$_SESSION['id_podopcji'].'&b=-1" class="btn btn-rss">Wróć</a>';
					?>
				</div>
			</div>
		</div>
	</div>