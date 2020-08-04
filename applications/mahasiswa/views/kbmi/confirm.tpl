{extends file='site_layout.tpl'}
{block name='content'}
	<div class="panel panel-default">
		<div class="panel-body">
			
			<form action="{current_url()}" method="post" class="form-horizontal">
				
				<fieldset>
					<legend class="text-center"><h2>Pengisian Selesai</h2></legend>
					
					<p style="font-size: 18px">Selamat ! 
						Pada tahap ini ada sudah menyelesaikan semua isian yang diperlukan untuk pengajuan proposal.
						Pastikan anda mengisi semua isian yang diperlukan.
						Anda bisa memperbaiki isian selama belum di Submit termasuk mengganti file yang telah di upload.
						Jika proposal sudah disubmit maka isian proposal tidak akan bisa dirubah lagi.
					</p>

					<p>* Submit hanya bisa dilakukan oleh admin operator</p>
					
					{if isset($error_message)}
						<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							{$error_message}
						</div>
					{/if}
					
					{* Berbentuk array jika ada yang kurang lengkap *}
					{if is_array($kelengkapan)}
						
						<div class="alert alert-danger" role="alert">
							<p>Usulan belum bisa di submit karena : </p>
							<ul>
								{foreach $kelengkapan as $item}
									<li>{$item}</li>
								{/foreach}
							</ul>
						</div>
					{/if}
							
					<div class="form-group">
						<div class="col-lg-6">
							<input type="submit" class="btn btn-primary" name="tombol" value="Sebelumnya" />
						</div>
						<div class="col-lg-6 text-right">
							{if !is_array($kelengkapan)}
								<a href="{site_url()}" class="btn btn-success">Kembali ke Beranda</a>
							{/if}
						</div>
					</div>
					
				</fieldset>
				
			</form>
			
		</div>
	</div>
{/block}
