{extends file='site_layout.tpl'}
{block name='content'}
	<h2 class="page-header">Edit Proposal</h2>
	<div class="row">
		<div class="col-lg-12">

			<form action="{current_url()}" method="post" class="form-horizontal">
				<input type="hidden" name="proposal_id" value="{$proposal->id}" />
				<input type="hidden" name="mahasiswa_id" value="{$mahasiswa->id}" />
				<fieldset>
					<legend>Identitas</legend>

					<div class="form-group">
						<label class="col-lg-2 control-label">Nama</label>
						<div class="col-lg-3">
							<p class="form-control-static">{$mahasiswa->nama}</p>
						</div>
						<label class="col-lg-2 control-label">Program Studi</label>
						<div class="col-lg-3">
							<p class="form-control-static">{$mahasiswa->program_studi->nama}</p>
						</div>
						<label class="col-lg-1 control-label">Angkatan</label>
						<div class="col-lg-1">
							<p class="form-control-static">{$mahasiswa->angkatan}</p>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Email</label>
						<div class="col-lg-3">
							<input type="email" name="email" class="form-control" value="{$mahasiswa->email}" required />
						</div>
						<label class="col-lg-2 control-label">No HP</label>
						<div class="col-lg-3">
							<input type="text" name="no_hp" class="form-control" value="{$mahasiswa->no_hp}" required />
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Nama (Calon) Perusahaan</label>
						<div class="col-lg-10">
							{if $proposal->is_submited or $proposal->is_reviewed}
								<p class="form-control-static">{$proposal->judul}</p>
							{else}
								<input type="text" name="judul" class="form-control" placeholder="Nama (Calon) Perusahaan atau nama usaha atau nama produk yang diusulkan" required value="{$proposal->judul}"/>
							{/if}
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Status Disabilitas</label>
						<div class="col-lg-2">
							<select name="is_disabilitas" class="form-control">
								<option value="0" {if $mahasiswa->is_disabilitas == 0}selected{/if}>Tidak</option>
								<option value="1" {if $mahasiswa->is_disabilitas == 1}selected{/if}>Ya</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-lg-offset-2 col-lg-4">
							<a href="{site_url('proposal-kbmi/index')}" class="btn btn-default">Kembali</a>
							<button class="btn btn-success">Simpan</button>
						</div>
					</div>

				</fieldset>
				<fieldset>
					<legend>Login</legend>
					
					<div class="form-group">
						<label class="col-lg-2 control-label">Username</label>
						<div class="col-lg-3">
							<input type="text" class="form-control" readonly value="{$user_mahasiswa->username}" />
						</div>
					</div>
						
					<div class="form-group">
						<label class="col-lg-2 control-label">Password</label>
						<div class="col-lg-3">
							<input type="text" class="form-control" readonly value="{$user_mahasiswa->password}" />
						</div>
					</div>
					
				</fieldset>
			</form>

		</div>
	</div>
{/block}
