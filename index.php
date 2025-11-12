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
	<div class="container border ">
		<!-- Instruksi Kerja Nomor 2. -->
		<!-- Menampilkan logo Mall -->
		<div class="d-flex justify-content-center " style="margin-top: 50px;">
			<img src="img/logo.png" alt="Logo Parkir" width="100px" class="logo d-flex center">
			<h2 class="mt-6 mx-3" style="margin-top: 30px;">Hitung Biaya Parkir Mall</h2>
		</div><br>

		<!-- form inputan -->
		<div class="container-fluid d-flex justify-content-center ">
			<div class="col-lg-6">

				<form action="index.php" method="post" id="formPerhitungan" class="mt-3">
					<div class="row">
						<!-- Masukan data plat nomor kendaraan. Tipe data text. -->
						<div class="col-lg-4"><label for="plat">Plat Nomor Kendaraan:</label></div>
						<div class="col-lg-4"><input type="text" id="plat" name="plat"></div>
					</div>

					<div class="row">
						<!-- Masukan pilihan jenis kendaraan. -->
						<div class="col-lg-4"><label for="tipe">Jenis Kendaraan:</label></div>
						<div class="col-lg-4" style="margin-left: 25px;">
							<!-- Instruksi Kerja Nomor 3, 4, dan 5 -->
							<?php
							//array 1d (nomor 3)
							$kendaraan = array("Truk", "Motor", "Mobil");

							//	Instruksi Kerja Nomor 4
							//	Mengurutkan array sesuai abjad A-Z.
							sort($kendaraan);

							// nomor 5
							foreach ($kendaraan as $k) {
								echo "
									<div class='form-check'>
										<input class='form-check-input' type='radio' name='kendaraan' value='$k'>
										<label class='form-check-label' for='$k'> $k</label>
									</div>
								";
							}
							?>
						</div>
					</div>

					<div class="row">
						<!-- Masukan Jam Masuk Kendaraan -->
						<div class="col-lg-4"><label for="nomor">Jam Masuk [jam]:</label></div>
						<div class="col-lg-4">
							<select id="masuk" name="masuk">
								<option value="">- Jam Masuk -</option>

								<!-- Instruksi Kerja Nomor 6 (jam Masuk)-->
								<?php
								for ($masuk = 1; $masuk <= 24; $masuk++) {
									echo "<option value='$masuk'>$masuk</option>";
								}
								?>

							</select>
						</div>
					</div>

					<div class="row">
						<!-- Masukan Jam Keluar Kendaraan. -->
						<div class="col-lg-4"><label for="nomor">Jam Keluar [jam]:</label></div>
						<div class="col-lg-4">
							<select id="keluar" name="keluar">
								<option value="">- Jam Keluar -</option>

								<!-- Instruksi Kerja Nomor 6 -->
								<?php
								for ($keluar = 1; $keluar <= 24; $keluar++) {
									echo "<option value='$keluar'>$keluar</option>";
								}
								?>

							</select>
						</div>
					</div>

					<div class="row">
						<!-- Masukan pilihan Member. -->
						<div class="col-lg-4"><label for="tipe">Keanggotaan:</label></div>
						<div class="col-lg-4">
							<input type='radio' name='member' value='Member'> Member <br>
							<input type='radio' name='member' value='Non-Member'> Non Member <br>

						</div>
					</div>

					<div class="row mb-4">
						<!-- Tombol Submit -->
						<div class="col-lg-4 d-flex justify-content-center mt-2" style="margin-left: 300px;">
							<button class="btn btn-primary" type="submit" form="formPerhitungan" value="hitung" name="hitung">Hitung</button>
						</div>
						<div class="col-lg-2"></div>
					</div>

				</form>
			</div>
		</div>

	</div>

	<?php

	// ketika button hitung klik
	if (isset($_POST['hitung'])) {
		$plat   = $_POST['plat'];
		$kendaraan  = $_POST['kendaraan'];
		$masuk  = (int)$_POST['masuk'];
		$keluar = (int)$_POST['keluar'];
		$member = $_POST['member'];


		// Instruksi Kerja Nomor 7 (hitung durasi)
		$durasi = $keluar - $masuk;
		if ($keluar > $masuk) {
			$durasi = $keluar - $masuk;
		} else {
			$durasi = (24 - $masuk) + $keluar;
		}


		// Instruksi Kerja Nomor 8 (fungsi)
		function hitung_parkir($durasi, $kendaraan)
		{

			// Instruksi Kerja Nomor 9 (kontrol percabangan)
			if ($kendaraan == "Mobil") {
				if ($durasi <= 1) {
					$biaya= 5000;
				} else {
					$biaya =  5000 + (($durasi - 1) * 3000);
					//durasi di atas 1 jam
				}
			} elseif ($kendaraan == "Motor") {
				if ($durasi <= 1) {
					$biaya=  2000;
				} else {
					$biaya=  2000 + (($durasi - 1) * 1000);
				}
			} elseif ($kendaraan == "Truk") {
				$biaya=  $durasi * 6000;
			}
			else{
				$biaya =0;
			}
			return $biaya; // mengembalikan nilai 
		}

		// Instruksi Kerja Nomor 10 ($biaya_parkir)
		$biaya_parkir = hitung_parkir($durasi, $kendaraan);


		// Instruksi Kerja Nomor 11 (hitung diskon dan simpal hasil akhir setelah diskon pada variabel $biaya_akhir)
		if ($member == "Member") {
			$diskon = 0.1 * $biaya_parkir;
		} else {
			$diskon = 0;
		}
		$biaya_akhir = $biaya_parkir - $diskon;

		$dataParkir = array(
			'plat' => $_POST['plat'],
			'kendaraan' => $_POST['kendaraan'],
			'masuk' => $_POST['masuk'],
			'keluar' => $_POST['keluar'],
			'durasi' => $durasi,
			'member' => $_POST['member'],
		);

		// Instruksi Kerja Nomor 12 (menyimpan ke json)
		$berkas = "data/data.json";
		$existing = [];
		if(file_exists($berkas)){
			$existing = json_decode(file_get_contents($berkas), true);
			if(!is_array($existing)) $existing = [];
		}
		// Tambahkan data baru
		$existing[] = $dataParkir;

		// Simpan kembali ke JSON
		file_put_contents($berkas, json_encode($existing, JSON_PRETTY_PRINT));



		//	Menampilkan data parkir kendaraan.
		//  KODE DI BAWAH INI TIDAK PERLU DIMODIFIKASI!!!

		echo "
		<br/>
			<div class='container d-flex justify-content-center'>
				<div class='col-lg-6'>
					<div class='row mb-2'>
						<div class='col-lg-6 font-weight-bold'>Plat Nomor Kendaraan:</div>
						<div class='col-lg-6'>" . $dataParkir['plat'] . "</div>
					</div>
					<div class='row mb-2'>
						<div class='col-lg-6 font-weight-bold'>Jenis Kendaraan:</div>
						<div class='col-lg-6'>" . $dataParkir['kendaraan'] . "</div>
					</div>
					<div class='row mb-2'>
						<div class='col-lg-6 font-weight-bold'>Durasi Parkir:</div>
						<div class='col-lg-6'>" . $dataParkir['durasi'] . " jam</div>
					</div>
					<div class='row mb-2'>
						<div class='col-lg-6 font-weight-bold'>Keanggotaan:</div>
						<div class='col-lg-6'>" . $dataParkir['member'] . "</div>
					</div>
					<div class='row mb-2'>
						<div class='col-lg-6 font-weight-bold'>Total Biaya Parkir:</div>
						<div class='col-lg-6'>Rp" . number_format($biaya_akhir, 0, '.', '.') . ",-</div>
					</div>
				</div>
			</div>
		";
	}
	?>

</body>

</html>