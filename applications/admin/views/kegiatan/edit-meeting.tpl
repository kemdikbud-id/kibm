{extends file='site_layout.tpl'}
{block name='content'}
	<h1 class="page-header">Edit Sesi Meeting</h1>

	<div class="row">
		<div class="col-lg-12">
			
			<form class="form-horizontal" method="post" action="{current_url()}" id="addMeetingForm">
				<fieldset>
					
					<!-- Static -->
					<div class="form-group">
						<label class="col-md-2 control-label" for="kegiatan">Kegiatan</label>  
						<div class="col-md-10">
							<p class="form-control-static">{$kegiatan->nama_program} {$kegiatan->tahun}</p>
						</div>
					</div>
						
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="topik">Topik</label>  
						<div class="col-md-10">
							<input id="topik" name="topik" placeholder="" class="form-control input-md" type="text" value="{$data->topik}">
						</div>
					</div>
					
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="pemateri">Pemateri</label>  
						<div class="col-md-4">
							<input id="pemateri" name="pemateri" placeholder="" class="form-control input-md" type="text" value="{$data->pemateri}">
						</div>
					</div>
					
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="waktu_mulai">Waktu Meeting</label>  
						<div class="col-md-5">
							{html_select_date field_order="DMY" prefix="waktu_mulai_" 
								time=$data->waktu_mulai year_as_text=TRUE
								all_extra='class="form-control input-md" style="display: inline-block; width: auto;"'}
							<input type="text" name="waktu_mulai_time" value="{$data->waktu_mulai|date_format:"%H:%M:%S"}" placeholder="00:00:00" class="form-control input-md" style="display: inline-block; width: 85px" />
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="meeting_url">Meeting URL</label>  
						<div class="col-md-4">
							<input id="meeting_url" name="meeting_url" placeholder="" class="form-control input-md" type="text" value="{$data->meeting_url}">
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="meeting_password">Password</label>  
						<div class="col-md-3">
							<input id="meeting_password" name="meeting_password" placeholder="" class="form-control input-md" type="text" value="{$data->meeting_password}">
						</div>
					</div>
						
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="youtube_url">Youtube URL</label>  
						<div class="col-md-4">
							<input id="youtube_url" name="youtube_url" placeholder="" class="form-control input-md" type="text" value="{$data->youtube_url}">
						</div>
					</div>
						
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="tgl_awal_registrasi">Awal Registrasi</label>
						<div class="col-md-5">
							{html_select_date field_order="DMY" prefix="awal_registrasi_" 
								time=$data->tgl_awal_registrasi year_as_text=TRUE
								all_extra='class="form-control input-md" style="display: inline-block; width: auto;"'}
							<input type="text" name="awal_registrasi_time" value="{$data->tgl_awal_registrasi|date_format:'%H:%M:%S'}" placeholder="00:00:00" class="form-control input-md" style="display: inline-block; width: 85px" />
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="tgl_akhir_registrasi">Akhir Registrasi</label>
						<div class="col-md-5">
							{html_select_date field_order="DMY" prefix="akhir_registrasi_" 
								time=$data->tgl_akhir_registrasi year_as_text=TRUE
								all_extra='class="form-control input-md" style="display: inline-block; width: auto;"'}
							<input type="text" name="akhir_registrasi_time" value="{$data->tgl_akhir_registrasi|date_format:'%H:%M:%S'}" placeholder="00:00:00" class="form-control input-md" style="display: inline-block; width: 85px" />
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="kode_kehadiran">Kode Kehadiran</label>  
						<div class="col-md-2">
							<input id="kode_kehadiran" name="kode_kehadiran" placeholder="" class="form-control input-md" type="text" value="{$data->kode_kehadiran}" maxlength="5">
						</div>
					</div>
						
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="batas_presensi">Batas Presensi</label>
						<div class="col-md-5">
							{html_select_date field_order="DMY" prefix="batas_presensi_" 
								day_empty='' month_empty='' 
								time=$data->batas_presensi year_as_text=TRUE
								all_extra='class="form-control input-md" style="display: inline-block; width: auto;"'}
							<input type="text" name="batas_presensi_time" value="{if $data->batas_presensi}{$data->batas_presensi|date_format:'%H:%M:%S'}{/if}" placeholder="00:00:00" class="form-control input-md" style="display: inline-block; width: 85px" />
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="kapasitas">Kapasitas</label>  
						<div class="col-md-2">
							<input id="kapasitas" name="kapasitas" placeholder="" class="form-control input-md" type="number" value="{$data->kapasitas}">
						</div>
					</div>
							
					<!-- Button -->
					<div class="form-group">
						<label class="col-md-2 control-label" for="singlebutton"></label>
						<div class="col-md-4">
							<a href="{site_url('kegiatan/meeting')}?kegiatan_id={$data->kegiatan_id}" class="btn btn-default">Kembali</a>
							<input type="submit" value="Simpan" class="btn btn-primary"/>
							<input type="hidden" name="kegiatan_id" value="{$data->kegiatan_id}" />
						</div>
					</div>
						
				</fieldset>
			</form>
			
		</div>
	</div>
{/block}