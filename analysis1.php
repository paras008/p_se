<?php require 'init.php'; ?>
	<style type="text/css">
		.first-block { margin: 50px auto 50px auto; width: 40%; padding: 30px; background: #c1c1c1; box-shadow: 0px 0px 77px -8px black; }
		.second-block { margin: 50px auto; width: 100%; padding: 30px; background: #c1c1c1; box-shadow: 0px 0px 77px -8px black; }
		input { border: 1px solid black !important; }
		.ui-autocomplete .ui-menu-item { background: white; padding: 3px 5px; }
		.ui-autocomplete .ui-menu-item:hover { background: #d3d3d3; color: white }
		input[type=search]::-webkit-search-cancel-button { -webkit-appearance: searchfield-cancel-button; }
		.details { background: #e3e3e3; }
		.green { background: #41d041; }
		.red { background: #f79898; }
		.graph-btn { margin: 0px 5px 5px 0px; }
	</style>
	<div class="container-fluid">
		<!-- <div class="container"> -->
			<div class="col-md-12">
				<div class="first-block">
					Enter Stock Name or Symbol
					<input type="search" name="stock" id="stock" class="form-control">
					<!-- <button id="pcjeweller" class="btn">PCJEWELLER</button> -->
					<?php
					date_default_timezone_set("UTC");
					$file = fopen("eq.csv","r");
					$stock = [];
					while(!feof($file))
					{
						$temp = fgets($file);
						$stock[] = str_replace(',', '- ', $temp);
					}
					fclose($file);
					?>
				</div>
				<div class="details second-block" style="display: none;">
					<div class="stock-header h3 pull-left"></div>
					<div class="form-inline pull-right">
						<button class="btn btn-sm btn-info graph-btn" data-value="today" id="today">Today</button>
						<button class="btn btn-sm btn-info graph-btn" data-value="1min" id="1min">1 min</button>
						<button class="btn btn-sm btn-info graph-btn" data-value="5min" id="5min">5 min</button>
						<button class="btn btn-sm btn-info graph-btn" data-value="15min" id="15min">15 min</button>
						<button class="btn btn-sm btn-info graph-btn" data-value="30min" id="30min">30 min</button>
						<button class="btn btn-sm btn-info graph-btn" data-value="60min" id="60min">60 min</button>
					</div>
					<div class="clearfix"></div>
					<div id="curve_chart" style="width: 100%; height: 500px"></div>
					<div id="analysis" class="analysis"></div>
					<input type="hidden" name="response" value="" id="response">
				</div>
			</div>
		<!-- </div> -->
	</div>

	<script type="text/javascript">
		$( function() {
			var availableTags = <?php echo json_encode($stock); ?>;
			// console.log(availableTags);
			$( "#stock" ).autocomplete({
				minLength: 3,
				source: availableTags
			}).keydown(function(e){
				if (e.keyCode === 13){
					$.fn.myFunction();
					// $('.header').html($('#stock').val());
				}
			});
		});

		$('#pcjeweller').click(function(event) {
			$.fn.myFunction();
		});
		$('.graph-btn').click(function(event) {
			var btn_time = $(this).data('value');
			$.fn.myFunction(btn_time);
		});

		$.fn.myFunction = function se_call(btn_time) {
			var str = $('#stock').val();
			// var time = $('#time').val();
			if ( btn_time == '' || btn_time == undefined ) { btn_time = '1min'; }
			console.log(btn_time);
			var symbol = str.split('-')[0];
			$.ajax({
				url: 'request1.php',
				type: 'POST',
				data: {'symbol': symbol, 'time': btn_time},
			})
			.done(function(data_all) {
				$('.details').show();
				$('.stock-header').html(str);
				google.charts.load('current', {'packages':['corechart']});
				google.charts.setOnLoadCallback(drawBasic);
				function drawBasic() {
					var data = new google.visualization.DataTable();
					data.addColumn('datetime', 'Time');
					data.addColumn('number', 'Performance');

					var time = [];
					var t = [];
					var date = [];
					var dd = jQuery.parseJSON(data_all);
					var temp
					console.log(dd);
					for (var i = 0; i < dd.length; i++) {
						// time[i] = dd[i][0];
						dd[i][0] = new Date(dd[i][0]);
						// t = time[i].split('-');
						// dd[i][0] = new Date(Date.UTC(t[0], t[1], t[2], t[3], t[4], t[5]))
						// dd[i][0] = [t[3], t[4], t[5]];
					}
					console.log(dd);
					data.addRows(dd);
					var options = {
						title: 'Company Performance',
						curveType: 'function',
						legend: { position: 'bottom' },
						hAxis: {
							format: 'HH:mm:ss',
							// title: 'Time'
						},
						vAxis: {
							// title: 'Data'
						}
					};
					var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
					chart.draw(data, options);
				}
			})
			.fail(function() {
				console.log("error");
			});
		}
	</script>
	</body>
	</html>