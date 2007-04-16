<?php
/* Hosting module -> $Id: $ */

global $AppUI;

$sort = $_GET['sort'];
switch($sort){
	case "DNA" : $orderBy = "domain_name ASC"; break;
	case "DND" : $orderBy = "domain_name DESC"; break;
	case "DEA" : $orderBy = "domain_expiry_date ASC"; break;
	case "DED" : $orderBy = "domain_expiry_date DESC"; break;
	case "HNA" : $orderBy = "domain_name ASC"; break;
	case "HND" : $orderBy = "domain_name DESC"; break;
	case "HPA" : $orderBy = "hosting_package_name ASC"; break;
	case "HPD" : $orderBy = "hosting_package_name DESC"; break;
	case "HEA" : $orderBy = "hosting_expiry_date ASC"; break;
	case "HED" : $orderBy = "hosting_expiry_date DESC"; break;
	default    : $orderBy = "domain_expiry_date ASC"; break;
}

// Forums mini-table in project view action

$q  = new DBQuery;
$q->addTable('domains');
$q->addQuery("domains.domain_id, company_id, domain_name, domain_expiry_date, domain_registrar, domain_status,
	domain_notes, hosting_id, hosting_package_name, hosting_expiry_date, hosting_status, hosting_notes");
$q->addJoin('hosting', 'h', 'h.domain_id = domains.domain_id');

if($AppUI->getState('HostIdxCompany') != null){
	if($AppUI->getState('HostIdxCompany') != "" || $AppUI->getState('HostIdxCompany') != 0 || $AppUI->getState('HostIdxCompany') != "0"){
		$q->addWhere('domains.company_id = '.$AppUI->getState('HostIdxCompany'));
	}
}

$q->addOrder($orderBy);
$results = $q->exec();
?>
<table width="100%" align="center" cellpadding="0" cellspacing="0" style="background-color: white; border-top: 2px solid #D4D0C8;">
	<tr>
		<th align="center" style="border-right: 1px solid #D4D0C8;">Domains</th>
		<th align="center">Hosting</th>
	</tr>
	<tr><td style="border-right: 1px solid #D4D0C8;"><br /></td></tr>
	<tr>
		<td style="border-right: 1px solid #D4D0C8;">
			<table width="90%" align="center" class="tbl">
				<tr>
					<th align="center" nowrap="nowrap" width="200" height="20"><a href="index.php?m=hosting&tab=0&sort=<?php if($sort == "DND") echo "DNA"; else echo "DND"; ?>" class="hdr"><?php echo $AppUI->_('Domain'); if($sort == "DND") echo " &or;"; elseif($sort == "DNA") echo " &and;"; ?></a></th>
					<th align="center" nowrap="nowrap" width="150" height="20"><a href="index.php?m=hosting&tab=0&sort=<?php if($sort == "DED") echo "DEA"; else echo "DED"; ?>" class="hdr"><?php echo $AppUI->_('Expiry Date'); if($sort == "DED") echo " &or;"; elseif($sort == "DEA") echo " &and;"; ?></a></th>
				</tr>
<?php
$domains = array();

while($row = db_fetch_assoc($results)){
	$domains[] = $row;
?>
				<tr>
					<td><a href="index.php?m=hosting&a=addedit&domain_id=<?php echo $row['domain_id']; ?>"><?php echo $row['domain_name']; ?></a></td>
					<td align="center"><?php echo $row['domain_expiry_date']; ?></td>
				</tr>		
<?php
}
?>
			</table>
		</td>
		<td>
			<table width="90%" align="center" class="tbl">
				<th align="center" nowrap="nowrap" width="200" height="20"><a href="index.php?m=hosting&tab=0&sort=<?php if($sort == "HND") echo "HNA"; else echo "HND"; ?>"><?php echo $AppUI->_('Domain'); if($sort == "HND") echo " &or;"; elseif($sort == "HNA") echo " &and;"; ?></a></th>
				<th align="center" nowrap="nowrap" width="150" height="20"><a href="index.php?m=hosting&tab=0&sort=<?php if($sort == "HPD") echo "HPA"; else echo "HPD"; ?>"><?php echo $AppUI->_('Hosting Package'); if($sort == "HPD") echo " &or;"; elseif($sort == "HPA") echo " &and;"; ?></a></th>
				<th align="center" nowrap="nowrap" width="150" height="20"><a href="index.php?m=hosting&tab=0&sort=<?php if($sort == "HED") echo "HEA"; else echo "HED"; ?>"><?php echo $AppUI->_('Expiry Date'); if($sort == "HED") echo " &or;"; elseif($sort == "HEA") echo " &and;"; ?></a></th>
<?php
foreach($domains as $domain){
?>
				<tr>
					<td><a href="index.php?m=hosting&a=addedit&domain_id=<?php echo $domain['domain_id']; ?>"><?php echo $domain['domain_name']; ?></a></td>
					<td align="center"><?php echo $domain['hosting_package_name']; ?></td>
					<td align="center"><?php echo $domain['hosting_expiry_date']; ?></td>
				</tr>
<?php
}
?>
			</table>
		</td>
	</tr>
	<tr><td style="border-right: 1px solid #D4D0C8;"><br /></td></tr>
</table>
