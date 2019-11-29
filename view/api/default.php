<?php

namespace Anax\View;

?>
<article>
<?= $content ?>

<h2>Ipverifier API</h2>
<p>
    To use the ipverifier API you send a request to the /ipapi route with a get ?ip=x.x.x.x.
</p>
<p>
    See the following examples.
</p>
<form action="ipapi">
    <label>/ipapi?ip=8.8.8.8</label><br>
    <input type="submit" name="ip" value="8.8.8.8"><br>
    <label>/ipapi?ip=%3A%3A1</label><br>
    <input type="submit" name="ip" value="::1"><br>
    <label>/ipapi?ip=4.4.4.4</label><br>
    <input type="submit" name="ip" value="4.4.4.4"><br>
</form>

<h2>Weather API</h2>
<p>
    To use this API you send the request to /weatherapi with the following get parameters
</p>
<pre>
    ?search=[query]
    &type=past *optional* fetches the previous 30 days.
</pre>
<h5>Coming weather</h5>
<form action="weatherapi">
    <label>/weatherapi?search=8.8.8.8</label><br>
    <input type="submit" name="search" value="8.8.8.8"><br>
    <label>/weatherapi?search=göteborg</label><br>
    <input type="submit" name="search" value="göteborg"><br>
    <label>/weatherapi?search=57.708870,11.974560</label><br>
    <input type="submit" name="search" value="57.708870,11.974560"><br>
</form>
<h5>previous 30 days weather</h5>
<form action="weatherapi">
    <input type="hidden" name="type" value="past">
    <label>/weatherapi?search=8.8.8.8&type=past</label><br>
    <input type="submit" name="search" value="8.8.8.8"><br>
    <label>/weatherapi?search=göteborg&type=past</label><br>
    <input type="submit" name="search" value="göteborg"><br>
    <label>/weatherapi?search=57.708870,11.974560&type=past</label><br>
    <input type="submit" name="search" value="57.708870,11.974560"><br>
</form>
</article>
