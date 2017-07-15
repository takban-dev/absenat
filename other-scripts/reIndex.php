<?php
/* =================    Database connection ==================== */
$servername = "localhost";
$username = "root";
$password = "1996";
$dbname = "absenat";

// Create connection
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->exec("SET NAMES utf8");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function sortTable($table, $conn){
    $titles = array();

    $sql = "SELECT title FROM $table WHERE id > 1 ORDER BY title ASC";
    $res = $conn->query($sql);
    foreach($res as $row)
        array_push($titles, $row['title']);

    $conn->query("DELETE FROM `$table` WHERE id > 1");
    $idIndex = 2;
    foreach($titles as $title){
        $statement = $conn->query("INSERT INTO $table (id, title) VALUES($idIndex, '$title')");
        $idIndex ++;
    }
    echo "table $table sorted:\n";
    var_dump($titles);

}

$tables = ['cities', 'certificate_types', 'degrees', 'job_fields', 'study_fields'];
foreach($tables as $table)
    sortTable($table, $conn);

echo "done!\n";
?>
