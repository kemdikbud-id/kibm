{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('../assets/css/dataTables.bootstrap.min.css')}" />
{/block}
{block name='content'}
	<h1 class="page-header">Daftar Program Studi <small>{$pt->nama_pt}</small></h1>

	<div class="row">
		<div class="col-lg-12">
			<p><a href="{site_url('pt')}">Kembali ke Daftar Pergruan Tinggi</a></p>
			<table id="table" class="table table-bordered table-condensed table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>Kode</th>
						<th>Program Studi</th>
						<th>Data Terupdate</th>
					</tr>
				</thead>
				<tbody>
					{foreach $prodi_set as $prodi}
						<tr>
							<td>{$prodi@index + 1}</td>
							<td>{$prodi->kode_prodi}</td>
							<td>{$prodi->nama}</td>
							<td>
								{if $prodi->updated_at == null}
									{$prodi->created_at}
								{else}
									{$prodi->updated_at}
								{/if}
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</div>
{/block}