{extends file='site_layout.tpl'}
{block name='content'}
	<h1 class="page-header">Jadwal Online Workshop</h1>

	<div class="row">
		<div class="col-lg-12">
			<form class="form-inline" action="{current_url()}" method="get" style="margin-bottom: 20px">
				<div class="form-group">
					<select name="kegiatan_id" class="form-control">
						<option value="">-- Pilih Kegiatan --</option>
						{foreach $kegiatan_set as $kegiatan}
							<option value="{$kegiatan->id}" {if !empty($smarty.get.kegiatan_id)}{if $smarty.get.kegiatan_id == $kegiatan->id}selected{/if}{/if}>{$kegiatan->nama_program} {$kegiatan->tahun}</option>
						{/foreach}
					</select>
				</div>
				<button type="submit" class="btn btn-default">
					Lihat
				</button>
			</form>
			{if !empty($smarty.get.kegiatan_id)}
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th>Topik</th>
						<th>Pemateri</th>
						<th>Waktu Pelaksanaan</th>
                        <th>Meeting / Youtube URL</th>
                        <th>Password</th>
						<th>Waktu Registrasi</th>
						<th>Kode Kehadiran</th>
                        <th>Batas Presensi</th>
                        <th>Kapasitas</th>
                        <th></th>
					</tr>
				</thead>
				<tbody>
					{foreach $meeting_set as $meeting}
						<tr>
							<td>{$meeting->topik}</td>
							<td>{$meeting->pemateri}</td>
                            <td>{$meeting->waktu_mulai|date_format:"%d %B %Y %T"}</td>
                            <td>
								<a href="{$meeting->meeting_url}">{$meeting->meeting_url}</a>
								{if $meeting->youtube_url != ''}
									<br/><a href="{$meeting->youtube_url}">{$meeting->youtube_url}</a>
								{/if}
							</td>
                            <td><code>{$meeting->meeting_password}</code></td>
							<td>
								{$meeting->tgl_awal_registrasi|date_format:"%d %b %Y %T"} - <br/>
								{$meeting->tgl_akhir_registrasi|date_format:"%d %b %Y %T"}
							</td>
                            <td class="text-center"><samp>{$meeting->kode_kehadiran}</samp></td>
							<td>
								{if $meeting->batas_presensi != null}
									{$meeting->batas_presensi|date_format:"%d %b %Y %T"}
								{/if}
							</td>
                            <td class="text-center">{$meeting->kapasitas}</td>
							<td>
								<a href="{site_url("kegiatan/edit-meeting/{$meeting->id}")}" class="btn btn-sm btn-default">Edit</a>
							</td>
						</tr>
					{foreachelse}
						<tr>
							<td colspan="11"><em>Tidak ada data</em></td>
						</tr>
					{/foreach}
					
				</tbody>
				<tfoot>
					<tr>
						<td colspan="11">
							<a href="{site_url('kegiatan/add-meeting/')}?kegiatan_id={$smarty.get.kegiatan_id}" class="btn btn-sm btn-success">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Meeting</a>
						</td>
					</tr>
				</tfoot>	
			</table>
			{/if}
		</div>
	</div>
{/block}