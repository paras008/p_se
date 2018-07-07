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
	</style>
	<div class="container-fluid">
		<div class="container">
			<div class="col-md-12">
				<div class="first-block">
					Enter Stock Name or Symbol
					<input type="search" name="stock" id="stock" class="form-control">
					<?php
					$file = fopen("eq.csv","r");
					$stock = [];
					while(!feof($file))
					{
						$temp = fgets($file);
						$stock[] = str_replace(',', '-', $temp);
					}
					fclose($file);
					?>
				</div>
				<div class="details second-block" style="display: none;">
					<div class="header h3"></div>
					<div id="table" class="table">
						<table id="tbl" class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>time</th>
									<th>open</th>
									<th>high</th>
									<th>low</th>
									<th>close</th>
									<th>volume</th>
									<th>change</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
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
					$('.header').html($('#stock').val());
				}
			});
		});

		$.fn.myFunction = function se_call() {
			var str = $('#stock').val();
			var symbol = str.split('-')[0];
			$.ajax({
				url: 'https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol='+symbol+'&interval=1min&apikey=MTVSJ3KWHS922R2L',
				type: 'GET',
			})
			.done(function(data) {
				$("#tbl tbody").remove();
				var temp, pre = 0, change, total = 0;
				$('.details').show();

				$.each(data['Time Series (1min)'], function (i,v) {
					if (total == 20) { return false; } else { total = total + 1; }
					temp += '<tr>';
					temp += '<td>'+i+'</td>';

					$.each(v, function (ii,vv) {
						temp += '<td>'+vv+'</td>';
						if(ii == '4. close') 
						{ change = vv - pre; pre = vv; }
					});
					if (total == 1) { temp += '<td> ---- </td>'; }
					else {
						if ((-change.toFixed(2)) >= 0) { temp += '<td class="green">'+(-change.toFixed(2))+'</td>'; }
						else { temp += '<td class="red">'+(-change.toFixed(2))+'</td>'; } 
					}
					
					temp += '</tr>';
				});
				$('#tbl').append(temp);
			})
			.fail(function() {
				console.log("error");
			});
		}
	</script>
</body>
</html>