{extends file='site_layout.tpl'}
{block name='head'}
	<style>
		.jumbotron { background-color: transparent; padding: 16px 20px; }
		.jumbotron h1 { font-size: 46px; font-family: 'Source Sans Pro' }
		.btn-daftar { padding: 10px 15px; }
		h4 { font-weight: bold; }
		.btn { margin-top: 5px; }
	</style>
{/block}
{block name='content'}
	
	{if file_exists('applications/frontend/views/site/index_jumbotron.tpl')}
		{include file='site/index_jumbotron.tpl'}
	{/if}
	
	{if file_exists('applications/frontend/views/site/index_pengumuman.tpl')}
		{include file='site/index_pengumuman.tpl'}
	{/if}
	
	{if file_exists('applications/frontend/views/site/index_content.tpl')}
		{include file='site/index_content.tpl'}
	{/if}

{/block}
