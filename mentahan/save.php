<?php
require_once('vendor/autoload.php'); // Pastikan ini mengarah ke autoload.php dari FPDI dan FPDF
use setasign\Fpdi\Fpdi;
require('phpqrcode/qrlib.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Ambil data dari frontend, 
    $x = $data['x'];
    $y = $data['y'];
	$xText = 270.55;
	$yText = 149.43;
    $width = $data['width'];
    $height = $data['height'];
    $page = $data['page'];
    $pdfWidthFrontend = $data['pdf_width'];  // Lebar PDF di frontend (viewport)
    $pdfHeightFrontend = $data['pdf_height']; // Tinggi PDF di frontend (viewport)
	
	$textCopyRight = 'Dokumen ini ditandatangani secara elektronik menggunakan sertifikat elektronik yang diterbitkan oleh Universitas Ahmad Dahlan';

    // Path ke file PDF asli
    $pdfFile = 'web_bsi.pdf';
    $outputFile = 'output_pdf_with_qr.pdf';

    // Path untuk menyimpan QR code sementara
    $qrCodeFile = 'temp_qrcode.png';

    // Generate QR code
    QRcode::png($data['text'], $qrCodeFile, QR_ECLEVEL_L, 10);

    // Buat objek FPDI
    $pdf = new FPDI();

    // Muat file PDF asli
    $pageCount = $pdf->setSourceFile($pdfFile);

    // Iterasi seluruh halaman PDF
    for ($i = 1; $i <= $pageCount; $i++) {
        $templateId = $pdf->importPage($i);
        $size = $pdf->getTemplateSize($templateId); // Ambil ukuran asli halaman PDF

        // Tambahkan halaman baru dengan ukuran asli
        $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
		// $pdf->AddPage($size['width'] > $size['height'] ? 'L' : 'P', [$size['width'], $size['height']]);

        // Gunakan template halaman
        $pdf->useTemplate($templateId);

        // Jika halaman yang dipilih adalah halaman di mana QR code akan ditempatkan
        if ($i == $page) {
            // Hitung skala antara ukuran asli PDF dan ukuran PDF di frontend
            $scaleX = $size['width'] / $pdfWidthFrontend;
            $scaleY = $size['height'] / $pdfHeightFrontend;

            // Ubah koordinat dan ukuran QR code ke skala asli PDF
            $adjustedX = $x * $scaleX;
            // $adjustedY = ($size['height'] - ($y * $scaleY)) - ($height * $scaleY); // Koordinat Y PDF dimulai dari bawah
            $adjustedY = $y * $scaleY;
            $adjustedWidth = $width * $scaleX;
            $adjustedHeight = $height * $scaleY;

            // Tambahkan QR code di posisi yang tepat
            $pdf->Image($qrCodeFile, $adjustedX, $adjustedY, $adjustedWidth, $adjustedHeight);
			

        }
		// bagian text
		// $pdfWidthOriginal = $size['width'];
		// $pdfHeightOriginal = $size['height'];
		
		// $scaleX = $pdfWidthOriginal / $pdfWidthFrontend;
        // $scaleY = $pdfHeightOriginal / $pdfHeightFrontend;
		
		// $adjustedXText = ($pdfHeightOriginal - ($xText * $scaleX));
        // $adjustedYText = ($pdfHeightOriginal - ($yText * $scaleY)); // Pembalikan Y untuk PDF
		
		$scaleX = $size['width'] / $pdfWidthFrontend;
        $scaleY = $size['height'] / $pdfHeightFrontend;

        // Menyesuaikan koordinat berdasarkan skala
        $adjustedX = $xText * $scaleX;
        $adjustedY = $size['height'] - ($yText * $scaleY); // Pembalikan Y untuk PDF
		
		
		
		$certificate = 'sert/certificate.pem';
		$private_key = 'sert/privatekey.pem';
		$key_password = 'bsiuad';  // Password file .p12 jika ada
		
		// Opsi tanda tangan digital
		$info = array(
			'Name' => 'Universitas Ahmad Dahlan',
			'Location' => 'Bantul',
			'Reason' => 'Dokumen Informasi',
			'ContactInfo' => 'Kontak Penandatangan'
		);
	
		$pdf->SetFont('Times', '', 7);
		$pdf->SetXY($adjustedX, $adjustedY);
		$pdf->Write(0, $textCopyRight);
		
		// $pdf->setSignature(
			// $certificate,
			// $private_key,
			// $key_password,
			// '',
			// 1,  // Signature appearance (1=visible, 2=invisible)
			// $info
		// );
    }

    // Simpan PDF baru
    $pdf->Output($outputFile, 'F');

    // Hapus QR code sementara setelah digunakan
    unlink($qrCodeFile);

    // Kirimkan respon JSON
    echo json_encode(['message' => 'QR code berhasil ditambahkan.', 'file' => $outputFile]);
}
?>