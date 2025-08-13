<?php
/*
 * Script ini memproses tambah, edit, dan hapus data pelanggan PLN.
 * Alur:
 * - Memastikan koneksi database aktif
 * - Jika tambah: validasi email/username unik, insert data pelanggan
 * - Jika update: update data pelanggan berdasarkan id
 * - Jika hapus: menghapus data pelanggan berdasarkan id
 * - Redirect ke halaman pelanggan setelah aksi
 */
include '../config/koneksi.php';

// Tambah
if (isset($_POST['tambah'])) {
  $id = $_POST['id_pelanggan'];
  $nama = $_POST['nama'];
  $alamat = $_POST['alamat'];
  $daya = $_POST['daya'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $tanggal_registrasi = $_POST['tanggal_registrasi'];
  
  // Validasi email/username unik
  $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM admin WHERE email='$email' OR username='$id'"));
  if ($cek > 0) {
    // Redirect kembali dengan pesan error
    header("Location: ../pages/tambah_pelanggan.php?error=Email%20atau%20Username%20sudah%20terdaftar");
    exit;
  }
  // Insert ke tabel pelanggan saja
  mysqli_query($koneksi, "INSERT INTO pelanggan (id_pelanggan, nama, password, email, alamat, daya, tanggal_registrasi) VALUES('$id','$nama','$password','$email','$alamat','$daya','$tanggal_registrasi')");
  header("Location: ../pages/pelanggan.php");
  exit;
}

// Update
if (isset($_POST['update'])) {
  $old = $_POST['old_id'];
  $id = $_POST['id_pelanggan'];
  $nama = $_POST['nama'];
  $alamat = $_POST['alamat'];
  $daya = $_POST['daya'];
  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';
  $tanggal_registrasi = isset($_POST['tanggal_registrasi']) ? $_POST['tanggal_registrasi'] : '';
  $set = "id_pelanggan='$id', nama='$nama', alamat='$alamat', daya='$daya'";
  if ($email !== '') $set .= ", email='$email'";
  if ($password !== '') $set .= ", password='$password'";
  if ($tanggal_registrasi !== '') $set .= ", tanggal_registrasi='$tanggal_registrasi'";
  mysqli_query($koneksi, "UPDATE pelanggan SET $set WHERE id_pelanggan='$old'");
  header("Location: ../pages/pelanggan.php");
}

// Hapus
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  mysqli_query($koneksi, "DELETE FROM pelanggan WHERE id_pelanggan='$id'");
  header("Location: ../pages/pelanggan.php");
}
?> 