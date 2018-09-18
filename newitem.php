<?php
$name = $_POST['name'];
$last = $_POST['last'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$type = $_POST['type'];
$amount = $_POST['amount'];
$val = explode(" ", $type);
$val = explode("E", $val[1]);
$kaina = doubleval($val[0]) * $amount;

require "connect.php";

date_default_timezone_set('Europe/Vilnius');
$date = date("Y-m-d H:i:s");
$sql = "INSERT into sys.uzsakymai(vardas, pavarde, telefonas, mailas, adresas, tipas, kiekis, kaina, statusas, dat) values ('$name', '$last', '$phone', '$email', '$address', '$type', $amount, $kaina, 'neapmokėta', '$date')";
if($result = $conn->query($sql))
{
    echo '<script type="text/javascript">'; 
    echo 'alert("Registracija sėkminga");'; 
    echo 'window.location.href = "./";';
    echo '</script>';
}
else
{
    die($conn->error);
    if(strlen($name) > 30 || strlen($last) > 45 || strlen($phone) > 15)
    {
        
        echo '<script type="text/javascript">'; 
        echo 'alert("Klaidingi duomenys");'; 
        echo 'window.location.href = "index.html";';
        echo '</script>';
        die();
    }
} 
?>