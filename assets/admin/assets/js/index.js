'use strict';
var pieChartHandler = function() {

	// Chart.js Options
	var options = {

		// Sets the chart to be responsive
		responsive: false,

		//Boolean - Whether we should show a stroke on each segment
		segmentShowStroke: true,

		//String - The colour of each segment stroke
		segmentStrokeColor: '#fff',

		//Number - The width of each segment stroke
		segmentStrokeWidth: 2,

		//Number - The percentage of the chart that we cut out of the middle
		percentageInnerCutout: 0, // This is 0 for Pie charts

		//Number - Amount of animation steps
		animationSteps: 100,

		//String - Animation easing effect
		animationEasing: 'easeOutBounce',

		//Boolean - Whether we animate the rotation of the Doughnut
		animateRotate: true,

		//Boolean - Whether we animate scaling the Doughnut from the centre
		animateScale: false,

		//String - A legend template
		legendTemplate: '<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'

	};

	// Get context with jQuery - using jQuery's .get() method.
	var ctx = $("#chart3").get(0).getContext("2d");
	// This will get the first returned node in the jQuery collection.
	pieChart = new Chart(ctx).Pie(appChartData, options);

	//generate the legend
	var legend = pieChart.generateLegend();
	//and append it to your page somewhere
	$('#chart3Legend').append(legend);
};

var lineChartHandler = function() {
	var options = {
		// Sets the chart to be responsive
		responsive: true,

		///Boolean - Whether grid lines are shown across the chart
		scaleShowGridLines: true,

		//String - Colour of the grid lines
		scaleGridLineColor: 'rgba(0,0,0,.05)',

		//Number - Width of the grid lines
		scaleGridLineWidth: 1,

		//Boolean - Whether the line is curved between points
		bezierCurve: true,

		//Number - Tension of the bezier curve between points
		bezierCurveTension: 0.4,

		//Boolean - Whether to show a dot for each point
		pointDot: true,

		//Number - Radius of each point dot in pixels
		pointDotRadius: 4,

		//Number - Pixel width of point dot stroke
		pointDotStrokeWidth: 1,

		//Number - amount extra to add to the radius to cater for hit detection outside the drawn point
		pointHitDetectionRadius: 20,

		//Boolean - Whether to show a stroke for datasets
		datasetStroke: true,

		//Number - Pixel width of dataset stroke
		datasetStrokeWidth: 2,

		//Boolean - Whether to fill the dataset with a colour
		datasetFill: true,

		// Function - on animation progress
		onAnimationProgress: function() {
		},

		// Function - on animation complete
		onAnimationComplete: function() {
		},

		//String - A legend template
		legendTemplate: '<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>'
	};
	var data = {
		labels: lineChartLabels,
		datasets: lineChartData
	};

	// Get context with jQuery - using jQuery's .get() method.
	var ctx = $("#lineChart").get(0).getContext("2d");
	// This will get the first returned node in the jQuery collection.
	lineChart = new Chart(ctx).Line(data, options);
	//generate the legend
	var legend = lineChart.generateLegend();
	//and append it to your page somewhere
	$('#lineLegend').append(legend);
};