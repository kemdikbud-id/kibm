{extends file='site_layout.tpl'}
{block name='content'}
	<h2 class="page-header">Pelaporan Pendampingan</h2>

	<div class="row">
		<div class="col-lg-12">
			<table class="table table-bordered table-striped">
				<thead>
				<tr>
					<th>No</th>
					<th>Nama Bisnis</th>
					<th>Ketua</th>
					{foreach $tahapan_pendampingan_set as $tp}
						<th class="text-center">
							{$tp->nama_tahapan}<br/>
							{$tp->tgl_awal_laporan|date_format:"%d %B %Y %R"} s/d<br/>
							{$tp->tgl_akhir_laporan|date_format:"%d %B %Y %R"}
						</th>
					{/foreach}
				</tr>
				</thead>
				<tbody>
				{foreach $proposal_set as $proposal}
					<tr>
						<td>{$proposal@index + 1}</td>
						<td>{$proposal->judul}</td>
						<td>{$proposal->nama}<br/>{$proposal->prodi}</td>
						{foreach $tahapan_pendampingan_set as $tp}
							<td class="text-center">
								{foreach $laporan_pendampingan_set as $lp}
									{if $lp->proposal_id == $proposal->id and $lp->tahapan_pendampingan_id == $tp->id}
										<label class="label label-success">SUDAH LAPORAN</label>
									{/if}
								{/foreach}
								{if $tp->is_waktu_pelaporan}
									<br/>
									<a href="{site_url('pendampingan/lapor')}/{$tp->id}/{$proposal->id}">Laporkan</a>
								{/if}
							</td>
						{/foreach}
					</tr>
				{/foreach}
				</tbody>
			</table>
		</div>
	</div>
{/block}
