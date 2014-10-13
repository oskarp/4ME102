<?php

	class Restore {

		public function __construct() {
			$source = file_get_contents('../img/restore.jpg');
			$target = "../img/mona.jpg";

			file_put_contents($target, $source);
		}
	}

	$instance = new Restore();
	header('location: http://194.47.109.245/pixlr/');

?>