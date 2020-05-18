{extends file='site_layout.tpl'}
{block name='content'}
	<div class="row">
		<div class="col-lg-12">

			<h2>Selamat datang, {$ci->session->user->mahasiswa->nama}</h2>
			
			<h3>Online Workshop Peningkatan dan Pengembangan Kewirausahaan</h3>
			<div class="panel panel-default">
				<div class="panel-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Topik</th>
								<th>Pemateri</th>
								<th>Waktu</th>
								<th>Meeting URL</th>
								<th>Password Meeting</th>
								<th>Presensi</th>
							</tr>
						</thead>
						<tbody>
							{foreach $meeting_set as $meeting}
								<tr>
									<td>{$meeting->topik}</td>
									<td>{$meeting->pemateri}</td>
									<td>{$meeting->waktu_mulai|date_format:"%d %B %Y %T"}</td>
									{if is_null($meeting->is_terpilih_meeting)}
										<td colspan="2"></td>
									{else}
										{if $meeting->is_terpilih_meeting == 1}
											<td><a href="{$meeting->meeting_url}" target="_blank">{$meeting->meeting_url}</a></td>
											<td class="text-center"><code>{$meeting->meeting_password}</code></td>
										{elseif $meeting->is_terpilih_meeting == 0}
											<td colspan="2">
												<a href="{$meeting->youtube_url}" target="_blank">{$meeting->youtube_url}</a>
											</td>
										{/if}
									{/if}
									<td>
										{if $meeting->waktu_mulai < date('Y-m-d H:i:s')}
											{if $meeting->kehadiran == 0}
												<form action="{site_url('online-workshop/presensi')}" method="post">
													<input type="hidden" name="meeting_id" value="{$meeting->id}" />
													<input type='text' class='form-control input-sm' style='width: 100px' name='kode_kehadiran' placeholder='Kode presensi' />
													<button type='submit' class="btn btn-primary btn-sm">Simpan</button>
												</form>
											{else}
												<span class="label label-success">HADIR</span>
												{if $meeting->kuesioner_url != null}
													<br/><a href="{$meeting->kuesioner_url}">Isi Kuesioner</a>
												{/if}
											{/if}
										{/if}
									</td>
								</tr>
							{foreachelse}
								<tr>
									<td colspan="6"><i>Tidak ada data registrasi</i></td>
								</tr>
							{/foreach}
						</tbody>
					</table>
					<p>Informasi:<br/>
						<sup>1</sup> Waktu pelaksanaan menggunakan zona waktu WIB (Waktu Indonesia Barat).<br/>
						<sup>2</sup> Meeting URL akan muncul jika sudah diumumkan.<br/>
						<sup>3</sup> Harap mengisi kode presensi sebelum meeting selesai.
					</p>
				</div>
			</div>

			<h3>Program KBMI</h3>
			{if $kegiatan_kbmi != NULL}
				<p>Program Berjalan : {$kegiatan_kbmi->tahun}. Mulai unggah {$kegiatan_kbmi->tgl_awal_upload} sampai {$kegiatan_kbmi->tgl_akhir_upload}</p>
			{/if}
			<div class="panel panel-default">
				<div class="panel-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th style="width: 1%">Tahun</th>
								<th>Judul</th>
								<th>Status</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="4"><i>Tidak ada judul terdaftar</i></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<h3>Program Akselerasi Startup</h3>
			{if $kegiatan_startup != NULL}
				<p>Program Berjalan : {$kegiatan_startup->tahun}. Masa unggah: {$kegiatan_startup->tgl_awal_upload|date_format:"%d %B %Y %T"} sampai {$kegiatan_startup->tgl_akhir_upload|date_format:"%d %B %Y %T"}</p>
			{/if}
			<div class="panel panel-default">
				<div class="panel-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th style="width: 1%">Tahun</th>
								<th>Judul</th>
								<th>Pitchdeck</th>
								<th>Presentasi</th>
								<th>Produk</th>
								<th style="width: 1%;"></th>
							</tr>
						</thead>
						<tbody>
							{foreach $proposal_startup_set as $proposal_startup}
								<tr>
									<td>{$proposal_startup->tahun}</td>
									<td>{$proposal_startup->judul}</td>
									<td>
										{if $proposal_startup->file_pitchdeck != ''}
											<a href="{base_url()}../upload/lampiran/{$proposal_startup->file_pitchdeck}" target="_blank"><i class="glyphicon glyphicon-paperclip"></i></a>
											{else}
											<span class="label label-default">Belum Upload</span>
										{/if}
									</td>
									<td>
										{if $proposal_startup->link_presentasi != ''}
											<a href="{$proposal_startup->link_presentasi}" target="_blank"><i class="glyphicon glyphicon-film"></i></a>
											{else}
											<span class="label label-default">Belum Ada</span>
										{/if}
									</td>
									<td>
										{if $proposal_startup->link_produk != ''}
											<a href="{$proposal_startup->link_produk}" target="_blank"><i class="glyphicon glyphicon-new-window"></i></a>
											{else}
											<span class="label label-default">Belum Ada</span>
										{/if}
									</td>
									<td style="white-space: nowrap">
										<a href="{site_url('startup/update')}/{$proposal_startup->id}" class="btn btn-success">Unggah</a>
										{if $proposal_startup->is_submited == 0}
											<a href="{site_url('startup/submit')}/{$proposal_startup->id}" class="btn btn-primary">Submit</a>
										{/if}
									</td>
								</tr>
							{foreachelse}
								<tr>
									<td colspan="6"><i>Tidak ada judul terdaftar</i></td>
								</tr>
							{/foreach}
						</tbody>
					</table>
				</div>
			</div>

			
			
		</div>
	</div>
{/block}