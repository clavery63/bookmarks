<?php
require('../vendor/autoload.php');

if (preg_match('/dev/', $_SERVER['SERVER_NAME'])) {
  $dbopts = array(
    'path' => 'bookmarks',
    'host' => 'localhost',
    'user' => 'clavery',
    'pass' => ''
  );
} else {
  $dbopts = parse_url(getenv('DATABASE_URL'));
}


$dsn = 'pgsql:dbname='.ltrim($dbopts["path"],'/').';host='.$dbopts["host"];
$port = $dbopts["port"];
$username = $dbopts["user"];
$password = $dbopts["pass"];
$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

try {
  $db = new PDO($dsn, $username, $password, $options);
} catch (PDOexception $e) {
  $error = $e->getMessage();
  echo "error connecting: $error";
}

try {
  $query = 'SELECT * from test_table';
  $statement = $db->prepare($query);
  $statement->execute();
  $results = $statement->fetchAll();
  $statement->closeCursor();
} catch (PDOexception $e) {
  $error = $e->getMessage();
  echo "error fetching: $error";
}

echo print_r($results, true);
?>
