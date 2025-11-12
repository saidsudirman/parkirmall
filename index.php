<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Intruksi Kerja Nomor 1 CSS -->
	<link rel="stylesheet" href="assets/bootstrap.css">
	

	<title>Hitung Biaya Parkir Mall</title>
</head>
<body>
	<div class="center">
		<div class="container border">
		<!-- Instruksi Kerja Nomor 2. -->
		<!-- Menampilkan logo Mall -->
		<img src="img/logo.png"  width="60" style="float:left; margin-right:10px;">
		

		<h2>Hitung Biaya Parkir Mall</h2>
		<div style="clear:both;"></div>
		<br>
		<form action="index.php" method="post" id="formPerhitungan">
			<div class="row">
				<!-- Masukan data plat nomor kendaraan. Tipe data text. -->
				<div class="col-lg-2"><label for="nama">Plat Nomor Kendaraan:</label></div>
				<div class="col-lg-2"><input type="text" id="plat" name="plat"></div>
			</div>

			<div class="row">
				<!-- Masukan pilihan jenis kendaraan. -->
				<div class="col-lg-2"><label for="tipe">Jenis Kendaraan:</label></div>
				<div class="col-lg-2">
					<?php 
						// <!-- Instruksi Kerja Nomor 3, 4, dan 5 -->
						$kendaraan = ["Truk", "Motor", "Mobil"];
						sort($kendaraan);
						// Instruksi 5: tampilkan sebagai radio
						foreach($kendaraan as $k){
							echo "<input type='radio' name='kendaraan' value='$k' required> $k <br>";
						}
						
					?>
				</div>
			</div>

			<div class="row">
				<!-- Masukan Jam Masuk Kendaraan -->
				<div class="col-lg-2"><label for="nomor">Jam Masuk [jam]:</label></div>
				<div class="col-lg-2">
					<select id="masuk" name="masuk">
					<option value="">- Jam Masuk -</option>
					<?php 
						// <!-- Instruksi Kerja Nomor 6 -->
						for($i=1; $i<=24; $i++){
								echo "<option value='$i'>$i</option>";
							}
					?>
					</select>
				</div>
			</div>

			<div class="row">
				<!-- Masukan Jam Keluar Kendaraan. -->
				<div class="col-lg-2"><label for="nomor">Jam Keluar [jam]:</label></div>
				<div class="col-lg-2">
					<select id="keluar" name="keluar">
					<option value="">- Jam Keluar -</option>
						<?php
							// <!-- Instruksi Kerja Nomor 6 -->
							for($i=1; $i<=24; $i++){
								echo "<option value='$i'>$i</option>";
							}
						?>

					</select>
				</div>
			</div>

			<div class="row">
				<!-- Masukan pilihan Member. -->
				<div class="col-lg-2"><label for="tipe">Keanggotaan:</label></div>
				<div class="col-lg-2">
					<input type='radio' name='member' value='Member'> Member <br>
					<input type='radio' name='member' value='Non-Member'> Non Member <br>
					
				</div>
			</div>

			<div class="row">
				<!-- Tombol Submit -->
				<div class="col-lg-2"><button class="btn btn-primary" type="submit" form="formPerhitungan" value="hitung" name="hitung">Hitung</button></div>
				<div class="col-lg-2"></div>		
			</div>
		</form>
	</div>
	</div>
	

	<?php

	if(isset($_POST['hitung'])) {
		$plat   = $_POST['plat'];
		$jenis  = $_POST['kendaraan'];
		$masuk  = (int)$_POST['masuk'];
		$keluar = (int)$_POST['keluar'];
		$member = $_POST['member'];
		

		// Instruksi Kerja Nomor 7 (hitung durasi)
		$durasi = $keluar - $masuk;
		if($durasi <= 0){ 
			$durasi = 1;
		}
		

		// Instruksi Kerja Nomor 8 (fungsi)
		function hitung_parkir($durasi, $jenis){
			if($jenis == "Mobil"){
				if($durasi <= 1){
					return 5000;
				} else {
					return 5000 + (($durasi-1) * 3000);
				}
			} elseif($jenis == "Motor"){
				if($durasi <= 1){
					return 2000;
				} else {
					return 2000 + (($durasi-1) * 1000);
				}
			} elseif($jenis == "Truk"){
				return $durasi * 6000;
			}
			return 0;
			// Instruksi Kerja Nomor 9 (kontrol percabangan)
			
		}

		// Instruksi Kerja Nomor 10 ($biaya_parkir)
		$biaya_parkir = hitung_parkir($durasi, $jenis);

		// Instruksi Kerja Nomor 11 (hitung diskon dan simpal hasil akhir setelah diskon pada variabel $biaya_akhir)
		if($member == "Member"){
		$diskon = 0.1 * $biaya_parkir;
		} else {
			$diskon = 0;
		}
		$biaya_akhir = $biaya_parkir - $diskon;

		$dataParkir = array(
			'plat'     => $plat,
			'kendaraan'=> $jenis,
			'masuk'    => $masuk,
			'keluar'   => $keluar,
			'durasi'   => $durasi,
			'member'   => $member,
			'biaya'    => $biaya_akhir
		);

		// Instruksi Kerja Nomor 12 (menyimpan ke json)
		$berkas = "data/data.json";

		$existing = [];
		if(file_exists($berkas)){
			$existing = json_decode(file_get_contents($berkas), true);
			if(!is_array($existing)) $existing = [];
		}
		
		$dataJson = json_encode($dataParkir, JSON_PRETTY_PRINT);
		file_put_contents($berkas, $dataJson);
		$dataJson = file_get_contents($berkas);
		$dataParkir = json_decode($dataJson, true);


		//	Menampilkan data parkir kendaraan.
		//  KODE DI BAWAH INI TIDAK PERLU DIMODIFIKASI!!!
		echo "
		<br/>
		<div class='container'>
		<div class='row'>
		<!-- Menampilkan Plat Nomor Kendaraan. -->
		<div class='col-lg-2'>Plat Nomor Kendaraan:</div>
		<div class='col-lg-2'>".$dataParkir['plat']."</div>
		</div>
		<div class='row'>
		<!-- Menampilkan Jenis Kendaraan. -->
		<div class='col-lg-2'>Jenis Kendaraan:</div>
		<div class='col-lg-2'>".$dataParkir['kendaraan']."</div>
		</div>
		<div class='row'>
		<!-- Menampilkan Durasi Parkir. -->
		<div class='col-lg-2'>Durasi Parkir:</div>
		<div class='col-lg-2'>".$dataParkir['durasi']." jam</div>
		</div>
		<div class='row'>
		<!-- Menampilkan Jenis Keanggotaan. -->
		<div class='col-lg-2'>Keanggotaan:</div>
		<div class='col-lg-2'>".$dataParkir['member']." </div>
		</div>
		<div class='row'>
		<!-- Menampilkan Total Biaya Parkir. -->
		<div class='col-lg-2'>Total Biaya Parkir:</div>
		<div class='col-lg-2'>Rp".number_format($biaya_akhir, 0, ".", ".").",-</div>
		</div>

		</div>
		";
	}
	?>

</body>
</html>