<?php
require_once '/tools/functions.php';
$instanceID = explode(" ",shell_exec('tools/ec2-metadata -i'))[1];
$elasticIP = explode(" ",shell_exec('tools/ec2-metadata -v'))[1];
echo "Instance ID = " . $instanceID; 
echo "Curren IP = " . $elasticIP;

// Require the Composer autoloader.
require 'vendor/autoload.php';

?>
