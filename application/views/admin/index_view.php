<div class="main-content" >
	<div class="wrap-content container" id="container">
		<!-- start: CONDENSED TABLE -->
		<div class="container-fluid container-fullw bg-white">
			<div class="col-md-6">
				<p>
					Last Update: <?=$healthchecks['time']?> UTC
				</p>
				<table class="table table-bordered table-hover" id="sample-table-4">
					<thead>
						<tr>
							<th>Application</th>
							<th class="hidden-xs">Status</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($healthchecks['status'] as $key => $value) { ?>
						<tr>
							<td>
							<a href="#">
								<?=$key?>
							</a></td>
							<td class="hidden-xs"><span class="label label-sm label-<?php
							if($value == 'error') { echo 'warning'; }
							else if($value == 'success') { echo 'success'; }
							else if($value == 'failed') { echo 'danger'; } ?>"><?=$value?></span></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>

			<div class="col-sm-6" id="app_usage_graph">
				<div class="panel panel-white no-radius">
					<div class="panel-heading border-bottom">
						<h4 class="panel-title">Number of application usages during last week</h4>
					</div>
					<div class="panel-body">
						<div class="text-center">
								<canvas id="chart3" class="full-width" width="500" height="750" style="width: 500px; height: 550px;"></canvas>
						</div>
						<div class="margin-top-20 text-center legend-xs inline">
							<div id="chart3Legend" class="chart-legend"></div>
						</div>
					</div>
				</div>

				<div class="panel panel-white no-radius">
					<div class="panel-heading border-bottom">
						<h4 class="panel-title">Number of user sessions during last week</h4>
					</div>
					<div class="panel-body">
						<div class="text-center">
								<canvas id="lineChart" class="full-width" width="300" height="400" style="width: 808px; height: 404px;"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end: CONDENSED TABLE -->
	</div>
</div>

<!-- end: MAIN JAVASCRIPTS -->
<script src="<?php echo base_url();?>assets/admin/vendor/Chart.js/Chart.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/vendor/jquery.sparkline/jquery.sparkline.min.js"></script>
<!-- start: CLIP-TWO JAVASCRIPTS -->

<script src="<?php echo base_url();?>assets/admin/assets/js/index.js"></script>

<script>

	Colors = {};
	Colors.names = [
		"#00ffff",
		"#000000",
		"#0000ff",
		"#a52a2a",
		"#00ffff",
		"#00008b",
		"#008b8b",
		"#a9a9a9",
		"#006400",
		"#bdb76b",
		"#8b008b",
		"#556b2f",
		"#ff8c00",
		"#9932cc",
		"#8b0000",
		"#e9967a",
		"#9400d3",
		"#ff00ff",
		"#ffd700",
		"#008000",
		"#4b0082",
		"#f0e68c",
		"#add8e6",
		"#e0ffff",
		"#90ee90",
		"#d3d3d3",
		"#ffb6c1",
		"#ffffe0",
		"#00ff00",
		"#ff00ff",
		"#800000",
		"#000080",
		"#808000",
		"#ffa500",
		"#ffc0cb",
		"#800080",
		"#800080",
		"#ff0000",
		"#c0c0c0",
		"#ffff00",
		"#00ffff",
		"#000000",
		"#0000ff",
		"#a52a2a",
		"#00ffff",
		"#00008b",
		"#008b8b",
		"#a9a9a9",
		"#006400",
		"#bdb76b",
		"#8b008b",
		"#556b2f",
		"#ff8c00",
		"#9932cc",
		"#8b0000",
		"#e9967a",
		"#9400d3",
		"#ff00ff",
		"#ffd700",
		"#008000",
		"#4b0082",
		"#f0e68c",
		"#add8e6",
		"#e0ffff",
		"#90ee90",
		"#d3d3d3",
		"#ffb6c1",
		"#ffffe0",
		"#00ff00",
		"#ff00ff",
		"#800000",
		"#000080",
		"#808000",
		"#ffa500",
		"#ffc0cb",
		"#800080",
		"#800080",
		"#ff0000",
		"#c0c0c0",
		"#ffff00"
	];

	var currentIndex = 0;

	Colors.next = function() {
		var color = this.names[currentIndex];
		currentIndex++;
		return color;
	};

	function increase_brightness(hex, percent){
		// strip the leading # if it's there
		hex = hex.replace(/^\s*#|\s*$/g, '');

		// convert 3 char codes --> 6, e.g. `E0F` --> `EE00FF`
		if(hex.length == 3){
			hex = hex.replace(/(.)/g, '$1$1');
		}

		var r = parseInt(hex.substr(0, 2), 16),
			g = parseInt(hex.substr(2, 2), 16),
			b = parseInt(hex.substr(4, 2), 16);

		return '#' +
			((0|(1<<8) + r + (256 - r) * percent / 100).toString(16)).substr(1) +
			((0|(1<<8) + g + (256 - g) * percent / 100).toString(16)).substr(1) +
			((0|(1<<8) + b + (256 - b) * percent / 100).toString(16)).substr(1);
	}

	var appChartData = [];
	var lineChartLabels = [];
	var lineChartData = [];
	var lineChartPoints = [];
	var pieChart;
	var lineChart;

	function pieChartLiveUpdate() {
		$.getJSON( "/analytics/apps", function( data ) {

			var i = 0;

			$.each( data, function(key, val) {
				pieChart.segments[i].value = val[1];
				i++;
			});

			pieChart.update();
		});
	}

	function lineChartLiveUpdate() {
		$.getJSON( "/analytics/users", function( data ) {

			var j = 0;

			$.each( data, function(key, val) {
				lineChart.datasets[0].points[j].value = val[2];
				j++;
			});

			lineChart.update();
		});
	}

	jQuery(document).ready(function() {
		$.getJSON( "/analytics/apps", function( data ) {
			$.each( data, function(key, val) {
				var myColor = Colors.next();

				appChartData.push({	value: val[1],
									color: myColor,
									highlight: increase_brightness(myColor, 40),
									label: val[0]});
			});

			pieChartHandler();

			setInterval(function (){ pieChartLiveUpdate(); }, 5000);
		});

		$.getJSON( "/analytics/users", function( data ) {
			$.each( data, function(key, val) {
				lineChartLabels.push(val[1]);
				lineChartPoints.push(val[2]);
			});

			lineChartData.push({label: "Users",
								fillColor: "rgba(151,187,205,0.2)",
								strokeColor: "rgba(151,187,205,1)",
								pointColor: "rgba(151,187,205,1)",
								pointStrokeColor: "#fff",
								pointHighlightFill: "#fff",
								pointHighlightStroke: "rgba(151,187,205,1)",
								data: lineChartPoints});

			lineChartHandler();

			setInterval(function (){ lineChartLiveUpdate(); }, 5000);
		});
	});
</script>

<!-- end: CLIP-TWO JAVASCRIPTS -->