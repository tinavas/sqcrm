<?php
if (isset($_REQUEST["widget_id"]) && (int)$_REQUEST["widget_id"] > 0) {
	$widget_id = (int)$_REQUEST["widget_id"] ;
}
?>
<li data-id="<?php echo $widget_id ; ?>" class="li_no_number">
	<div class="datadisplay-outer"><i class="icon-move"></i>
		<?php echo _('Prospect Pipeline By Sales Stage') ;?><a href="#"><i class="icon-remove-sign remove-widget" style="float:right;"  id="<?php echo $widget_id ; ?>"></i></a>
		<div id="prospect_pipeline_by_sales_stage"></div>
	</div>
</li>

<script type="text/javascript">
$(document).ready(function() {
	// load the calendar with the events on pageload
	$.ajax({
		type: "GET",
		url: "/widgets.php",
		data : "widget_name=ProspectPipeline&resource_name=prospect_pipeline_salesstage&ajaxreq="+true+"&rand="+generateRandonString(10),
		success: function(result) { 
			$('#prospect_pipeline_by_sales_stage').html(result) ;
		},
		beforeSend: function() {
			$('#prospect_pipeline_by_sales_stage').html('<img class="ajax_loader" src="/themes/images/ajax-loader1.gif" border="0" />');
		}
    });
});
</script>