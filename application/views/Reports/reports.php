<?php echo anchor("Customreport/view","Custom Report"); ?>
<p>Please select a report from the list below.</p>
<?php
echo anchor("reports/view/1","Active Clients");
echo anchor("reports/view/2","Cancelled Clients");
echo anchor("reports/view/3","On Hold Clients");
echo anchor("reports/view/4","Campaigns Billed");
echo anchor("reports/view/5","Pieces Mailed");
echo anchor("reports/view/6","Versions");
echo anchor("reports/view/7","Client Audit");
?>
