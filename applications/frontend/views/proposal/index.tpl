{extends file='site_layout.tpl'}
{block name='head'}
	<style>.table { font-size: 14px; }</style>
{/block}
{block name='content'}
	<h2 class="page-header">Daftar Proposal {if $ci->session->program_id == 1}PBBT{else}KIBM{/if}</h2>
	<div class="row">
		<div class="col-lg-12">

			<table class="table table-bordered table-striped table-hover table-condensed">
				<thead>
					<tr>
						<th>#</th>
						<th>Judul</th>
						<th>Kategori</th>
						<th>Anggota</th>
						<th>Kelengkapan Syarat</th>
						<th style="width: 120px">Aksi</th>
						<th style="width: 78px;">Proses</th>
					</tr>
				</thead>
				<tbody>
					{foreach $data_set as $data}
						<tr>
							<td>{$data@index + 1}</td>
							<td>{$data->judul}</td>
							<td>{$data->nama_kategori}</td>
							<td>{$data->nama_ketua} ({$data->nim_ketua})</td>
							<td>
								{if $data->jumlah_syarat == $data->syarat_terupload}
									<span class="label label-success">LENGKAP</span>
								{else}
									<span class="label label-warning">BELUM LENGKAP</span>
								{/if}
							</td>
							<td>
								{if $data->tp_id == ''}
									<a href="{site_url("proposal/update/{$data->id}")}" class="btn btn-sm btn-default">Edit</a>
									<a href="{site_url("proposal/delete/{$data->id}")}" class="btn btn-sm btn-danger">Hapus</a>
								{/if}
							</td>
							<td>
								{if $data->tp_id == ''}
									<a href="{site_url("proposal/submit/{$data->id}")}" class="btn btn-sm btn-success">Submit</a>
								{else}
									<span class="label label-info">Evaluasi Proposal</span>
								{/if}
							</td>
						</tr>
					{foreachelse}
						<tr>
							<td colspan="7">Tidak ada data ditemukan</td>
						</tr>
					{/foreach}
				</tbody>
				<tfoot>
				<tr>
					<td colspan="7">
						<a href="{site_url('proposal/create')}" class="btn btn-primary"><i class=""></i> Usulan Baru</a>
					</td>
				</tr>
				</tfoot>
			</table>

		</div>
	</div>
{/block}
