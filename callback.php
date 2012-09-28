<?php

$fromwho = isset($_GET['fromwho']) ? rawurldecode ($_GET['fromwho']) : 'Piotr';
$city = isset($_GET['city']) ? rawurldecode ($_GET['city']) : 'Krakow';
$film = isset($_GET['film']) ? rawurldecode($_GET['film']) : 'Rocky';

header("Content-type: text/xml");
echo '<?xml version="1.0" encoding="utf-8" ?>
<Response>
	<Say>From '.$fromwho.': I want go watch with '.$film.' at '.$city.'</Say>
</Response>';