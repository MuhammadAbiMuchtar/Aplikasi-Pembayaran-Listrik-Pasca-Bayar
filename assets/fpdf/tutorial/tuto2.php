<?php
/*
 * Script ini membuat file PDF dengan header dan footer kustom menggunakan library FPDF.
 * Alur:
 * - Membuat class turunan dari FPDF dengan fungsi Header dan Footer
 * - Header: menampilkan logo dan judul
 * - Footer: menampilkan nomor halaman
 * - Membuat PDF dengan 40 baris teks
 */
require('../fpdf.php');

// Class PDF mewarisi FPDF dan menambahkan header & footer kustom
class PDF extends FPDF
{
    // Fungsi untuk menampilkan header di setiap halaman PDF
    function Header()
    {
        // Logo di kiri atas
        // Judul di tengah
        // Garis bawah header
        $this->Image('logo.png',10,6,30);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,10,'Title',1,0,'C');
        // Line break
        $this->Ln(20);
    }

    // Fungsi untuk menampilkan footer di setiap halaman PDF
    function Footer()
    {
        // Posisi 1.5 cm dari bawah
        // Nomor halaman di tengah bawah
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Membuat objek PDF dari class turunan
// Menambah halaman, mengatur font, dan menulis 40 baris teks
// Output PDF ke browser
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
for($i=1;$i<=40;$i++)
	$pdf->Cell(0,10,'Printing line number '.$i,0,1);
$pdf->Output();
?>
