<h1>Eingetragene Nutzer des Verteilers</h1>
<?php if (isset($this->_["entries"])) ?>
<table>
	<tr>
		<th>Nachname</th>
		<th>Vorname</th>
		<th>Email-Adresse</th>
		<th>Eingetragen am</th>
	</tr>
	<?php foreach ($this->_["entries"] as $entry) { ?>
	<tr>
		<td><?php echo $entry["nachname"]; ?></td>
		<td><?php echo $entry["vorname"]; ?></td>
		<td><?php echo $entry["email"]; ?></td>
		<td><?php echo $entry["zeitstempel"]; ?></td>
	</tr>
	<?php } ?>
</table>
