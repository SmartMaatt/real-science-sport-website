<?php
	/*SECURED*/
	if (session_status() == PHP_SESSION_NONE) {
		header('Location: ../../logowanie.php');
	}
	
	$badanie = "";
	$nazwa_badania = "";
	switch ($id_opcji)
	{
	case 1:
		$badanie = "biofeedback_eeg";
		$nazwa_badania = "Biofeedback EEG";
		break;
	case 2:
		$badanie= "analiza_skladu_ciala";
		$nazwa_badania = "Analiza składu ciała";
		break;
	case 3:
		if($_SESSION['id_podopcji'] == 1)
		{
			$badanie = "test_szybkosci"; 
			$nazwa_badania = "Test szybkości";
		}
		elseif($_SESSION['id_podopcji'] == 2)
		{
			$badanie = "rast_test"; 
			$nazwa_badania = "Rast test";
		}
		else
		{
			$badanie = "prowadzenie_pilki";
			$nazwa_badania = "Prowadzenie piłki";
		}
		break;
	case 4:
		$badanie = "analizator_kwasu_mlekowego";
		$nazwa_badania = "Analizator kwasu mlekowego";
		break;
	case 5:
		$badanie = "wzrostomierz";
		$nazwa_badania = "Wzrostomierz";
		break;
	case 6:
		$badanie = "beep_test";
		$nazwa_badania = "Beep test";
		break;
	case 7:
		$badanie = "opto_jump_next";
		$nazwa_badania = "Opto jump next";
		break;
	}
	
?>

<div class="row">
	<div class="col-12 col-md-4">
		<div class="card" >
			<div class="card-header">
			  <h2 class="card-title" id="basic-layout-tooltip">Informacje o badaniu: <?php echo $nazwa_badania;?></h2>
			   <div class="card-text">
					<p>
					
						<?php
						if(file_exists("app-assets/Opisy_badań/$nazwa_badania.txt")){
							$myfile = fopen("app-assets/Opisy_badań/$nazwa_badania.txt", "r");						
							echo fread($myfile,filesize("app-assets/Opisy_badań/$nazwa_badania.txt"));
							fclose($myfile);
						}
						else{
							echo "Unable to open file: </br><b>$nazwa_badania.txt</b>";
						}
						?>
					
					</p>
				</div>
				<a href="index.php#Biofeedback" class="btn btn-rss">Dowiedz się więcej</a>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-8 badanie_box">
	  <div class="card">
		<div class="card-header">
		  <h4 class="card-title">Tabela badań</h4>
			<div class="card-text">
				<p>Poniższa tabela zawiera informacje o przeprowadzonych badaniach. Kliknij przycisk <b>Wyświetl szczegóły</b> by zapoznać się ze szczegółowymi danymi i wykresami.</p>
			</div>
		</div>
		<div style="padding-top:0;" class="card-body">
		  
		<?php
			require_once "rozchodniaczki/connect.php";
			
			$connection = @new mysqli($host, $db_user, $db_password, $db_name);
			
			if($connection->connect_errno!=0)
			{
				echo "Error: ".$connection->connect_errno;
			}
			else
			{
				$i = 0;
				$id_klienta = $_SESSION['id_klienta'];
				$sql = "SELECT id_badania, data FROM $badanie WHERE id_klienta = '$id_klienta'";
				if($result = @$connection->query($sql))
				{
					echo '<table class="badanie_main"><tr><td>';
					
					
					echo '<table class="table table-bordered bg-white first">';
					echo '<thead class="thead-dark">';
					echo '<tr>';
					echo '<th scope="col">Data</th>';
					echo '<th scope="col">Szczegóły</th>';
					echo '</tr>';
					echo '</thead>';
					echo '</table>';
					
					
					
					echo '</td></tr><tr><td><div class="badanie_scroll_cont"><table class="table table-bordered bg-white second">';
					
					
					$id_opcji = $_SESSION['id_opcji'];
					$id_podopcji = $_SESSION['id_podopcji'];
					for($i; $i < $result->num_rows; $i++)
					{
						$row = $result->fetch_assoc();
						$id_badania = $row['id_badania'];
						$data = $row['data'];
						echo '<tr>';
						echo "<td><p>$data</p></td>";
						echo '<td>
								<a href="rozchodniaczki/id_opcji.php?o='.$id_opcji.'&p='.$id_podopcji.'&b='.$id_badania.'" class="btn btn-rss">Wyświetl szczegóły</a>
							 </td>';
						echo '</tr>';
					}
					
					echo '</table></div></td></tr>';
					echo '</table>';
									
					$result->free_result();
				}
				
				if($i == 0){
					echo '<h1 class="no_data_msg">Brak zarejestrowanych badań</h1>';
				}
				
				$connection->close();
			}
			/*
			switch ($_SESSION['id_opcji'])
						{
						case 1:
							$name = "Biofeedback EEG";
							$date = $row['data'];
							$chart_type = "bar";
							$labels = array('delta','theta','alpha','smr','beta1','beta2','hibeta','gamma');
							$data = array($row['delta'],$row['theta'],$row['theta'],$row['smr'],$row['beta1'],$row['beta2'],$row['hibeta'],$row['gamma']);
							break;
						case 2:
							$tytul = "Analiza składu ciała";
							$badanie = "analiza_skladu_ciala";
							break;
						case 3:
							if($_SESSION['id_podopcji'] == 1)
							{
								$tytul = "Test szybkości";
								$badanie = "test_szybkosci";
							}
							elseif($_SESSION['id_podopcji'] == 2)
							{
								$pomiar1 = $row['pomiar1'];
								$pomiar2 = $row['pomiar2'];
								$pomiar3 = $row['pomiar3'];
								$pomiar4 = $row['pomiar4'];
								$pomiar5 = $row['pomiar5'];
								$pomiar6 = $row['pomiar6'];
								$pomiar7 = $row['pomiar7'];
								$srednia = ($pomiar1 + $pomiar2 + $pomiar3 + $pomiar4 + $pomiar5 + $pomiar6 + $pomiar7)/7;
								
								$name = "Rast test";
								$date = $row['data'];
								$chart_type = "bar";
								$labels = array('1','2','3','4','5','6','7','średnia');
							}
							else
							{
								$tytul = "Prowadzenie piłki";
								$badanie = "prowadzenie_pilki";
							}
							break;
						case 4:
							$tytul = "Analizator kwasu mlekowego";
							$badanie = "analizator_kwasu_mlekowego";
							break;
						case 5:
							$wzrost = $row['wartosc'];
							$name = "Wzrostomierz";
							$chart_type = "bar";
							$labels = array('wzrost','wzrost tułowia');
							$data = array($wzrost,$wzrost_tulowia);
							break;
						case 6:
							$name = "Beep test";
							$date = $row['data'];
							$chart_type = "bar";
							$labels = array('level','hr_max');
							$data = array($row['level'],$row['hr_max']);
							break;
						case 7:
							$tytul = "Opto jump next";
							$badanie = "opto_jump_next";
							break;
						}	
						*/
		?>

		</div>
	  </div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
			  <h4 class="card-title">Porównanie badań</h4>
				<div class="card-text">
					<p>Wykres zawiera zmianę wartości wyników badań przedstawionych w powyższej tabeli.</p>
				</div>
			</div>
			<div style="padding-top:0;" class="card-body">
			
			
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
					//Pobierz potrzebne badanie
					$sql = "SELECT * FROM biofeedback_eeg WHERE id_klienta = '$id_klienta'";
					if($result = @$connection->query($sql))
					{
						$daty = array();
						
						class Dataset{}
						
						$delta = new Dataset();
						$delta->label = "delta";
						$delta_dane = array();
						
						$theta = new Dataset();
						$theta->label = "theta";
						$theta_dane = array();
							
						$alpha = new Dataset();
						$alpha->label = "alpha";
						$alpha_dane = array();
						
						$smr = new Dataset();
						$smr->label = "smr";
						$smr_dane = array();
						
						$beta1 = new Dataset();
						$beta1->label = "beta1";
						$beta1_dane = array();
						
						$beta2 = new Dataset();
						$beta2->label = "beta2";
						$beta2_dane = array();
						
						$hibeta = new Dataset();
						$hibeta->label = "hibeta";
						$hibeta_dane = array();
						
						$gamma = new Dataset();
						$gamma->label = "gamma";
						$gamma_dane = array();

						for($i = 0; $i < $result->num_rows; $i++)
						{
							//Odczytaj wartości z wiersza bazy
							$row = $result->fetch_assoc();
							
							array_push($daty, $row['data']);
							array_push($delta_dane, $row['delta']);
							array_push($theta_dane, $row['theta']);
							array_push($alpha_dane, $row['alpha']);
							array_push($smr_dane, $row['smr']);
							array_push($beta1_dane, $row['beta1']);
							array_push($beta2_dane, $row['beta2']);
							array_push($hibeta_dane, $row['hibeta']);
							array_push($gamma_dane, $row['gamma']);
							
						}
						$delta->data = $delta_dane;
						$theta->data = $theta_dane;
						$alpha->data = $alpha_dane;
						$smr->data = $smr_dane;
						$beta1->data = $beta1_dane;
						$beta2->data = $beta2_dane;
						$hibeta->data = $hibeta_dane;
						$gamma->data = $gamma_dane;
						
						//JSON do wyświetlenia na wykresie
						$display_type = "wykres_porownawczy";
						$name = "Biofeedback EEG";
						$date = $daty;
						$chart_type = "line";
						$data_sets = array($delta, $theta, $alpha, $smr, $beta1, $beta2, $hibeta, $gamma);

						for($j = 0; $j < count($data_sets); $j++){
							$data_sets[$j]->borderColor = 'rgba(247, 172, 37, 0.7)';
							$data_sets[$j]->fill = false;
						}


						$dane_badania = array($display_type, $name, $date, $chart_type, $data_sets);

						
						$result->free_result();
					}
					$connection->close();
				}
				
				//Canvas wykresu i przycisk powrotny
				echo "<canvas id='RSS_chart'></canvas>";
				?>

			</div>
		</div>
	</div>
</div>