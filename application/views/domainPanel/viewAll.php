<h1>You have <?php echo $numDomains; ?> domains</h1>

<?php foreach($domains as $domain) { ?>
<div>
    <h1><?php echo htmlentities($domain['url']); ?></h1>
    <p><?php echo $domain['manageLink']; ?><br/>
        <?php echo $domain['viewLink']; ?></p>
</div>
<?php } ?>
