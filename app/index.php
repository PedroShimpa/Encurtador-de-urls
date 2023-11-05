<?php

require_once 'controller.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	(new Controller)->insertUrl();
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
	(new Controller)->getUrl();
} else {
	(new Controller)->invalidMethods();
}

