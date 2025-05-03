<?php
// Veritabanı bağlantısı
$baglanti = new mysqli("localhost", "kullanici_adi", "sifre", "veritabani_adi");

// Hataları kontrol et
if ($baglanti->connect_error) {
    die("Bağlantı hatası: " . $baglanti->connect_error);
}

// URL'den hasta_id al
$hastaId = $_GET['hasta_id'] ?? '';

// Güvenlik kontrolü
if (!$hastaId) {
    echo json_encode(["hata" => "Hasta ID girilmedi."]);
    exit;
}

// SQL sorgusu
$sql = "SELECT kategori, test_adi, sonuc, tarih FROM biyokimya_testleri WHERE hasta_id = ?";
$stmt = $baglanti->prepare($sql);
$stmt->bind_param("s", $hastaId);
$stmt->execute();

// Sonuçları işle
$sonuc = $stmt->get_result();
$veriler = [];

while ($satir = $sonuc->fetch_assoc()) {
    $veriler[] = $satir;
}

// JSON olarak çıktı ver
header('Content-Type: application/json');
echo json_encode($veriler);
?>
