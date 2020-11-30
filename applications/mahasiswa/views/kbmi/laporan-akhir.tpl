{extends file='site_layout.tpl'}
{block name='content'}
	<div class="panel panel-default">
		<div class="panel-body">

			<h2 class="page-header">Upload Laporan Akhir</h2>

			<h5>Batas waktu upload laporan akhir mulai <strong>{$kegiatan->tgl_awal_laporan_akhir_dmy}</strong>
				sampai <strong>{$kegiatan->tgl_akhir_laporan_akhir_dmy}</strong>
			</h5>

			{if isset($syarat->upload_error_msg)}
				<div class="alert alert-danger">
					<p>{$syarat->upload_error_msg}</p>
				</div>
			{/if}

			<form action="{current_url()}?id={$proposal->id}" method="post" enctype="multipart/form-data">

				<fieldset>

					<div class="form-group">
						<label class="control-label">Judul</label>
						<p class="form-control-static">{$proposal->judul}</p>
					</div>

					<div class="form-group" style="{if $syarat->fp_id != ''}display: none{/if}" id="fg-upload">
						<label class="control-label">File Laporan Akhir</label>
						<input type="file" name="file_syarat_{$syarat->id}" class="filestyle" />
						{if $syarat->fp_id != ''}
							<a href="#" class="btn btn-xs btn-default btn-cancel-edit">Batal Edit</a>
						{/if}
					</div>

					<div class="form-group" style="{if $syarat->fp_id == ''}display: none{/if}" id="fg-view">
						<label class="control-label">File Laporan Akhir</label>
						<p class="form-control-static" style="{if $syarat->fp_id == ''}display: none{/if}">
							<a href="{site_url('upload/laporan-kemajuan')}/{$syarat->nama_file}">{$syarat->nama_asli}</a>
							{if $kegiatan->in_jadwal}
								<a href="#" class="btn btn-xs btn-success btn-edit">Edit</a>
							{/if}
						</p>
					</div>

					<div class="form-group">
						<a href="{site_url('home')}" class="btn btn-default">Kembali</a>
						{if $kegiatan->in_jadwal}
							<input type="submit" value="Simpan" class="btn btn-primary" />
						{/if}
					</div>

				</fieldset>

			</form>

		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src="{base_url('../assets/js/bootstrap-filestyle.min.js')}" type='text/javascript'></script>
	<script type="text/javascript">
		$(':file').filestyle();
		$('.btn-edit').on('click', function() {
			$('#fg-upload').show();
			$('#fg-view').hide();
		});
		$('.btn-cancel-edit').on('click', function() {
			$('#fg-upload').hide();
			$('#fg-view').show();
		});
	</script>
{/block}
