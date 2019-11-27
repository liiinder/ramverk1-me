<?php

namespace Anax\View;

?>
<!-- Load leaflet -->
<link rel="stylesheet" type="text/css" href="https://unpkg.com/leaflet@1.3.3/dist/leaflet.css">
<script src='https://unpkg.com/leaflet@1.3.3/dist/leaflet.js'></script>

<article>
    <h2>Väderprognos</h2>
    <form>
        <label for="position">Sök ort</label>
        <input type="text" name="position"><br>
        <label><input type="radio" name="weather" value="future"> Kommande väder</label><br>
        <label><input type="radio" name="weather" value="past"> Föregående 30 dagar</label><br>
        <input type="submit" value="Sök">
    </form>
    <div id="map">
    </div>
</article>
<?php
    // Adding a default location set to Gothenburg
    $lat = $lat ?? "57.708870";
    $lon = $lon ?? "11.974560";
?>

<script>
    // Three different Layers.
    var standard = L.tileLayer(
        "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
        {
            id: 'MapID',
            attribution:
                `&copy; <a href="https://www.openstreetmap.org/copyright">
                OpenStreetMap</a> contributors.`
        }
    );
    var humanitarian = L.tileLayer(
        "http://b.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png",
        {
            id: 'MapID',
            attribution:
                `&copy; Tile style by 
                <a href="https://www.hotosm.org/">Humanitarian OpenStreetMap Team</a> hosted by
                <a href="https://www.openstreetmap.fr/">OpenStreetMap France</a>.`
        }
    );
    var bwMapnik = L.tileLayer(
        "https://tiles.wmflabs.org/bw-mapnik/{z}/{x}/{y}.png",
        {
            id: 'MapID',
            attribution:
                `&copy; Tile style found at
                <a href="https://wiki.openstreetmap.org/wiki/Tiles">
                OSM tiles wiki</a>, called OSM B&W mapnik.`
        }
    );
    // Into a overlay group
    var baseMaps = {
        "b&w Mapnik": bwMapnik,
        "Standard": standard,
        "Humanitärt": humanitarian,
    };
    map = L.map('map', {
        center: [<?= $lat ?>, <?= $lon ?>],
        zoom: 12,
        layers: [humanitarian]
    });
    L.control.scale().addTo(map);
    L.control.layers(baseMaps).addTo(map);
</script>
