<?php
$conn = null;
$db_error = null;

try {
	$conn = @mysqli_connect("localhost", "root", "", "db_tugas1", 3307);
} catch (mysqli_sql_exception $e) {
	$db_error = $e->getMessage();
}

if (!$conn && $db_error === null) {
	$db_error = mysqli_connect_error();
}
?>