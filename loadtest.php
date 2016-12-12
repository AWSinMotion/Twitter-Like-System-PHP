<?php
function fibonacci($n) {
	if ($n == 0 || $n == 1) {
		return $n;
	}
	return fibonacci($n-2) + fibonacci($n-1);
}
$fib37 = fibonacci(37);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Loadtest</title>
		<meta http-equiv="refresh" content="0">
	</head>
	<body>
	<?php
	echo $fib37;
	?>
	</body>
</html>