<html>
	<head>
		<title>Dvpn_ui</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>



<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<section id="main">
						<header>
					
							<h1>Dvpn UI</h1>
							<p>UI version K1</p>
						</header>
                        
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
					</section>

				<!-- Footer -->
					<footer id="footer">
						<ul class="copyright">
							<li>&copy; Jacky Chan</li>
							<li>Design: Jacky Chan</li>
						</ul>
					</footer>

			</div>

		<!-- Scripts -->
			<!--[if lte IE 8]><script src="assets/js/respond.min.js"></script><![endif]-->
			<script>
				if ('addEventListener' in window) {
					window.addEventListener('load', function() { document.body.className = document.body.className.replace(/\bis-loading\b/, ''); });
					document.body.className += (navigator.userAgent.match(/(MSIE|rv:11\.0)/) ? ' is-ie' : '');
				}
			</script>

	</body>
</html>
