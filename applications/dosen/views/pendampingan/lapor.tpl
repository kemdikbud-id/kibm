{extends file='site_layout.tpl'}
{block name='content'}
	<h2 class="page-header">Pelaporan Pendampingan</h2>

	<div class="row">
		<div class="col-lg-12">
			{if $ci->session->flashdata('success')}
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Data berhasil disimpan!</strong>
				</div>
			{/if}
			{if $ci->session->flashdata('hapus_attachment_success')}
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>File attachment berhasil dihapus!</strong>
				</div>
			{/if}
			<form action="{current_url()}" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<input type="text" class="form-control" readonly value="{$proposal->judul}"/>
				</div>
				<h4>
					Pelaporan Kegiatan Pendampingan {$tahapan_pendampingan->nama_tahapan}
					({$tahapan_pendampingan->tgl_awal_laporan|date_format:"%d %B %Y %R"} s/d
					{$tahapan_pendampingan->tgl_akhir_laporan|date_format:"%d %B %Y %R"})
				</h4>
				<div class="form-group">
					<textarea class="form-control" rows="10" name="laporan"
							  placeholder="Isikan keterangan tentang pendampingan kegiatan bisnis mahasiswa">{$laporan_pendampingan->laporan}</textarea>
				</div>
				<h4>Bukti / Dokumentasi (jenis file pdf)</h4>
				{if $laporan_pendampingan->attachment_nama_file == ''}
					{if $ci->session->flashdata('upload_error_msg')}
						<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							{$ci->session->flashdata('upload_error_msg')}
						</div>
					{/if}
					<div class="form-group">
						<input type="file" name="file" class="form-control"/>
					</div>
				{else}
					<div class="form-group">
						<p class="form-control-static">
							<a href="{site_url('../upload/laporan-pendampingan')}/{$laporan_pendampingan->attachment_nama_file}">
								{$laporan_pendampingan->attachment_nama_asli}
							</a>
							<a href="{site_url('pendampingan/hapus-attachment')}/{$laporan_pendampingan->tahapan_pendampingan_id}/{$proposal->id}" class="btn btn-xs btn-danger">
								<i class="glyphicon glyphicon-remove"></i>
							</a>
						</p>
					</div>
				{/if}
				<div class="form-group">
					<a href="{site_url('pendampingan')}" class="btn btn-default">Kembali</a>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</form>
		</div>
	</div>
{/block}
