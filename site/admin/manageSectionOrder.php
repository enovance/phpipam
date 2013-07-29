<?php

/*
 * Section ordering
 *************************************************/

/* required functions */
require_once('../../functions/functions.php'); 

/* verify that user is admin */
checkAdmin();

/* verify post */
CheckReferrer();

/**
 * Fetch section info
 */
$sections = fetchSections();

$size =sizeof($sections);
?>



<!-- header -->
<div class="pHeader"><?php print _('Section order'); ?></div>


<!-- content -->
<div class="pContent">

	<!-- Order note -->
	<p class="muted"><?php print _('You can manually set order in which sections are displayed in. Default is creation date.'); ?></p>

	<!-- form -->
	<form id="sectionOrder" name="sectionEdit">

		<!-- edit table -->
		<table class="table table-condensed table-top">
		
		<!-- headers -->
		<tr>
			<th><?php print _("Name"); ?></th>
			<th><?php print _("Description"); ?></th>
			<th><?php print _(""); ?></th>
		</tr>
		
		<tbody id="sectionRows">
		<?php
		// print sections
		$orderIndex = 1;
		foreach($sections as $s) {
			print "<tr>";
			
			print "	<td>$s[name]</td>";
			print "	<td>$s[description]</td>";
			
			//order
			print "	<td>";
			print "	<input type='hidden' name='order-$s[id]' value=$orderIndex />";
			print " <i class='icon-move icon-gray'></i>";
			print "	</td>";
			
			print "</tr>";
			
			$orderIndex++;
		}
		?>
		</tbody>
		
		</table>	<!-- end table -->
	</form>		<!-- end form -->
</div>


<!-- footer -->
<div class="pFooter">
	<div class="btn-group">
		<button class="btn btn-small hidePopups"><?php print _('Cancel'); ?></button>
		<button class="btn btn-small btn-success" id="sectionOrderSubmit"><i class="icon-white icon-ok"></i> <?php print _('Save'); ?></button>
	</div>
	<!-- result holder -->
	<div class="sectionOrderResult"></div>
</div>	
		
