<?php

namespace Anax\View;

?>

<!-- Load leaflet -->
<link rel="stylesheet" type="text/css" href="https://unpkg.com/leaflet@1.3.3/dist/leaflet.css">
<script src='https://unpkg.com/leaflet@1.3.3/dist/leaflet.js'></script>

<article>
    <h2>Väderprognos</h2>
    <p>
        <?= $error ?>
    </p>
    <form>
        <label for="search">Sök på t.ex. ort, ip, cordinater</label>
        <input type="text" name="search"><br>
        <label><input type="radio" name="type" value="coming" checked> Kommande väder</label><br>
        <label><input type="radio" name="type" value="past"> Föregående 30 dagar</label><br>
        <input type="submit" value="Sök">
    </form>
    <p>
    <div id="map">
    </div>
    <?php
    if (isset($res[0]["daily"])) {
        for ($i = 0; $i < count($res); $i++) {
            for ($j = 0; $j < count($res[$i]["daily"]["data"]); $j++) {
                echo $res[$i]["daily"]["data"][$j]["date"] . " - " .
                    $res[$i]["daily"]["data"][$j]["summary"] .
                    " Temp: " . $res[$i]["daily"]["data"][$j]["temperatureMin"] .
                    "&#8451 - " . $res[$i]["daily"]["data"][$j]["temperatureMax"] . "&#8451<br>";
            }
        }
    }
    ?>
    </p>
</article>

<!-- Setup leaflet map -->
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
        center: [<?= $latlon ?>],
        zoom: 12,
        layers: [humanitarian]
    });
    L.control.scale().addTo(map);
    L.control.layers(baseMaps).addTo(map);
    L.marker([<?= $latlon ?>]).addTo(map);
</script>
