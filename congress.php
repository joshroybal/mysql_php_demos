<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
<link id="styleinfo" media="all">
<title>Josh Roybal</title>
<script type="text/javascript" src="congress.js" defer></script>
</head>
<body>
<header><p>Josh Roybal</p></header>
<br>
<div><a href='index.php'>Home</a></div>
<br>
<form action='congress.php' method='POST'>
<div><label> SQL QUERY </label></div><textarea name='query' rows='12' cols='80'>
<?php
if ( !empty($_POST['query'] ) )
{
   echo $_POST['query']; 
}
?>
</textarea>
<br>
<div><input type='submit' name='sql_query'></div>
</form>
<br>
<?php

/* still to be dealt with
 * extracting all the column/field names when the users chooses * for select
 * not including those form fields left blank by the user in the query */
require('connect_congress_db.php');

// get user form fields
if ( !empty($_POST['query'] ) )
{
   $query = $_POST['query'];
}
else  // exit on empty query
{
   echo "<br>";
   echo "<div><a href='index.php'>Home</a></div>\n";   
   include('includes/footer.html');
   exit();
}

// read-only hack
if ( strpos(strtoupper($query), 'UPDATE') !== false 
    || strpos(strtoupper($query), 'DELETE') !== false
    || strpos(strtoupper($query), 'INSERT') !== false 
    || strpos(strtoupper($query), 'ALTER') !== false 
    || strpos(strtoupper($query), 'INDEX') !== false
    || strpos(strtoupper($query), 'DROP') !== false
    || strpos(strtoupper($query), 'GRANT') !== false
    || strpos(strtoupper($query), 'REVOKE') !== false
    || strpos(strtoupper($query), 'CREATE') !== false
    )
{
    echo '<p>write operations not allowed - please try again</p>';
    echo "<br>";
    echo "<div><a href='index.php'>Home</a></div>\n";
    include('includes/footer.html');   
    exit();
}

// ready for query results now
$results = mysqli_query($dbc, $query);
if (!$results) 
{
   echo '<p>bad query - please try again</p>';
   echo "<br>";
   echo "<div><a href='index.php'>Home</a></div>\n";
   include('includes/footer.html');   
   exit();
}

$n = mysqli_num_rows( $results );
echo "no. of rows = $n\n";
if ( $n > 0 && $n <= 541 )
{
   echo "<div id='statecol'></div>\n";
   echo "<table id='my_table'>\n";
   // emit table header row
   echo "<tr>";
   for($i = 0; $i < mysqli_num_fields( $results ); $i++) 
   {
      $field_info = mysqli_fetch_field($results);
      echo "<th>{$field_info->name}</th>";
   } 
   echo "<tr>\n";
   // emit table data rows
   while ( $row = mysqli_fetch_array( $results, MYSQLI_NUM ) )
   {
      echo "<tr>";
      for ($i = 0; $i < count($row); $i++)
      {
         echo "<td>" . $row[$i] . "</td>";
      }
      echo "</tr>\n";
   }
   echo "</table>\n";
}
mysqli_close( $dbc ) ;
echo "<br>\n";
echo "<div><a href='index.php'>Home</a></div>\n";
include('includes/footer.html');
?>
