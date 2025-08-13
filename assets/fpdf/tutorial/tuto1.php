<?php
/*
 * Script ini membuat file PDF sederhana dengan tulisan "Hello World!" menggunakan library FPDF.
 * Alur:
 * - Inisialisasi objek FPDF
 * - Menambah halaman baru
 * - Mengatur font menjadi Arial Bold ukuran 16
 * - Menulis teks "Hello World!" ke dalam PDF
 * - Menampilkan hasil PDF ke browser
 */
require('../fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World!');
$pdf->Output();
?>
