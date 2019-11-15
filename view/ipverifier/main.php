<?php

namespace Anax\View;

?>
<article>
    <h2>Verifiera en IP-address.</h2>
    <h4>Denna returnerar en sträng.</h4>
    <form>
        <input type="text" name="ip" value="<?= $ip ?>">
        <input type="submit" value="check">
    </form>
    <p><?= ($ip != "") ? $res : "" ?></p>
    <h4>Denna returnerar Json</h4>
    <form action="iptojson">
        <input type="text" name="ip" value="<?= $ip ?>">
        <input type="submit" value="check">
    </form>
    <p>
        Eller använd routen baseurl/htdocs/iptojson?ip= , istället för ipverifier
    </p>
</article>
