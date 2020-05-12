{extends file='site_layout.tpl'}
{block name='content'}
	<div class="row">
		<div class="col-lg-12">
			
			<h2 class="page-header">Program Online Workshop <small>Tahun {if $kegiatan}{$kegiatan->tahun}{/if}</small></h2>
			
			<div class="row">
				<div class="col-lg-8 col-md-10">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4>Apakah Anda akan mendaftar Workshop Online berikut ini ?</h4>
							<form method="post" action="{current_url()}">
								<label for="topik">Topik</label>
								<p class="form-control-static">{$meeting->topik}</p>
							</form>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
{/block}