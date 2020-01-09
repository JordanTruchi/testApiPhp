<?php
require_once ('./env.php');
try {
    $dbh = new PDO('mysql:host='.BASE_HOST.';dbname='.DB_NAME, LOGIN_BDD, MDP_BDD);
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
?>