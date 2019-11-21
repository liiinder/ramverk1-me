<?php

namespace Anax\View;

?>
<article>
    <h2>Verifiera en IP-address.</h2>
    <form>
        <input type="text" name="ip" value="<?= $ip ?>">
        <input type="submit" value="check">
    </form>
    <p>
        Protocol: <?= $protocol ?><br>
        Domain: <?= $domain ?><br>
        Latitude: <?= $lat ?><br>
        Longitude: <?= $lon ?><br>
        Country: <?= $country ?><br>
        City: <?= $city ?>
    </p>
    <h2>Json API</h2>
    <p>
        To use the API you send a request to the iptojson route with a get ?ip=x.x.x.x.<br>
        See the following examples.
    </p>
    <form action="iptojson">
        <input type="checkbox" name="test" id="test">
        <label for="test">Use the Mock server?</label>
        <br>
        <input type="submit" name="ip" value="8.8.8.8">
        <input type="submit" name="ip" value="::1">
        <input type="submit" name="ip" value="4.4.4.4">
    </form>
</article>
