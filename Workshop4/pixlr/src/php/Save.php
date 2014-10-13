<?php
	
class Save {

	public function __construct() {
		$source = @file_get_contents($_GET['image']);
		$target = "../img/mona.jpg";

		if (isset($_GET['image'])) {
			file_put_contents($target, $source);
		}
	}
}

$instance = new Save();

?>
<html>
	
	<head>
		
		<script>

			window.parent.location.reload();

		</script>

	</head>

</html>