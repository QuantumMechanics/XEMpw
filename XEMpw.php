<? ?>
<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>KrakenLabs - XEMpw</title>
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="Quantum_Mechanics" />
		<link rel="shortcut icon" href="../favicon.ico">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.qrcode.js"></script>
		<script type="text/javascript" src="js/qrcode.js"></script>
	</head>
	<body>
		<div class="container">
			<? 

			#include the required class

			require_once 'inc/NEM.php';

			#define the initial configuration parameters
			#if not defined the defaults will be used
			#We set a trusted node as remote NIS but you can use local NIS too
			$conf = array('nis_address' => 'go.nem.ninja');

			#create an instance using a user defined configuration options
			$nem = new NEM($conf);	

	$opt = $nem->get_options('nis_address');

	//the JSON string to be decoded
	$res = $nem->nis_get('/heartbeat');
	 
	  //decoding the above JSON string
	  $json=json_decode($res);
	 
	 #Monitoring connection
	 if ($json->message == 'ok'){
		echo '<center><b>CONNECTED TO: <span style="color:green;">'.$opt."</span></b><br>";
		echo '<b>NIS STATUT: <span style="color:green;">OK</span></b></div></center>';
	}

	else {
		echo '<center><b>CONNECTION FAIL: '.$opt."</b><br>";
		echo '<b>NIS STATUT: <span style="color:red;">DOWN</span></b></div></center>';
	}

	if (isset($_GET['generate'])){

	$newaddress = $nem->nis_get('/account/generate');
	$decodenewaddress=json_decode($newaddress);
	
	#XEM address
	$str = $decodenewaddress->address;
	#Every 4 chars we want a space
	$token = chunk_split($str,4,' ');
	#Every 10 chars we want "\n"
	$separate= chunk_split($token,10,'\n');

	#XEM private key
	$strpk = $decodenewaddress->privateKey;
	#Every 4 chars we want a space
	$tokenpk = chunk_split($strpk,4,' ');
	#Every 10 chars we want "\n"
	$separatepk= chunk_split($tokenpk,10,'\n');
	?>

	<br>
		<center><div id="keyarea" style="display:inline-flex;height:250px;background: none repeat scroll 0% 0% white;">
			<div id="address"><p><b>XEM Address</b></p><div id="qrcode"></div><p style="color:green;font-size:100%;"><b>SHARE</b></p><p><b><? echo $str; ?></b></p>
			<script>
			jQuery('#qrcode').qrcode({width: 132,height: 132, text : "<? echo $str; ?>"
			});
			</script></div> 
			<div id="privatekey"><p><b>Private Key</b></p><div id="qrcodeprivate"></div><p style="color:red;font-size:100%"><b>PRIVATE</b></p><p><b><? echo $strpk; ?></b></p>
			<script>
				jQuery('#qrcodeprivate').qrcode({width: 164,height: 164, text : "<? echo $strpk; ?>"
			});
			</script></div>
		</div></center>

	 <br><br><br>
	<center><canvas id="myCanvas" width="486" height="261" style="border:1px solid #000000;">
	<script>

	var c = document.getElementById("myCanvas");
	var ctx = c.getContext("2d");

	//Background parameters
	var background = new Image();
	   //Below you define your background image (need to be same size as canvas)
	    background.src = 'images/nempaper.png';
	    //Background load function to insure we do not generate with no background
	    background.addEventListener('load', function() {
		ctx.drawImage(background, 0, 0);
	    
	//Here is the splitting process for the address
	function fillTextMultiLine(ctx, text, x, y) {
	  var lineHeight = ctx.measureText("<? echo substr_replace($separate ,"",-3) ?>").width * 0.05;
	  var lines = text.split("\n");
	  for (var i = 0; i < lines.length; ++i) {
	    ctx.fillText(lines[i], x, y);
	    y += lineHeight;
	  }
	}

	//Writing address in canvas
	ctx.fillStyle = "#444";
	ctx.font = "bold 11pt Arial";
	//85 and 195 are text x and y position
	fillTextMultiLine(ctx,"<? echo substr_replace($separate ,"",-3) ?>",200, 75);

	//Here is the splitting process for the private key
	function fillTextMultiLinepk(ctx, text, x, y) {
	  var lineHeight = ctx.measureText("<? echo substr_replace($separatepk ,"",-3) ?>").width * 0.028;
	  var lines = text.split("\n");
	  for (var i = 0; i < lines.length; ++i) {
	    ctx.fillText(lines[i], x, y);
	    y += lineHeight;
	  }
	}

	//Writing private key in canvas
	ctx.fillStyle = "#D5A51B";
	ctx.font = "bold 11pt Arial";
	//420 and 75 are text x and y position
	fillTextMultiLinepk(ctx,"<? echo substr_replace($separatepk ,"",-3) ?>",370, 75);

	}, false); //end background load function

	 function printCanvas2()  
	{  
	    var dataUrl = document.getElementById('myCanvas').toDataURL();
	    var windowContent = '<!DOCTYPE html>';
	    windowContent += '<html>'
	    windowContent += '<head><title>Print canvas</title></head>';
	    windowContent += '<body>'
	    windowContent += '<img src="' + dataUrl + '">';
	    windowContent += '</body>';
	    windowContent += '</html>';
	    var printWin = window.open('','','width=500,height=280');
	    printWin.document.open();
	    printWin.document.write(windowContent);
	    printWin.document.close();
	    printWin.focus();
	    printWin.print();
	    printWin.close();
	}
	</script>

	</canvas>
	<br>
	<button id="print" onclick=printCanvas2()>Print</button>

	<?


	}

	else {
		echo '<br><br><center><div class="text-center"><a href="XEMpw.php?generate"><b>GENERATE PAPER WALLET</b></a></div></center>';
	}

	 ?>

	<br><br>
	<center><p><b>/!\WARNING:<br> Built for educational purposes, use at your own risk</b>
	<br> <br>
	<b>If you get empty images after generating, refresh the page.</b></p>
	<br>
	<center><div><u><h2><b>Useful Links</b></h2></u>
	<p><a href="http://nem.io" target="_blank">NEM Website</a>
	<br>
	<a href="http://blog.nem.io/getting-started-with-nem/" target="_blank">How to redeem your coins on NEM Client</a></p>
	</div></center>


		</div><!-- /container -->
		<br><br>
		<center><footer class="text-center"><b>Donation:</b> 1BRuxYZ3ohDJkfEWKVMWAiYrAYjwNSaPJs</footer></center>		


	</body>

</html>
