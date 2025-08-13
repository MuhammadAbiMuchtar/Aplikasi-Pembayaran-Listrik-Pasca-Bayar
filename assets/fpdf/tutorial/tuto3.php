<?php
/*
 * Script ini membuat file PDF dengan beberapa bab (chapter) dan header/footer kustom menggunakan library FPDF.
 * Alur:
 * - Membuat class turunan dari FPDF dengan fungsi Header, Footer, ChapterTitle, ChapterBody, PrintChapter
 * - Header: menampilkan judul bab
 * - Footer: menampilkan nomor halaman
 * - ChapterTitle: menampilkan judul bab
 * - ChapterBody: menampilkan isi bab dari file teks
 * - PrintChapter: menggabungkan judul dan isi bab dalam satu halaman
 * - Membuat PDF dengan dua bab dari file teks
 */
require('../fpdf.php');

// Class PDF mewarisi FPDF dan menambahkan berbagai fungsi untuk chapter dan tampilan
class PDF extends FPDF
{
    // Fungsi untuk menampilkan header di setiap halaman PDF
    function Header()
    {
        // Menampilkan judul bab di bagian atas halaman
        global $title;

        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Calculate width of title and position
        $w = $this->GetStringWidth($title)+6;
        $this->SetX((210-$w)/2);
        // Colors of frame, background and text
        $this->SetDrawColor(0,80,180);
        $this->SetFillColor(230,230,0);
        $this->SetTextColor(220,50,50);
        // Thickness of frame (1 mm)
        $this->SetLineWidth(1);
        // Title
        $this->Cell($w,9,$title,1,1,'C',true);
        // Line break
        $this->Ln(10);
    }

    // Fungsi untuk menampilkan footer di setiap halaman PDF
    function Footer()
    {
        // Menampilkan nomor halaman di bagian bawah
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Text color in gray
        $this->SetTextColor(128);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
    }

    // Fungsi untuk menampilkan judul bab
    function ChapterTitle($num, $label)
    {
        // ... existing code ...
        // Arial 12
        $this->SetFont('Arial','',12);
        // Background color
        $this->SetFillColor(200,220,255);
        // Title
        $this->Cell(0,6,"Chapter $num : $label",0,1,'L',true);
        // Line break
        $this->Ln(4);
    }

    // Fungsi untuk menampilkan isi bab dari file teks
    function ChapterBody($file)
    {
        // Read text file
        $txt = file_get_contents($file);
        // Times 12
        $this->SetFont('Times','',12);
        // Output justified text
        $this->MultiCell(0,5,$txt);
        // Line break
        $this->Ln();
        // Mention in italics
        $this->SetFont('','I');
        $this->Cell(0,5,'(end of excerpt)');
    }

    // Fungsi untuk mencetak satu bab lengkap (judul + isi)
    function PrintChapter($num, $title, $file)
    {
        // ... existing code ...
        $this->AddPage();
        $this->ChapterTitle($num,$title);
        $this->ChapterBody($file);
    }
}

// Membuat objek PDF, mengatur judul dan penulis, serta mencetak dua bab dari file teks
// Output PDF ke browser
$pdf = new PDF();
$title = '20000 Leagues Under the Seas';
$pdf->SetTitle($title);
$pdf->SetAuthor('Jules Verne');
$pdf->PrintChapter(1,'A RUNAWAY REEF','20k_c1.txt');
$pdf->PrintChapter(2,'THE PROS AND CONS','20k_c2.txt');
$pdf->Output();
?>
