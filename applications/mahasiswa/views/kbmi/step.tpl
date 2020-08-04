{extends file='site_layout.tpl'}

{block name='content'}
	<div class="panel panel-default">
		<div class="panel-body">
			
			<form action="{current_url()}" method="post" class="form-horizontal" enctype="multipart/form-data">
				<input type="hidden" name="isian_ke" value="{$step}" />
				
				<fieldset>
					<legend class="text-center"><h2>{if $isian}{$isian->kelompok_isian->kelompok_isian}{/if}</h2></legend>

					{if $isian}
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label" for="isian" style="text-align: left">
									{$isian->judul_isian}
								</label>
								{if $isian->jenis == 'text'}
									<input type="text" class="form-control" name="isian" required
										   placeholder="{if $isian->placeholder}{$isian->placeholder}{/if}"
										   value="{$isian_proposal->isian|htmlspecialchars}" />
								{/if}
								{if $isian->jenis == 'textarea'}
									<textarea class="form-control" name="isian" rows="5"
											  required>{$isian_proposal->isian|htmlspecialchars}</textarea>
								{/if}
								{if $isian->jenis == 'radio'}
									{foreach explode('|', $isian->radio_options) as $radio_option}
										<div class="radio">
											<label>
												<input type="radio" name="isian" required value="{$radio_option}"
													   {if $radio_option == $isian_proposal->isian}checked{/if}> {$radio_option}
											</label>
										</div>
									{/foreach}
								{/if}
								{if $isian->jenis == 'richtext'}
									<textarea class="form-control" name="isian" rows="5" id="richtext"
											  required>{$isian_proposal->isian}</textarea>
								{/if}
							</div>
						</div>

						{if $isian->jenis == 'richtext' && $isian->is_uploadable}
							<div class="form-group" {if $isian_proposal->nama_file != ''}style="display: none"{/if}>
								<div class="col-lg-6">
									<label class="control-label" for="file">Upload (Filetype: {$isian->allowed_types} Maks. {$isian->max_size}MB)</label>
									<div class="input-group">
										<input type="hidden" name="is_upload" value="0" />
										<input type="file" class="form-control" name="file" />
										<span class="input-group-btn">
											<input type="submit" class="btn btn-primary" name="tombol" value="Upload" />
										</span>
									</div>
									{if $upload_error}
										<span class="help-block">{$upload_error}</span>
									{/if}
								</div>
							</div>
							<div class="form-group" {if $isian_proposal->nama_file == ''}style="display: none"{/if}>
								<div class="col-lg-6">
									<label class="control-label" for="file">Upload (Filetype: {$isian->allowed_types} Maks. {$isian->max_size}MB)</label>
									<p class="form-control-static">
										<a href="{base_url('../upload/isian/')}{$isian_proposal->proposal_id}/{$isian_proposal->nama_file}">{$isian_proposal->nama_asli}</a>
										<button type="submit" class="btn btn-sm btn-default" name="tombol" value="Change Upload">Ganti</button>
									</p>
								</div>
							</div>
						{/if}
					{/if}

					{if $isian->jenis == 'richtext'}
						<div class="row">
							<div class="col-lg-12">
								<p>Pengisian proposal boleh ditulis di dalam kotak text saja atau upload file saja, dan boleh kedua-duanya</p>
							</div>
						</div>
					{/if}

					<div class="form-group">
						<div class="col-lg-6">
							<input type="submit" class="btn btn-primary" name="tombol" value="Sebelumnya" />
						</div>
						<div class="col-lg-6 text-right">
							<input type="submit" class="btn btn-primary" name="tombol" value="Berikutnya" />
						</div>
					</div>

					{if $proposal->is_submited}
						<div class="row">
							<div class="col-lg-12">
								<p class="text-danger text-center">Proposal sudah disubmit, perubahan tidak akan disimpan dalam sistem.</p>
							</div>
						</div>
					{/if}
					
				</fieldset>
				
			</form>
			
		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src='{base_url('../assets/js/jquery.validate.min.js')}' type='text/javascript'></script>
	{if ENVIRONMENT == 'development'}
		<script src="{base_url('../vendor/ckeditor/ckeditor/ckeditor.js')}"></script>
		<script src="{base_url('../vendor/ckeditor/ckeditor/adapters/jquery.js')}"></script>
	{/if}
	{if ENVIRONMENT == 'production'}
		<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
		<script src="https://cdn.ckeditor.com/4.14.1/standard/adapters/jquery.js"></script>
	{/if}
	<script type='text/javascript'>
		$(document).ready(function() {
			$('#richtext').ckeditor();
			$('form').validate();
		});
	</script>
{/block}
