{extends file='site_layout.tpl'}
{block name='head'}
	<link rel="stylesheet" href="{base_url('assets/jquery-ui-1.12.1.custom/jquery-ui.min.css')}" />
{/block}
{block name='content'}
	<h2 class="page-header">Registrasi Akun KIBM untuk Mahasiswa</h2>
	<div class="row">
		<div class="col-md-12">

			{if isset($error)}
				<p>{$error['message']}</p>
			{/if}

			<form action="{current_url()}" method="post" class="form-horizontal" id="signupForm" enctype="multipart/form-data">

				<div class="form-group">
					<label class="col-md-3 control-label" for="perguruan_tinggi">Perguruan Tinggi</label>
					<div class="col-md-5">
						<input type='text' class="form-control input-md" name="perguruan_tinggi" value="" 
							   style="width: 85%; display: inline-block" placeholder="Kata kunci nama perguruan tinggi" />
						<a role="button" href="javascript: resetPT();" class="btn btn-default"><i class="glyphicon glyphicon-remove"></i></a>
						<input type="hidden" name="perguruan_tinggi_id" value=""/>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="program_studi">Program Studi</label>  
					<div class="col-md-5">
						<select name="program_studi_id" class="form-control" style="width: 100%" required>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="nim">NIM</label>  
					<div class="col-md-5">
						<input type='text' class="form-control input-md" style="width: 85%; display:inline-block" name="nim" required/>
						<a role="button" href="javascript: cariNIM();" class="btn btn-primary" id="btnCari">Cari</a>
					</div>
				</div>
				
				<div class="form-group" id="divAlert" style="display: none">
					<div class="col-md-5 col-md-offset-3">
						<div class="alert alert-warning" role="alert">
							<p id="labelAlert">Anda sudah pernah terdaftar. Silahkan klik Reset Password untuk mendapatkan login kembali.</p>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="nama">Nama Lengkap</label>  
					<div class="col-md-5">
						<input type='text' class="form-control input-md" name="nama" readonly/>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="angkatan">Angkatan</label>  
					<div class="col-md-2">
						<input type='text' class="form-control input-md" name="angkatan" maxlength="4" readonly />
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="email">Email</label>  
					<div class="col-md-5">
						<input type='email' class="form-control input-md" name="email" required/>
					</div>
				</div>

				<!-- Button -->
				<div class="form-group">
					<label class="col-md-3 control-label" for="singlebutton"></label>
					<div class="col-md-4">
						<button id="btnSignIn" name="submit" class="btn btn-primary" value="daftar">Daftar</button>
						<button id="btnResetPass" name="submit" class="btn btn-primary" value="reset-password" style="display: none">Reset Password</button>
						<a href="{site_url('auth/login')}" class="btn btn-default">Kembali ke Login</a>
					</div>
				</div>

			</form>

		</div>
	</div>
{/block}
{block name='footer-script'}
	<script src="{base_url('assets/jquery-ui-1.12.1.custom/jquery-ui.min.js')}" type="text/javascript"></script>
	<script src="{base_url('assets/js/bootstrap-filestyle.min.js')}" type='text/javascript'></script>
	<script src="{base_url('assets/js/jquery.validate.min.js')}" type="text/javascript"></script>
	<script type="text/javascript">
		
		function resetPT() {
			$('input[name="perguruan_tinggi_id"]').val(null);
			$('input[name="perguruan_tinggi"]')
				.prop('disabled', false)
				.val(null)
				.focus();
		}
		
		function loadProgramStudi() {
			$('select[name="program_studi_id"]').html(null);
			var ptID = $('input[name="perguruan_tinggi_id"]').val();
			$.getJSON('{site_url('auth/list-prodi/')}' + ptID, function(data) {
				$.each(data, function(i, item) {
					$('select[name="program_studi_id"]').append(
						'<option value="' + item.id + '">' + item.nama + '</option>'
					);
				});
			});
		}
		
		function cariNIM() {
			var ptID = $('input[name="perguruan_tinggi_id"]').val();
			var prodiID = $('select[name="program_studi_id"]').val();
			var nim = $('input[name="nim"]').val();
			$('#btnCari').addClass('disabled');
			$.getJSON(
				'{site_url('auth/cari-mahasiswa')}',
				{
					perguruan_tinggi_id: ptID,
					program_studi_id: prodiID,
					nim: nim
				}, function(data) {
					$('#btnCari').removeClass('disabled');
					if (data !== null) {
						$('input[name="nama"]').val(data.nama);
						$('input[name="angkatan"]').val(data.angkatan);

						if (data.has_login === false) {
							$('#divAlert').hide();
							$('input[name="email"]').val(null).prop('disabled', false);
							$('#btnSignIn').show();
							$('#btnResetPass').hide();
						}
						else {
							$('#divAlert').show();
							$('#labelAlert').html('Anda sudah pernah terdaftar. Silahkan klik Reset Password untuk mendapatkan login kembali.');
							$('input[name="email"]').val(data.email).prop('disabled', true);
							$('#btnSignIn').hide();
							$('#btnResetPass').show();
						}
					}
					else {
						$('input[name="nama"]').val(null);
						$('input[name="angkatan"]').val(null);
						$('input[name="email"]').val(null).prop('disabled', false);
						$('#divAlert').show();
						$('#labelAlert').html('Data mahasiswa tidak ditemukan. Silahkan ulangi pencarian.');
					}
				});
		}
		
		$(document).ready(function () {

			/* Autocomplete */
			$('input[name="perguruan_tinggi"]').autocomplete({
				source: '{site_url('auth/search_pt/')}',
				minLength: 6,
				select: function(event, ui) {
					$('input[name="perguruan_tinggi_id"]').val(ui.item.id);
					$(this).prop('disabled', true);
					loadProgramStudi();
				}
			});

			/* File Style */
			$(':file').filestyle();

			/* Validation */
			$('#signupForm').validate({
				rules: {
					perguruan_tinggi: "required",
					program_studi_id: "required",
					email: "required"
				},
				errorElement: "em",
				errorPlacement: function (error, element) {
					error.addClass("help-block");

					if (element.prop("type") === "checkbox") {
						error.insertAfter(element.parent("label"));
					}
					if (element.prop("type") === "radio") {
						element.parent().parent().append(error);
					} else {
						error.insertAfter(element);
					}
				},
				highlight: function (element, errorClass, validClass) {
					if ($(element).prop("type") === "radio") {
						$(element).parent().parent().addClass("has-error").removeClass("has-success");
					} else {
						$(element).parent().addClass("has-error").removeClass("has-success");
					}

				},
				unhighlight: function (element, errorClass, validClass) {
					if ($(element).prop("type") === "radio") {
						$(element).parent().parent().addClass("has-success").removeClass("has-error");
					} else {
						$(element).parent().addClass("has-success").removeClass("has-error");
					}
				}
			});
		});
	</script>
{/block}
