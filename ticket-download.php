<?php
require('config.php');
require_once('admin/fpdf/fpdf.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$booking_id = intval($_GET['id'] ?? 0);

$query = "
  SELECT b.*, s.show_date, s.show_time, m.title
  FROM bookings b
  JOIN showtimes s ON b.showtime_id = s.id
  JOIN movies m ON s.movie_id = m.id
  WHERE b.id='$booking_id' AND b.user_id='$user_id' AND LOWER(b.payment_status)='success'
";
$result = mysqli_query($conn, $query);
$booking = mysqli_fetch_assoc($result);

if (!$booking) {
  die("Invalid or unconfirmed ticket.");
}

// === PDF Creation ===
$pdf = new FPDF();
$pdf->AddPage();

// --- HEADER ---
$pdf->SetFillColor(11,99,255); // brand blue
$pdf->Rect(0,0,210,30,'F');
$pdf->SetFont('Arial','B',20);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(0,15,'TRX CINEMA TICKET',0,1,'C');
$pdf->Ln(10);

// --- BODY ---
$pdf->SetTextColor(33,37,41);
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Booking Details',0,1,'C');
$pdf->Ln(6);

$pdf->SetFont('Arial','',13);

// use rounded box style
$pdf->SetFillColor(248,249,255);
$pdf->Rect(10,50,190,80,'F');

$pdf->SetXY(20,60);
$pdf->Cell(50,10,'Movie:',0,0);
$pdf->SetFont('Arial','B',13);
$pdf->Cell(0,10,utf8_decode($booking['title']),0,1);

$pdf->SetFont('Arial','',13);
$pdf->SetX(20);
$pdf->Cell(50,10,'Show Date:',0,0);
$pdf->SetFont('Arial','B',13);
$pdf->Cell(0,10,$booking['show_date'],0,1);

$pdf->SetFont('Arial','',13);
$pdf->SetX(20);
$pdf->Cell(50,10,'Show Time:',0,0);
$pdf->SetFont('Arial','B',13);
$pdf->Cell(0,10,$booking['show_time'],0,1);

$pdf->SetFont('Arial','',13);
$pdf->SetX(20);
$pdf->Cell(50,10,'Seat:',0,0);
$pdf->SetFont('Arial','B',13);
$pdf->Cell(0,10,$booking['seat_number'],0,1);

$pdf->SetFont('Arial','',13);
$pdf->SetX(20);
$pdf->Cell(50,10,'Amount:',0,0);
$pdf->SetFont('Arial','B',13);
$pdf->Cell(0,10,''.$booking['total_price'],0,1);

$pdf->Ln(12);

// --- FOOTER ---
$pdf->SetFont('Arial','I',11);
$pdf->SetTextColor(100,100,100);
$pdf->MultiCell(0,8,"Please present this ticket at the TRX Cinema gate.\nEnjoy your movie experience!",0,'C');

$pdf->Ln(5);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(150,150,150);
$pdf->Cell(0,10,'Generated on '.date("d M Y, h:i A"),0,1,'C');

// --- OUTPUT ---
$pdf->Output('D','TRX_Ticket_'.$booking['id'].'.pdf');
exit;
?>
