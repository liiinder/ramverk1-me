<?php

namespace Anax\View;

?>
<article>
    <h2>Verifiera en IP-address.</h2>
    <form>
        <input type="text" name="ip" value="<?= $ip ?>">
        <input type="submit" value="check">
    </form>
    <p><?= ($ip != "") ? $res : "" ?></p>
</article>
