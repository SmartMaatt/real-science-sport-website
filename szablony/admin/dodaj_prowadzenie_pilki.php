<?php 
	/*SECURED*/
	if (session_status() == PHP_SESSION_NONE) {
		header('Location: ../../logowanie.php');
	}
?>


<div class="row">
	<div class="col-12">
	  <div class="card">
		<div class="card-header">
		  <h2 class="card-title" id="basic-layout-tooltip">Prowadzenie piłki</h2>
		  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
		   <div class="card-text">
				<p>Załącz arkusz excel w celu dodania badań "Prowadzenie piłki"</p>
			</div>
		</div>
		<div class="card-content">
		  <div class="card-body pt-0">
			
			<div class="px-2">
				<!--
				<h1>Drop zone</h1>
				<form action="rozchodniaczki/upload_excel.php" method="POST" class="dropzone" id="dropzoneFrom" enctype="multipart/form-data">
					<input type="hidden" name='badanie' value="biofeedback_eeg" />
				</form>
				<input type="submit" class="btn btn-info mt-1" id="submit-all" value="Dodaj" />
				-->
				<h1>BRAK PLIKU EXCEL!</h1>
			</div>
			
		  </div>
		</div>
	  </div>
	</div>
</div>