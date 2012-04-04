<section>
	<h1>Domain overview</h1>
	<p>You currently have <?php echo $domainCount; ?> of <?php echo $maxDomainCount; ?>
	domains.</p>
	<?php if($domainCount > 0): ?>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>URL</th>
				<th>API Authentication</th>
				<th>Atatus</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($domains as $domain): ?>
			<tr>
				<td><?php echo $domain['url']; ?></td>
				<td>
					<dl class="dl-horizontal">
						<dt>API Key</dt>
						<dd><?php echo $domain['apiKey']; ?></dd>
						<dt>API Secret</dt>
						<dd><?php echo $domain['apiSecret']; ?></dd>
					</dl>
				</td>
				<td><?php echo $this->domain_model->getHumanStatus($domain['domainStatus']); ?></td>
				<td>
					<a href="domain/view/<?php echo $domain['domainID']; ?>" class="btn"><i class="icon-eye-open"></i> View</a>
					<?php if($domain['domainStatus'] == 2): ?>
					<a href="domain/verify/<?php echo $domain['domainID']; ?>" class="btn btn-success"><i class="icon-ok icon-white"></i> Verify</a>
					<?php endif; ?>
					<a href="domain/delete/<?php echo $domain['domainID']; ?>" class="btn btn-danger"><i class="icon-remove icon-white"></i> Delete</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php endif; ?>
	<?php if($domainCount < $maxDomainCount): ?>
	<a href="domain/create" class="btn btn-primary">Create new domain</a>
	<?php endif; ?>
</section>