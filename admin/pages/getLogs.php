<?php
session_start();

if (!isset ($_SESSION['username']))
{
    header('Location: ../login.html');
}

require "../../vendor/autoload.php";

use Valkyrie\DB\Database;

$db = new Database();
$pdo = $db->pdo;

$query = "SELECT * FROM valkyrie_logs;";

$stmt = $pdo->prepare($query);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$path = tempnam(sys_get_temp_dir(), 'valkyrie_log-');

$file = fopen($path, "w");

foreach ($result as $row)
{
    fputcsv($file, $row);
}

fclose($file);

header("Content-type: text/csv");
header("Content-disposition: attachment; filename = logs.csv");
readfile($path);

?>