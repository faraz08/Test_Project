//[widget charts Javascript]

//Project:	Maximum Admin - Responsive Admin Template
//Version:	1.1.0
//Last change:	15/08/2017
//Primary use:   Used only for the  widget charts


$(function () {

	'use strict';

	$(function () {

		$(function (){

			//var urlPath = 'http://' + window.location.hostname + '/laravel' +'/getMonthlyCasesData';
			var urlPath = 'https://' + window.location.hostname + '/dev2' +'/getMonthlyCasesData';
			//var urlPath = window.location.href +'/getMonthlyCasesData';

			//alert(urlPath);
            //
			//return false;


			var request = $.ajax({

				method: 'GET',
				url: urlPath,

			});
			request.done(function(response){

				console.log(response);
				var barChartCanvas = $('#barChart').get(0).getContext('2d');
				var barChart            = new Chart(barChartCanvas);

				var barChartData = {
					labels  : response.month,
					datasets: [
						{
							label               : 'Cases',
							fillColor           : 'rgba(38,198,218,1)',
							strokeColor         : 'rgba(38,198,218,0)',
							pointColor          : '#26c6da',
							pointStrokeColor    : 'rgba(38,198,218,0)',
							pointHighlightFill  : '#fff',
							pointHighlightStroke: 'rgba(38,198,218,1)',
							data                : response.cases_count
						},

					]
				};

				var barChartOptions                  = {
					//Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
					scaleBeginAtZero        : true,
					//Boolean - Whether grid lines are shown across the chart
					scaleShowGridLines      : true,
					//String - Colour of the grid lines
					scaleGridLineColor      : 'rgba(0,0,0,.05)',
					//Number - Width of the grid lines
					scaleGridLineWidth      : 1,
					//Boolean - Whether to show horizontal lines (except X axis)
					scaleShowHorizontalLines: true,
					//Boolean - Whether to show vertical lines (except Y axis)
					scaleShowVerticalLines  : true,
					//Boolean - If there is a stroke on each bar
					barShowStroke           : true,
					//Number - Pixel width of the bar stroke
					barStrokeWidth          : 2,
					//Number - Spacing between each of the X value sets
					barValueSpacing         : 30,
					//Number - Spacing between data sets within X values
					barDatasetSpacing       : 1,
					//String - A legend template
					legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
					//Boolean - whether to make the chart responsive
					responsive              : true,
					maintainAspectRatio     : true
				};

				barChartOptions.datasetFill = false,
					barChart.Bar(barChartData, barChartOptions);
			});

			})
		});


}); // End of use strict
