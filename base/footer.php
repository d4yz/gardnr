<?php
	##Security Check## - Check to see if file is open without include
	if(preg_match('/footer/',$_SERVER['PHP_SELF'])){
	header('Location:index.php');}
?>

	<script src="./js/jquery-2.2.0.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
</body>
</html>