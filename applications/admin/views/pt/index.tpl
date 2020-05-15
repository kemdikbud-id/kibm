{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('../assets/css/dataTables.bootstrap.min.css')}" />
{/block}
{block name='content'}
	<h1 class="page-header">Daftar Perguruan Tinggi</h1>
	
	<div class="row">
		<div class="col-lg-12">
			<table id="table" class="table table-bordered table-condensed table-striped">
				<thead>
					<tr>
						<th>Kode</th>
						<th>Perguruan Tinggi</th>
						<th class="text-center">Program Studi</th>
						<th>Email</th>
						<th></th>
					</tr>
				</thead>
				<tbody></tbody>
				<tfoot>
					<tr>
						<td colspan="5" class="text-right">
							<input id="txtKodePT" type="text" class="form-control input-sm" style="width: 100px" placeholder="Kode PT" />
							<a id="btnSinkron" class="btn btn-success btn-sm" href="javascript: sinkron();">Sinkron PT</a>
							<span id="lblStatusSinkron" class="text-danger" style="display:none"></span>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src="{base_url('../assets/js/jquery.dataTables.min.js')}"></script>
	<script src="{base_url('../assets/js/dataTables.bootstrap.min.js')}"></script>
	<script>
		var tabelDT;
		
		$(document).ready(function() {
			tabelDT = $('#table').DataTable({
				ajax: '{site_url('pt/data-pt-all')}',
				columns: [
					{ data: 'npsn' },
					{ data: 'nama_pt' },
					{
						data: 'id', orderable: false,
						render: function(data, type, row, meta) {
							if (type === 'display') {
								return '<a href="{site_url('pt/program-studi/')}' + row.id + '" class="">' + row.jumlah_prodi + '</a>';
							}
							else {
								return data;
							}
						},
						createdCell: function(cell) {
							$(cell).addClass('text-center');
						}
					},
					{ data: 'email_pt' },
					{ 
						data: 'id', orderable: false,
						render: function(data, type) {
							if (type === 'display') {
								return '<a href="{site_url('pt/update')}/' + data + '" class="btn btn-xs btn-default">Edit</a>';
							}
							else {
								return data;
							}
						}
					}
				],
				stateSave: true
			});
		});
		
		function sinkron() {
			$('#btnSinkron').addClass('disabled');
			$('#txtKodePT').prop('disabled', true);
			$('#lblStatusSinkron')
				.html('Proses sinkronisasi ...')
				.removeClass().addClass('text-info')
				.show();
			
			var kode_pt = $('#txtKodePT').val();
			
			$.post('{site_url('pt/sinkronisasi')}', { kode_pt: kode_pt }, function(data) {
				if (data === true) {
					$('#lblStatusSinkron')
						.html('Sukses')
						.removeClass().addClass('text-success')
						.fadeOut(3000);
					tabelDT.ajax.reload();
				}
				else {
					$('#lblStatusSinkron')
						.html('Gagal')
						.removeClass().addClass('text-danger');
				}
				$('#btnSinkron').removeClass('disabled');
				$('#txtKodePT').prop('disabled', false);
			}).fail(function() {
				$('#lblStatusSinkron')
					.html('Gagal')
					.removeClass().addClass('text-danger');
				$('#btnSinkron').removeClass('disabled');
				$('#txtKodePT').prop('disabled', false);
			});
		}
	</script>
{/block}