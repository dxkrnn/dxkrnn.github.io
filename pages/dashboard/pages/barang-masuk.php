<?php

include '../../../config.php';

error_reporting(0);

session_start();

//Menambah Barang Masuk
if(isset($_POST['tambah_barang_masuk'])) {

    $id_barangnya = $_POST['pilihan_barang'];
    $pengirim = $_POST['pengirim'];
    $jumlah = $_POST['jumlah'];

    //Ambil nama_barang
    $cek_nama_barang = mysqli_query($conn, "SELECT * FROM persediaan WHERE id_barang='$id_barangnya'");
    $ambil_nama_barang = mysqli_fetch_array($cek_nama_barang);
    $nama_barangnya = $ambil_nama_barang['nama_barang'];

    //Ambil stock_barang
    $cek_stock_barang = mysqli_query($conn, "SELECT * FROM persediaan WHERE id_barang='$id_barangnya'");
    $ambil_stock_barang = mysqli_fetch_array($cek_stock_barang);
    $stock_barangnya = $ambil_stock_barang['stock_barang'];
    $tambah_stock = $stock_barangnya + $jumlah;

    //Menambahkan ke tabel barang_masuk
    $addtotable = mysqli_query($conn, "INSERT INTO barang_masuk (id_barang, nama_barang, pengirim, jumlah) VALUES ('$id_barangnya', '$nama_barangnya', '$pengirim', '$jumlah')");
    $update_stock = mysqli_query($conn, "UPDATE persediaan SET stock_barang='$tambah_stock' WHERE id_barang='$id_barangnya'");

    if($addtotable && $update_stock) {
        echo "<script>alert('Yeay, Tambah Barang Masuk berhasil!')</script>";
        // header('location:persediaan.php');
        $nama_barangnya = "";
        $pengirim = "";
        $jumlah = "";			
    } else {
        echo "<script>alert('Yahh :( Tambah Barang Masuk gagal!')</script>";
        // header('location:persediaan.php');
    }

    
}

//Update Barang Masuk
if(isset($_POST['update_barang_masuk'])) {
	$id_barang = $_POST['id_barang'];
	$nama_barang = $_POST['nama_barang'];
	$pengirim = $_POST['pengirim'];
	$jumlah = $_POST['jumlah'];
	$id_masuk = $_POST['id_masuk'];

	//Ambil data dari persediaan
	$ambil_data_persediaan = mysqli_query($conn, "SELECT * FROM persediaan WHERE id_barang='$id_barang'");
	$stocknya = mysqli_fetch_array($ambil_data_persediaan);
	$stock_barangnya = $stocknya['stock_barang'];

	//Ambil data dari barang_masuk
	$ambil_data_barang_masuk = mysqli_query($conn, "SELECT * FROM barang_masuk WHERE id_barang='$id_barang'");
	$jumlah_barang_masuk = mysqli_fetch_array($ambil_data_barang_masuk);
	$jumlah_barangnya_masuk = $jumlah_barang_masuk['jumlah'];

	$stock_sekarang = $stock_barangnya - $jumlah_barangnya_masuk + $jumlah;
	
	if($stock_sekarang >= 0) {
		$update_barang_masuk = mysqli_query($conn, "UPDATE barang_masuk SET pengirim='$pengirim', jumlah='$jumlah' WHERE id_masuk='$id_masuk'");
		$update_stock = mysqli_query($conn, "UPDATE persediaan SET stock_barang='$stock_sekarang' WHERE id_barang='$id_barang'");
		if($update_barang_masuk && $update_stock) {
			echo "<script>alert('Yeay, Edit Barang Masuk berhasil!')</script>";
		} else {
			echo "<script>alert('Yahh :( Edit Barang Masuk gagal!')</script>";
		}
	}
}

//Hapus barang masuk
if(isset($_POST['hapus_barang_masuk'])) {
	$id_masuk = $_POST['id_masuk'];
	$id_barang = $_POST['id_barang'];

	//Ambil data dari persediaan
	$ambil_data_persediaan = mysqli_query($conn, "SELECT * FROM persediaan WHERE id_barang='$id_barang'");
	$stocknya = mysqli_fetch_array($ambil_data_persediaan);
	$stock_barangnya = $stocknya['stock_barang'];

	//Ambil data dari barang_masuk
	$ambil_data_barang_masuk = mysqli_query($conn, "SELECT * FROM barang_masuk WHERE id_barang='$id_barang'");
	$jumlah_barang_masuk = mysqli_fetch_array($ambil_data_barang_masuk);
	$jumlah_barangnya_masuk = $jumlah_barang_masuk['jumlah'];

	$stock_sekarang = $stock_barangnya - $jumlah_barangnya_masuk;
	
	if($stock_sekarang >= 0) {
		$hapus_barang_masuk = mysqli_query($conn, "DELETE FROM barang_masuk WHERE id_masuk='$id_masuk'");
		$update_stock = mysqli_query($conn, "UPDATE persediaan SET stock_barang='$stock_sekarang' WHERE id_barang='$id_barang'");
		
		if($hapus_barang_masuk && $update_stock) {
			echo "<script>alert('Yeay, Hapus Barang Masuk berhasil!')</script>";
		} else {
			echo "<script>alert('Yahh :( Hapus Barang Masuk gagal!')</script>";
		}

	}
}

?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		<title>Barang Masuk - Nio Furniture</title>
		<link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png">
		<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
		<link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="../assets/css/feathericon.min.css">
		<link rel="stylesheet" href="../assets/plugins/datatables/datatables.min.css">
		<link rel="stylesheet" href="../assets/css/style.css">
	</head>

	<body>
		<div class="main-wrapper">
			<div class="header">
				<div class="header-left">
					<a href="../index.html" class="logo"> <img src="../assets/img/logo.png" width="50" height="70" alt="logo"> <span class="logoclass"></span> </a>
					<a href="../index.html" class="logo logo-small"> <img src="../assets/img/logo.png" alt="Logo" width="30" height="30"> </a>
				</div>
				<a href="javascript:void(0);" id="toggle_btn"> <i class="fe fe-text-align-left"></i> </a>
				<a class="mobile_btn" id="mobile_btn"> <i class="fas fa-bars"></i> </a>
				<ul class="nav user-menu">
					<li class="nav-item dropdown noti-dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"> <i class="fe fe-bell"></i> <span class="badge badge-pill">3</span> </a>
						<div class="dropdown-menu notifications">
							<div class="topnav-dropdown-header"> <span class="notification-title">Notifications</span> <a href="javascript:void(0)" class="clear-noti"> Clear All </a> </div>
							<div class="noti-content">
								<ul class="notification-list">
									<li class="notification-message">
										<a href="#">
											<div class="media"> <span class="avatar avatar-sm">
												<img class="avatar-img rounded-circle" alt="User Image" src="../assets/img/profiles/avatar.png">
												</span>
												<div class="media-body">
													<p class="noti-details"><span class="noti-title">Carlson Tech</span> has approved <span class="noti-title">your estimate</span></p>
													<p class="noti-time"><span class="notification-time">4 mins ago</span> </p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="#">
											<div class="media"> <span class="avatar avatar-sm">
												<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/profiles/avatar-11.jpg">
												</span>
												<div class="media-body">
													<p class="noti-details"><span class="noti-title">International Software
														Inc</span> has sent you a invoice in the amount of <span class="noti-title">$218</span></p>
													<p class="noti-time"><span class="notification-time">6 mins ago</span> </p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="#">
											<div class="media"> <span class="avatar avatar-sm">
												<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/profiles/avatar-17.jpg">
												</span>
												<div class="media-body">
													<p class="noti-details"><span class="noti-title">John Hendry</span> sent a cancellation request <span class="noti-title">Apple iPhone
														XR</span></p>
													<p class="noti-time"><span class="notification-time">8 mins ago</span> </p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="#">
											<div class="media"> <span class="avatar avatar-sm">
												<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/profiles/avatar-13.jpg">
												</span>
												<div class="media-body">
													<p class="noti-details"><span class="noti-title">Mercury Software
														Inc</span> added a new product <span class="noti-title">Apple
														MacBook Pro</span></p>
													<p class="noti-time"><span class="notification-time">12 mins ago</span> </p>
												</div>
											</div>
										</a>
									</li>
								</ul>
							</div>
							<div class="topnav-dropdown-footer"> <a href="#">View all Notifications</a> </div>
						</div>
					</li>
					<li class="nav-item dropdown has-arrow">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"> <span class="user-img"><img class="rounded-circle" src="../assets/img/profiles/avatar.png" width="31" alt="Soeng Souy"></span> </a>
						<div class="dropdown-menu">
							<div class="user-header">
								<div class="avatar avatar-sm"> <img src="../assets/img/profiles/avatar.png" alt="User Image" class="avatar-img rounded-circle"> </div>
								<div class="user-text">
									<h6>Admin</h6>
									<p class="text-muted mb-0">Administrator</p>
								</div>
							</div> <a class="dropdown-item" href="profile.html">My Profile</a> <a class="dropdown-item" href="settings.html">Account Settings</a> <a class="dropdown-item" href="../../../signin-signup/logout.php">Logout</a> </div>
					</li>
				</ul>
			</div>

			<!-- Side Bar -->
			<div class="sidebar" id="sidebar">
				<div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul>
							<li class="active"> <a href="../index.html"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a> </li>
							<li class="list-divider"></li>
							<li class="submenu"> <a href="#"><i class="fas fa-cube"></i> <span> Persediaan </span> <span class="menu-arrow"></span></a>
								<ul class="submenu_class" style="display: none;">
									<li><a href="persediaan.php"> Persediaan </a></li>
									<li class="aktif"><a href="barang-masuk.php"> Barang Masuk </a></li>
									<li><a href="barang-keluar.php"> Barang Keluar </a></li>
									<li><a href="barang-keluar-offline.php"> Barang Keluar [offline] </a></li>
								</ul>
							</li>
							<li class="submenu"> <a href="#"><i class="fas fa-suitcase"></i> <span> Pesanan </span> <span class="menu-arrow"></span></a>
								<ul class="submenu_class" style="display: none;">
									<li><a href="pesanan-aktif.php"> Pesanan Aktif </a></li>
									<li><a href="riwayat-pesanan.php"> Riwayat Pesanan</a></li>
								</ul>
							</li>
							<li class="submenu"> <a href="#"><i class="fas fa-user"></i> <span> Pelanggan </span> <span class="menu-arrow"></span></a>
								<ul class="submenu_class" style="display: none;">
									<li><a href="daftar-pelanggan.php"> Daftar Pelanggan </a></li>
									<li><a href="edit-pelanggan.php"> Edit Pelanggan </a></li>
								</ul>
							</li>
							<li> <a href="aktivitas.php"><i class="far fa-bell"></i> <span>Aktivitas</span></a> </li>
							<li> <a href="pengaturan.php"><i class="fas fa-cog"></i> <span>Pengaturan</span></a> </li>
							<li class="list-divider"></li>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="page-wrapper">
				<div class="content container-fluid">
					<div class="page-header mt-5 m-r-10">
						<div class="row">
							<div class="col">
								<h3 class="page-title">Barang Masuk</h3>
							</div>
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah</button>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="table-responsive">
										<table class="datatable table table-stripped">
											<thead>
												<tr>
													<th>ID Masuk</th>
													<th>Tanggal</th>
													<th>Nama Barang</th>
													<th>Pengirim</th>
													<th>Jumlah</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<!-- Looping untuk menampilkan data dari DB ke tabel -->
												<?php
													$ambil_data_barang_masuk = mysqli_query($conn, "SELECT * FROM barang_masuk");
													while($data = mysqli_fetch_array($ambil_data_barang_masuk)) {
														$id_masuk = $data['id_masuk'];
														$tanggal = $data['tanggal'];
														$nama_barang = $data['nama_barang'];
														$pengirim = $data['pengirim'];
														$jumlah = $data['jumlah'];
														$id_barang = $data['id_barang'];
												?>
												
												<tr>
													<td><?=$id_masuk;?></td>
													<td><?=$tanggal;?></td>
													<td><?=$nama_barang;?></td>
													<td><?=$pengirim;?></td>
													<td><?=$jumlah;?></td>
													<td class="text-right">
														<div class="dropdown dropdown-action"> <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v ellipse_color"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a class="dropdown-item" href="#editModal<?=$id_masuk;?>" data-toggle="modal" data-target="#editModal<?=$id_masuk;?>"><i class="fas fa-pencil-alt m-r-5"></i> Edit</a>
																<input type="hidden" name="id_barang_to_hapus" value="<?=$id_barang;?>">
																<a class="dropdown-item" href="#hapusModal<?=$id_masuk;?>" data-toggle="modal" data-target="#hapusModal<?=$id_masuk;?>"><i class="fas fa-trash-alt m-r-5"></i> Hapus</a>
															</div>
														</div>
													</td>
												</tr>

												<!-- Modal Edit -->
												<div class="modal fade editModal" tabindex="-1" role="dialog" aria-labelledby="bannerformmodal" aria-hidden="true" id="editModal<?=$id_masuk;?>">
														<div class="modal-dialog">
															<div class="modal-content">
															
																	<!-- Modal Header -->
																	<div class="modal-header">
																		<h4 class="modal-title">Edit Barang Masuk</h4>
																		<button type="button" class="close" data-dismiss="modal">&times;</button>
																	</div>
																	
																	<!-- Modal body -->
																	<form method="POST">
																		<div class="modal-body">
																			<input type="text" name="pengirim" value="<?=$pengirim;?>" class="form-control" required>
																			<br>
																			<input type="number" name="jumlah" value="<?=$jumlah;?>" class="form-control" required>
																			<input type="hidden" name="id_barang" value="<?=$id_barang;?>">
																			<input type="hidden" name="id_masuk" value="<?=$id_masuk;?>">
																		</div>
																					
																		<!-- Modal footer -->
																		<div class="modal-footer">
																			<button type="submit" class="btn btn-primary" name="update_barang_masuk">Simpan</button>
																		</div>
																	</form>
																</div>
															</div>
														</div>
													
													</div>


													<!-- Modal Hapus -->
													<div class="modal fade hapusModal" tabindex="-1" role="dialog" aria-labelledby="bannerformmodal" aria-hidden="true" id="hapusModal<?=$id_masuk;?>">
														<div class="modal-dialog">
															<div class="modal-content">
															
																	<!-- Modal Header -->
																	<div class="modal-header">
																		<h4 class="modal-title">Hapus Persediaan</h4>
																		<button type="button" class="close" data-dismiss="modal">&times;</button>
																	</div>
																	
																	<!-- Modal body -->
																	<form method="POST">
																		<div class="modal-body">
																			<p>Apakah Anda yakin akan menghapus barang masuk dengan ID <b><?=$id_masuk?></b> dari <b><?=$pengirim?></b> ?</p>
																			<input type="hidden" name="id_barang" value="<?=$id_barang;?>">
																			<input type="hidden" name="id_masuk" value="<?=$id_masuk;?>">
																		</div>
																					
																		<!-- Modal footer -->
																		<div class="modal-footer">
																			<button type="submit" class="btn btn-primary" name="hapus_barang_masuk">Hapus</button>
																		</div>
																	</form>
																</div>
															</div>
														</div>
													
													</div>

												<?php
													};
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="../assets/js/jquery-3.5.1.min.js"></script>
		<script src="../assets/js/popper.min.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
		<script src="../assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="../assets/plugins/datatables/datatables.min.js"></script>
		<script src="../assets/js/script.js"></script>
	</body>

	<!-- The Modal -->
	<div class="modal fade" id="myModal">
		<div class="modal-dialog">
			<div class="modal-content">
			
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Tambah Barang Masuk</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<!-- Modal body -->
				<form method="POST">
					<div class="modal-body">

                        <select name="pilihan_barang" class="form-control">
                            <?php
                                $ambil_data = mysqli_query($conn, "SELECT * FROM persediaan");
                                while($fetch_array = mysqli_fetch_array($ambil_data)) {
                                    $nama_barangnya = $fetch_array['nama_barang'];
                                    $id_barangnya = $fetch_array['id_barang'];
                            ?>

                            <option value="<?=$id_barangnya;?>"><?=$nama_barangnya;?></option>

                            <?php        
                                }
                            ?>

                        </select>
                        <br>
						<input type="text" name="pengirim" placeholder="Pengirim" class="form-control" required>
						<br>
                        <input type="number" name="jumlah" placeholder="Jumlah" class="form-control" required>
						<br>
						<!-- <input type="file" name="gambar_barang" placeholder="Gambar Barang" class="form-control"> -->
					</div>
								
					<!-- Modal footer -->
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" name="tambah_barang_masuk">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	</div>

</html>