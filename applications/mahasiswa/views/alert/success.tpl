{extends file='site_layout.tpl'}
{block name='content'}
	{$result = $ci->session->flashdata('result')}
	<h2 class="page-header">{$result['page_title']}</h2>
	<div class="row">
		<div class="col-lg-12">
			
			{if $result['message']}
				<div class="alert alert-success" role="alert">
					<p>{$result['message']}</p>
					{if isset($result['link_1'])}<p>{$result['link_1']}</p>{/if}
					{if isset($result['link_2'])}<p>{$result['link_2']}</p>{/if}
				</div>
			{/if}
			
		</div>
	</div>
{/block}