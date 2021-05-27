<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Paytm</title>
</head>
<body>
     <form method='post' action='<?php echo $transactionURL; ?>' name='f1'>
            <?php
foreach ($paramList as $name => $value) {
	echo '<input type="hidden" name="' . $name . '" value="' . $value . '">';
}
?>
            <!-- <input type="text" name="CHECKSUMHASH" value="<?php echo $paytmChecksum ?>"> -->
            <input type="hidden" name="CHECKSUMHASH" value="<?php echo $paytmChecksum ?>">
            <!-- <input type="submit" value="Submit"> -->
        </form>
        <h2 style="text-align: center;">Please wait.....</h2>
        <script type="text/javascript">
             document.f1.submit();
        </script>
</body>
</html>