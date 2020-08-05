{extends file='site_layout.tpl'}
{block name='content'}
	<div class="panel panel-default">
		<div class="panel-body">
			
			<form action="{current_url()}" method="post" enctype="multipart/form-data">
				
				<fieldset>
					<legend class="text-center"><h2>Unggah Berkas Pendukung</h2></legend>
					
					{foreach $syarat_set as $syarat}
						
						{if $syarat->is_aktif}
							
							<div class="form-group fg-upload-{$syarat->id} {if isset($syarat->upload_error_msg)}has-error{/if}" 
								 {if $syarat->file_proposal_id != ''}style="display: none"{/if}>
								<label class="control-label">{$syarat->syarat} {if $syarat->is_wajib}(Wajib){/if}</label>
								<input type="file" name="file_syarat_{$syarat->id}" class="filestyle" />
								<span class="help-block">{$syarat->keterangan} ({$syarat->allowed_types}) - Maks. {$syarat->max_size}MB</span>
								{if isset($syarat->upload_error_msg)}
									<span class="help-block">ERROR: {$syarat->upload_error_msg}</span>
								{/if}
							</div>

							<div class="form-group fg-view-{$syarat->id}" {if $syarat->file_proposal_id == ''}style="display: none"{/if}>
								<label class="control-label">{$syarat->syarat} {if $syarat->is_wajib}(Wajib){/if}</label>
								<p class="form-control-static">
									<a href="{base_url()}/../../upload/lampiran/{$syarat->nama_file}" target="_blank">{$syarat->nama_file}</a>
									
									{if $proposal->is_submited == FALSE}
										<a class="btn btn-xs btn-default btn-edit" data-id="{$syarat->id}" title="Ubah file"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
									{/if}
								</p>
								<span class="help-block">{$syarat->keterangan}</span>
							</div>

							<hr/>

						{/if}
						
					{/foreach}
					
					<div class="form-group">
						<div class="col-lg-5">
							<input type="submit" class="btn btn-primary" name="tombol" value="Sebelumnya" />
						</div>
						<div class="col-lg-2 text-center">
							{if $proposal->is_submited == FALSE}
								<input type="submit" class="btn btn-info" name="tombol" value="Unggah" />
							{/if}
						</div>
						<div class="col-lg-5 text-right">
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
	<script src="{base_url('../assets/js/bootstrap-filestyle.min.js')}" type='text/javascript'></script>
	<script type="text/javascript">
		$(':file').filestyle();
		
		$('.btn-edit').on('click', function() {
			var syarat_id = $(this).data('id');
			
			$('.fg-view-' + syarat_id).hide();
			$('.fg-upload-' + syarat_id).show();
			
		});
	</script>
{/block}
