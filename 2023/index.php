<?php
require_once('../funcs.inc');

$userid = strtolower( $_SERVER['REMOTE_USER'] );
$groupsunix = `groups $userid 2>&1`;
$groupsunix = rtrim($groupsunix);
$groups = explode( ' ', $groupsunix );

$visitor = 0;
if (in_array('abetintra', $groups))
    {   
    $visitor = 1;
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Remote Filesystem Browser</title>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body>

<div role="banner">
    <img src="_assets/header-proto.png" width="1362" height="85" 
	alt="header logo">
</div>

<div role="navigation">

<div class="menu">

<span>
    <a href="./">Home</a>
</span>

<?php

if ( ! $visitor )
    {
    ?>
    <span>
	<a href="../">Top</a>
    </span>
    <?php
    }
?>

<span>
    <a href="./?browse=./CEE">CEE</a>
</span>

<span>
    <a href="./?browse=./CS">CS</a>
</span>

<span>
    <a href="./?browse=./ECE">ECE</a>
</span>

<?php
if ( ! $visitor )
    {
    ?>
    <span>
	<a href="./?browse=./MCECS">MCECS</a>
    </span>
    <?php
    }
?>

<span>
    <a href="./?browse=./MME">MME</a>
</span>

<span class="last">
    &nbsp;
</span>

</div>

</div>

<div role="main" class="content">

<h1>2023 ABET Supplementary Materials</h1>

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

if ( is_file("$dirpath/README.txt") )
    {
    $contents = file_get_contents("$dirpath/README.txt");

    $contents = make_clickable(nl2br($contents));

    echo $contents;

    echo '<hr>';
    }

$ignore = array(
    '/^\..*$/',
    '/^_assets$/',
    '/^index.php$/',
    '/^nodisplay$/',
    '/^MCECS$/',
    '/^README.html$/',
    '/^README.txt$/',
    '/^RECYCLER$/',
    '/^System Volume Information$/'
    );

for($i=0; $i<count($data); ++$i)
    {
    // just copy the data item to another variable for
    // easy manipulation in the loop
    $value=$data[$i];

    foreach($ignore as $pattern)
	{
	if ( preg_match($pattern, $value) )
	    {
	    continue 2;
	    }
	}

    // if a file
    if ( is_file($dirpath . '/' . $value) )
	{
	echo "<a class=\"file\" href=\"$dirpath/". rawurlencode($value) ."\">$value</a><br>\n";
	}

    //Its a directory
    else
	{
	echo "<a class=\"dir\" href=\"./?browse=" . rawurlencode($dirpath) ."/" . rawurlencode ($value) ."\">[ $value ] </a><br>\n";
	}
    }
?>

</div>

</body>
</html>
