<?php
/*
 * Script ini membuat file PDF dengan font custom (CevicheOne) menggunakan FPDF.
 * Alur:
 * - Menentukan path font FPDF
 * - Menambah font custom ke FPDF
 * - Membuat halaman baru
 * - Mengatur font custom dan menulis teks ke PDF
 * - Menampilkan hasil PDF ke browser
 */
define('FPDF_FONTPATH','.');
require('../fpdf.php');

$pdf = new FPDF();
$pdf->AddFont('CevicheOne','','CevicheOne-Regular.php');
$pdf->AddPage();
$pdf->SetFont('CevicheOne','',45);
$pdf->Cell(0,10,'Enjoy new fonts with FPDF!');
$pdf->Output();
?>
