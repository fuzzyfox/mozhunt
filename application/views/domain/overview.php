<section>
	<h1>Domain overview</h1>
	<p>You currently have <?php echo $domainCount; ?> of <?php echo $maxDomainCount; ?>
	domains.</p>
	<?php if($domainCount > 0): ?>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>URL</th>
				<th>API Key</th>
				<th>Atatus</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($domains as $domain): ?>
			<tr>
				<td><?php echo $domain['url']; ?></td>
				<td><?php echo $domain['apiKey']; ?></td>
				<td><?php echo $domain['domainStatus']; ?></td>
				<td>
					<a href="domain/view" class="btn"><i class="icon-eye-open"></i> View</a>
					<a href="domain/delete" class="btn btn-danger"><i class="icon-remove icon-white"></i> Delete</a>
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