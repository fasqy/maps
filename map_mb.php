<?php
include 'function/koneksi.php';

$query = mysqli_query($conn, "SELECT * FROM TJSL_geotag");
$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Peta Lokasi - Leaflet</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body>

<h3>Peta Lokasi dari Database</h3>
<div id="map"></div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // Inisialisasi peta (titik tengah)
    var map = L.map('map').setView([-2.548926, 118.0148634], 5);

    // Tile OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Data lokasi dari PHP
    var lokasi = <?php echo json_encode($data); ?>;

    // Loop marker
    lokasi.forEach(function(item) {
        L.marker([item.geolat, item.geolng])
            .addTo(map)
            .bindPopup("<b>" + item.nama + "</b>");
    });
</script>

</body>
</html>
