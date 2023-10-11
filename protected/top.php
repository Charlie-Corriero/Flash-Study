<?php 
define ('PHP_SELF', htmlspecialchars($_SERVER['PHP_SELF']));
define ('PATH_PARTS', pathinfo(PHP_SELF));
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="utf-8">
    <title>Flash Study - CS148 Final Website</title>
    <meta name="author" content="Alex Schaefer, Charlie Corriero, Hannah Hagab">
    <meta name="description" content="CS148 Final Website">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="../css/custom.css?version=<?php print time(); ?>">
    <link rel="stylesheet" type="text/css" media="(max-width: 800px)" href="../css/custom-tablet.css?version=<?php print time(); ?>">
    <link rel="stylesheet" type="text/css" media="(max-width: 600px)" href="../css/custom-phone.css?version=<?php print time(); ?>">
</head>

<?php
print '<body class ="' . PATH_PARTS['filename'] . '">';
print PHP_EOL;
include 'connect-DB.php';
print PHP_EOL;
include 'header.php';
print PHP_EOL;
include 'nav.php';
print PHP_EOL;
?>
