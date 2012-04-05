<h1><?php echo $domain['url']; ?> <small><?php echo $this->domain_model->getHumanStatus($domain['domainStatus']); ?></small></h1>
<dl class="well dl-horizontal">
	<dt>API Key</dt>
	<dd><?php echo $domain['apiKey']; ?></dd>
	<dt>API Secret</dt>
	<dd><?php echo $domain['apiSecret']; ?></dd>
</dl>
<?php if($tokenCount > 0): ?>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>Clue</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($tokens as $token): ?>
			<tr>
				<td><?php echo $token['name']; ?></td>
				<td><?php echo $token['clue']; ?></td>
				<td><?php echo $this->token_model->getHumanStatus($token['tokenStatus']); ?></td>
				<td>
					
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php endif; ?>
	<?php if($tokenCount < $maxTokenCount): ?>
	<a href="domain/create" class="btn btn-primary">Create new domain</a>
	<?php endif; ?>
<a href="token/create/<?php echo $domain['domainID']; ?>" class="btn btn-primary">Add Token</a>