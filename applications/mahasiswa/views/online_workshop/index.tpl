{extends file='site_layout.tpl'}
{block name='content'}
	<div class="row">
		<div class="col-lg-12">

			<h2 class="page-header">Program Online Workshop <small>Tahun {if $kegiatan}{$kegiatan->tahun}{/if}</small></h2>

			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Topik</th>
						<th>Pemateri</th>
						<th>Waktu Pelaksanaan</th>
                        <th>Meeting URL</th>
                        <th></th>
					</tr>
				</thead>
				<tbody>
					{foreach $meeting_set as $meeting}
						<tr>
							<td>{$meeting->topik}</td>
							<td>{$meeting->pemateri}</td>
                            <td>{$meeting->waktu_mulai|date_format:"%d %B %Y %T"}</td>
                            <td><a href="{$meeting->meeting_url}">{$meeting->meeting_url}</a></td>
							<td class="text-center">
								{if $meeting->mahasiswa_id == null}
									{if date('Y-m-d H:i:s') < $meeting->tgl_akhir_registrasi}
										<a href="{site_url("online-workshop/register/{$meeting->id}")}" class="btn btn-sm btn-default">Daftar</a>
									{else}
										<label class="label label-danger">PENDAFTARAN DITUTUP</label>
									{/if}
								{else}
									<label class="label label-primary">TERDAFTAR</label>
								{/if}
							</td>
						</tr>
					{foreachelse}
						<tr>
							<td colspan="5"><em>Tidak ada data jadwal online workshop</em></td>
						</tr>
					{/foreach}
				</tbody>	
			</table>
				
				<p>* Waktu pelaksanaan menggunakan zona waktu WIB (Waktu Indonesia Barat)</p>

		</div>
	</div>
{/block}