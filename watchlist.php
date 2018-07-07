<?php session_start(); ?>
<?php require 'init.php'; ?>
<?php if (!isset($_SESSION['username'])): ?>
	<?php header('Location:index.php'); ?>
<?php endif ?>

<style type="text/css">
.stock-table { box-shadow: 9px 6px 50px -5px black; }
/*.add-stock { border: 1px solid #1a1a1a; border-radius: 2px; min-height: 70px; padding: 10px;}*/
.stock-name { font-size: 24px; font-family: 'Times New Roman'; }
.stock-symbol { font-size: 12px; }
.td-stock-value { vertical-align: bottom !important; }
.stock-value { font-size: 24px; font-family: 'Open Sans', sans-serif; }
.td-stock-volume { vertical-align: bottom !important; }
.stock-volume { font-size: 11px; }
.opration-script { margin-bottom: 20px; }
.ui-widget.ui-widget-content { z-index: 2000 !important; }
.added-script { margin-top: 20px; }
input[type=search]::-webkit-search-cancel-button { -webkit-appearance: searchfield-cancel-button; }
.add-input { width: 90% !important; }
.add-display input, .add-display button { display: inline-block; !important; }
.tr-changed-color { background-color: black; color: chartreuse; }
.table-hover>tbody>tr:hover { color: black; }
.chk-error { color: red; }
</style>

<?php 
require 'connection.php';
$username = $_SESSION['username'];
$query = "SELECT `data` FROM `se_users` WHERE (`id`= '".$username."' )";
$result = mysqli_query($conn, $query);
$no_of_rows = mysqli_num_rows($result);
if ($no_of_rows == 1) {
	$row = mysqli_fetch_assoc($result);
	$data_assoc = json_decode($row['data'], true);
	$data_watchlist = $data_assoc['watchlist'];
	require 'request_watchlist.php';
}
?>
<div class="container">
	<div class="col-md-12">
		<div class="opration-script">
			<a href="#" class="btn btn-primary pull-right" data-toggle="modal" data-target="#add-script">Add Script</a>
			<a href="javascript:void(0)" id="delete-script" class="btn btn-primary">Delete Script</a>
			<a href="javascript:void(0)" onclick="location.reload();" class="btn btn-primary pull-right">Refresh</a><br>
			<span class="chk-error hidden">Check any script you want to delete and then press 'Delete Script' button.</span>
		</div>
		<table class="table table-bordered table-hover table-responsive stock-table" id="tbl-watchlist">
			<?php
			foreach ($data_watchlist as $key => $value) {
				$stock_name = substr($value, strpos($value, "-") + 1);
				$symbol = strtok($value, '-');
				?>
				<tr>
					<td class="mark-all">
						<input type="checkbox" name="mark" data-id="<?=$symbol;?>" >
					</td>
					<td>
						<span class="stock-symbol"><?=$symbol;?></span><br>
						<span class="stock-name"><?=$stock_name;?></span>
					</td>
					<td class="td-stock-value">
						<span class="stock-value"><?=$se_last_value[$key];?></span>
					</td>
					<td class="td-stock-volume">
						<span class="stock-volume">volume</span><br>
						<?=$se_last_volume[$key];?>
					</td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>
</div>

<div class="modal fade" id="add-script" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add Script</h4>
			</div>
			<div class="modal-body">
				<div class="">
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
				<div class="added-script">
					<form method="POST" id="watchlist_form" action="save_list.php"></form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-default" id="save_list">Save</button>
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
			change: function() {
				$.fn.myFunction();
			},
			source: availableTags
		}).keydown(function(e){
			if (e.keyCode === 13){
				$.fn.myFunction();
			}
		});
	});

	$.fn.myFunction = function se_call() {
		var str = $('#stock').val();
		var symbol = str.split('-')[0];
		var inp = '<div class="form-inline add-display '+symbol+'"><input type="text" class="form-control add-input" value="'+str+'" id="inp-'+symbol+'" name="'+symbol+'" disabled><input type="hidden" class="form-control add-input" value="'+str+'" id="inp-'+symbol+'" name="'+symbol+'"><button class="btn btn-primary delete-btn" id="'+symbol+'">X</button></div>';
		$('.added-script form').append(inp);
		$('#stock').val('');
	}

	$(document).on('click', '#save_list', function(event) {
		$('#watchlist_form').submit();
	});
	$(document).on('click', '#delete-script', function(event) {
		var data = [];
		$("input[name='mark']:checked").each(function() {
		    data.push($(this).data('id'));
		});

		if (data.length == 0) { 
			$('.chk-error').removeClass('hidden');
			return false;
		} else { 
			$('.chk-error').addClass('hidden'); 
		}

		$.ajax({
			url: 'delete_script.php',
			type: 'POST',
			data: {scripts: data},
		})
		.done(function() {
			location.reload(true);
		})
		
	});
	$(document).on('click', '.delete-btn', function(event) {
		var del = '.'+$(this).attr('id');
		$(del).remove();
	});
	$(document).on('click', '#tbl-watchlist tr', function(event) {
		$(this).find('.mark-all input:checkbox').click();
		if($(this).find('.mark-all input:checkbox').is(":checked")){
			$(this).addClass("tr-changed-color"); 
		}else{
			$(this).removeClass("tr-changed-color");  
		}
	});
</script>