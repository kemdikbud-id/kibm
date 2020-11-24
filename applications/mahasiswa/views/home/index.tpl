{extends file='site_layout.tpl'}
{block name='content'}
	<div class="row">
		<div class="col-lg-12">

			<h2>Selamat datang, {$ci->session->user->mahasiswa->nama}</h2>

			<h3>Program KIBM (<span class="text-warning">{$jenis_program}</span>)</h3>
			{if $kegiatan_kbmi != NULL}
				<p>Program Berjalan : {$kegiatan_kbmi->tahun}.
					Mulai unggah <strong>{strftime('%d %B %Y %H:%M:%S', strtotime($kegiatan_kbmi->tgl_awal_upload))}</strong>
					sampai <strong>{strftime('%d %B %Y %H:%M:%S', strtotime($kegiatan_kbmi->tgl_akhir_upload))}</strong></p>
			{/if}
			<div class="panel panel-default">
				<div class="panel-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th style="width: 1%">Tahun</th>
								<th>Judul</th>
								<th class="text-center">Kelengkapan Isian</th>
								<th class="text-center">Berkas Lampiran</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							{foreach $proposal_kbmi_set as $proposal_kbmi}
								<tr>
									<td>{$proposal_kbmi->tahun}</td>
									<td>{$proposal_kbmi->judul|htmlentities}</td>
									<td class="text-center"><span class="badge">{$proposal_kbmi->isian_proposal}</span> dari <span class="badge">{$proposal_kbmi->jumlah_isian}</span></td>
									<td class="text-center"><span class="badge">{$proposal_kbmi->jumlah_upload}</span></td>
									<td>
										{if $proposal_kbmi->is_submited}
											{if $proposal_kbmi->is_didanai}
												<span class="label label-info">Didanai</span>
											{else}
												<span class="label label-success">Sudah Submit</span>
											{/if}
										{else}
											<span class="label label-default">Belum Submit</span>
										{/if}
									</td>
									<td>
										{* Tampilkan tombol jika tahun sesuai dengan yg aktif *}
										{if $kegiatan_kbmi != NULL}
											{if $kegiatan_kbmi->tahun == $proposal_kbmi->tahun}
												<a href="{site_url('kbmi/identitas')}" class="btn btn-primary btn-xs">
													Identitas
												</a>
												<a href="{site_url('kbmi/step/1')}" class="btn btn-primary btn-xs">
													Isian Proposal
												</a>
												<a href="{site_url('kbmi/upload')}" class="btn btn-primary btn-xs">
													Berkas Pendukung
												</a>
											{/if}
										{/if}
									</td>
								</tr>
							{foreachelse}
								<tr>
									<td colspan="5"><i>Tidak ada judul terdaftar</i></td>
								</tr>
							{/foreach}
						</tbody>
					</table>
				</div>
			</div>
			
		</div>
	</div>
{/block}
