<?php
require_once 'tools/functions.php';

// Prepare variables.
// Run ec2-metadata to get instances information
$instanceID = explode(" ",shell_exec('tools/ec2-metadata -i'))[1];
$instanceID = preg_replace('/\s+/', '', $instanceID);
$elasticIP = explode(" ",shell_exec('tools/ec2-metadata -v'))[1];
$elasticIP = preg_replace('/\s+/', '', $elasticIP);

// Get required information from system
$vpc_id = file_get_contents('data/vpc.txt');
$aws_credentials = file_get_contents('data/config');
$handle = fopen("data/config", "r");
$i = 0;
$aws_credentials = array();
$k = $v = '';
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        // process the line read.
        $read = preg_replace('/\s+/', '', $line);
        if (strpos($read, '=') !== false)list($k, $v) = explode('=', $read);
        $aws_credentials[$k] = $v;
        $i++;
    }
    fclose($handle);
}

echo "BootDev DVPN console" . '<br>';
//echo 'Values starts<br>';
//echo "Instance ID = " . $instanceID . '<br>'; 
echo "Curren IP = " . $elasticIP . '<br>';
//echo "VPC = " . $vpc_id . '<br>';
//echo "aws_access_key_id = " . $aws_credentials['aws_access_key_id'] . '<br>'; 
//echo "aws_secret_access_key = " . $aws_credentials['aws_secret_access_key'] . '<br>';
//echo "region = " . $aws_credentials['region'] . '<br>';
echo '<br>';

// Check if action is set
if(!empty($_REQUEST['action'])){
    $action_set = true;
}

if(isset($action_set) && $action_set){
    if($_REQUEST['action'] == 'refresh'){
        include 'refresh.php';
    }
}
?>
<form class="form-no-horizontal-spacing" id="refreshForm" action="index.php?action=refresh" method="post">
    <button class="btn btn-primary btn-cons" type="submit" >Refresh VPN IP</button>
</form>

<form class="form-no-horizontal-spacing" id="reloadForm" action="index.php" method="post">
    <button class="btn btn-primary btn-cons" type="submit" >Reload page</button>
</form>

<?php
$README = fopen('README.md', 'r');
$line = fgets($README);
fclose($f);
echo 'BootDev dvpn version v' . explode("=",$line)[1];
?>
