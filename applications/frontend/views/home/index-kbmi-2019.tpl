{extends file='site_layout.tpl'}
{block name='content'}
	<h2 class="page-header">Program Kompetisi Bisnis Mahasiswa Indonesia (KBMI)</h2>
    <div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<p>
						Perubahan program KBMI tahun 2019:
					</p>
					<ul>
						<li>Operator Perguruan Tinggi hanya perlu membuatkan login untuk mahasiswa melalui halaman Usulan Proposal</li>
						<li>Mahasiswa akan melengkapi secara mandiri isian proposal</li>
						<li>Mahasiswa diwajibkan mengupload lembar pengesahan yang sudah di tanda tangani dan di cap resmi</li>
					</ul>
				</div>
			</div>
			<p>
				<a href="{site_url('proposal-kbmi')}" class="btn btn-primary">Usulan Proposal</a>
			</p>
		</div>
	</div>
{/block}