<!DOCTYPE html>
<html lang="en">

<head>
    <title>Remote Filesystem Browser</title>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

<div role="banner">
<img src="header-proto.png" width="1362" height="85" alt="Header Logo">
</div>


<div role="main" class="content">

<h1>ABET Supplementary Materials</h1>

<?php
if(isset($_GET['browse']))
    {
    $dirpath=$_GET['browse'];
    }
else
    {
    $dirpath='.';
    }

if ( preg_match("/file:\//", $dirpath ) || preg_match("/^\//", $dirpath ) )
    {
    $dirpath='.';
    }

$data=scandir($dirpath);

if ( is_file("$dirpath/README.html") )
    {
    readfile("$dirpath/README.html");
    echo '<hr>';
    }

$ignore = array(
    '/^\..*$/',
    '/^_assets$/',
    '/^index.php$/',
    '/^nodisplay$/',
    '/^README.html$/',
    '/^RECYCLER$/',
    '/^System Volume Information$/'
    );

$userid = strtolower( $_SERVER['REMOTE_USER'] );
$groupsunix = `groups $userid 2>&1`;
$groupsunix = rtrim($groupsunix);
$groups = explode( ' ', $groupsunix );

$visitor = 0;
if (in_array('abetintra', $groups)) 
    {
    $visitor = 1;
    }


if ( ! $visitor )
    {
    ?>
    <p><a class="dir" href="2011">[ 2011 ]</a></p>
    <p><a class="dir" href="2017">[ 2017 ]</a></p>
    <?php
    }
?>

<p><a class="dir" href="2023">[ 2023]</a></p>

</div>
</body>
</html>
