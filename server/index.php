<?php
require("config.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>FIT VUT IoT test</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<style>

	.led { color: #600; }
	.led.light {color: red;}

	.pull-left {
		width: 35%;
	}

	.pull-right {
		width: 65%;
		text-align: right
	}

	.measure-number {
		font-size: 4rem;
		font-weight: normal;
		margin-top: 0;
		text-align: center;
	}

	.online .measure-number {
		color: #28a745;
	}

	.offline .value {
		color: #aaa;
		text-decoration: line-through;
	}

	.leds {
		font-size: 2rem;
		margin-bottom: 0;
		text-align: center;
	}

	.value {
		font-size: 3rem;
		margin-top: 0;
	}

	.note {
		font-size: 2rem;
		margin-bottom: 0;
	}

	</style>
  </head>
  <body>

	<div class="container theme-showcase" role="main">
	<p></p>
<?php
/*
	for($i = $conf["id_offset"]; $i < $conf["id_offset"] + $conf["id_cnt"]; $i++)
	{
		echo "<div class=\"col-sm-3\">";
		echo '  <div class="panel panel-primary" id="measure_' . $i . '">';
		echo '    <div class="panel-heading">';
		echo '      <h3 class="panel-title"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Měření #' . $i . '</h3>';
		echo '    </div>';
		echo '    <div class="panel-body">';
		echo '      <span class="value">NaN</span>';
		echo '<span class="pull-right">';
		echo '   <span class="glyphicon glyphicon-stop led1" aria-hidden="true"></span> ';
		echo '   <span class="glyphicon glyphicon-stop led2" aria-hidden="true"></span> ';
		echo '   <span class="glyphicon glyphicon-stop led3" aria-hidden="true"></span>';
		echo '</span>';
		echo '      <div class="note" >Poznámka...</div>';
		echo '    </div>';
		echo '  </div>';
		echo '</div>';



	}
	*/
?>

<?php for($i = $conf["id_offset"]; $i < $conf["id_offset"] + $conf["id_cnt"]; $i++): ?>
	<div class="col-sm-3">
		<div class="panel panel-primary" id="measure_<?= $i ?>">
			<div class="panel-body">
				<div class="pull-left">
					<h3 class="measure-number">#<?= $i ?></h3>
					<p class="leds">
						<span class="glyphicon glyphicon-stop led led1" aria-hidden="true"></span>
						<span class="glyphicon glyphicon-stop led led2" aria-hidden="true"></span>
						<span class="glyphicon glyphicon-stop led led3" aria-hidden="true"></span>
					</p>
				</div>
				<div class="pull-right">
					<p class="value">NaN</p>
					<p class="note" >Poznámka...</p>
				</div>
			</div>
		</div>
	</div>
<?php endfor ?>

		<div class="col-sm-6" style="text-align: center;">
			<img src="logo.png" style="width: 90%">
		</div>
	</div>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="js/jquery-3.2.1.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>

	<script>

	(function worker() {
		$.getJSON("readdata.php", function(result){
			$.each(result, function(i, field){
				//console.log(field);
				var v = parseFloat(field["temp"]);
				var s = "#measure_" + field["id"];

				var panel = $(s);

				if (parseInt(field["is_online"]) > 0) {
					panel.addClass("online");
					panel.removeClass("offline");
				} else {
					panel.addClass("offline");
					panel.removeClass("online");
				}

				$(s + " .value").html(v.toFixed(2) + "°C");
				$(s + " .note").html(field["note"] + "&nbsp;");
				var v = parseInt(field["status"]);

				if(v & 0x01) {
					$(s + " .led1").addClass("light");
				} else {
					$(s + " .led1").removeClass("light");
				}

				if(v & 0x02) {
					$(s + " .led2").addClass("light");
				} else {
					$(s + " .led2").removeClass("light");
				}

				if(v & 0x04) {
					$(s + " .led3").addClass("light");
				} else {
					$(s + " .led3").removeClass("light");
				}

			});
		}).always(function() {
			setTimeout(worker, 500);
		});;
	})();
	</script>
  </body>
</html>
