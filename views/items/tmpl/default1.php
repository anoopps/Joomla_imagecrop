<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_crop
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
 $adminpath = JURI::base() . 'components/com_crop/assets/jrac';
 //$adminpath = JURI::base() . 'templates/kms/jrac';
	 
	JHTML::_('behavior.modal');
	//JHtml::_('behavior.tooltip');

	//JHtml::_('behavior.framework');
	//JHtml::_('behavior.modal');
		
			// Build the script.
			$script = array();
			$script[] = '	function jInsertFieldValue(value, id) {';
			$script[] = '		var old_value = document.id(id).value;';
			$script[] = '		if (old_value != value) {';
			$script[] = '			var elem = document.id(id);';
			$script[] = '			elem.value = value;';
			$script[] = '			elem.fireEvent("change");';
			$script[] = '			if (typeof(elem.onchange) === "function") {';
			$script[] = '				elem.onchange();';
			$script[] = '			}';
			$script[] = '			jMediaRefreshPreview(id);';
			$script[] = '		}';
			$script[] = '	}';

			$script[] = '	function jMediaRefreshPreview(id) {';
			$script[] = '		var value = document.id(id).value;';
			$script[] = '		var img = document.id(id + "_preview");';
			$script[] = '		if (img) {';
			$script[] = '			if (value) {';
			$script[] = '				img.src = "' . JURI::root() . '" + value;';
			$script[] = '				document.id(id + "_preview_empty").setStyle("display", "none");';
			$script[] = '				document.id(id + "_preview_img").setStyle("display", "");';
			$script[] = '			} else { ';
			$script[] = '				img.src = ""';
			$script[] = '				document.id(id + "_preview_empty").setStyle("display", "");';
			$script[] = '				document.id(id + "_preview_img").setStyle("display", "none");';
			$script[] = '			} ';
			$script[] = '		} ';
			$script[] = '	}';

			$script[] = '	function jMediaRefreshPreviewTip(tip)';
			$script[] = '	{';
			$script[] = '		tip.setStyle("display", "block");';
			$script[] = '		var img = tip.getElement("img.media-preview");';
			$script[] = '		var id = img.getProperty("id");';
			$script[] = '		id = id.substring(0, id.length - "_preview".length);';
			$script[] = '		jMediaRefreshPreview(id);';
			$script[] = '	}';

			// Add the script to the document head.
			JFactory::getDocument()->addScriptDeclaration(implode("\n", $script)); 			 
?>


<div class="controls">
	<div class="input-prepend input-append select-crop-img">
	
<input type="hidden" class="input-small"   value="" id="jform_images_image_intro" name="jform[images][image_intro]" aria-invalid="false" onchange="javascript:loadimage();" >
	<a rel="{handler: 'iframe', size: {x: 800, y: 500}}" href="index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;asset=91&amp;author=587&amp;fieldid=jform_images_image_intro&amp;folder=" title="Select" class="modal btn">
		Select Image
	</a>
	<a onclick="jInsertFieldValue('', 'jform_images_image_intro');return false;" href="#" title="" class="btn hasTooltip hide-item" data-original-title="Clear">
		<i class="icon-remove "></i>
	</a>
	</div>
</div>
   
   
<form id="item-form" method="POST" style="display:block;" >
	
	<div class="pane clearfix crop-wrap">
		
		<img src="http://localhost/kmsnew/images/sampledata/fruitshop/bananas_2.jpg"  id='cropimage' />
		<table class="coords">
		  <tr><td colspan="2"><label>Zoom:</label></td></tr>
		  <tr><td colspan="2" height="30"><span class="zoomin-slider"></span> <span class="zoomout-slider"></span></td></tr>	 
		  <tr class="hide-item"><td>crop x</td><td><input name="cropx" type="text" /></td></tr>
		  <tr class="hide-item"><td>crop y</td><td><input name="cropy" type="text" /></td></tr>
		  <tr  class="hide-item"><td>crop width</td><td><input  name="cropwidth" id="cropwidth" type="text" /></td></tr>
		  <tr  class="hide-item"><td>crop height</td><td><input name="cropheight" id="cropheight" type="text" /></td></tr>
		  <tr><td colspan="2"><label>Set image dimenstions:</label></td></tr>
		  <tr><td><input  name="resizewidth" placeholder="Width" type="text" /></td><td><input  name="resizeheight" placeholder="Height" type="text" /></td></tr>
		   <tr><td colspan="2" align="right" style="text-align:right;"><a href="#" class="set-img">Set</a></td></tr>
		  <tr class="hide-item"><td>lock proportion</td><td><input type="checkbox" checked="checked" /></td></tr> 
		</table>
		
		<input id="actualwidth" type="hidden" />
		<input id="actualheight" type="hidden" />
		<a class="refreshme" href="javascript:void(0);"></a>
		<a class="createimage btn btn-small btn-success" href="javascript:void(0);">Create</a>
	</div>
	
</form>
    
<!-- jQuery -->
<script type="text/javascript" src="<?php echo $adminpath; ?>/jquery-1.6.2.js"></script>

<!-- jQuery-Ui -->
<link rel="stylesheet" type="text/css" href="<?php echo $adminpath; ?>/jquery-ui.css" />
<script type="text/javascript" src="<?php echo $adminpath; ?>/jquery-ui.js"></script>
<!-- SHJS - Syntax Highlighting for JavaScript -->
<script type="text/javascript" src="<?php echo $adminpath; ?>/sh_main.min.js"></script>
<script type="text/javascript" src="<?php echo $adminpath; ?>/sh_javascript.min.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo $adminpath; ?>/sh_style.css" />

<script type="text/javascript">
	jQuery.noConflict();
	jQuery(document).ready(function(){sh_highlightDocument();});
</script>

<!-- jrac - jQuery Resize And Crop -->
<link rel="stylesheet" type="text/css" href="<?php echo $adminpath; ?>/style.jrac.css" />
<script type="text/javascript" src="<?php echo $adminpath; ?>/jquery.jrac.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $adminpath; ?>/style.css" /> 
    
    
<script type="text/javascript">
      <!--//--><![CDATA[//><!--
jQuery.noConflict();
jQuery(document).ready(function($){
	
	// Apply jrac on some image.
	jQuery('.pane img').jrac({
		'crop_width': 250,
		'crop_height': 170,
		'crop_x': 100,
		'crop_y': 100,
		'image_width': 400,
		'viewport_onload': function() {
		var $viewport = this;
		var inputs = $viewport.$container.parent('.pane').find('.coords input:text');
		var events = ['jrac_crop_x','jrac_crop_y','jrac_crop_width','jrac_crop_height','jrac_image_width','jrac_image_height'];
		for (var i = 0; i < events.length; i++) {
		var event_name = events[i];
		// Register an event with an element.
		$viewport.observator.register(event_name, inputs.eq(i));
		// Attach a handler to that event for the element.
		inputs.eq(i).bind(event_name, function(event, $viewport, value) {
		$(this).val(value);
		})
		// Attach a handler for the built-in jQuery change event, handler
		// which read user input and apply it to relevent viewport object.
		.change(event_name, function(event) {
		var event_name = event.data;
		$viewport.$image.scale_proportion_locked = $viewport.$container.parent('.pane').find('.coords input:checkbox').is(':checked');
		$viewport.observator.set_property(event_name,$(this).val());
		});
		}
		//$viewport.$container.append('<div>Image natual size: '+$viewport.$image.originalWidth+' x '+$viewport.$image.originalHeight+'</div>')	    
		jQuery('#actualwidth').val($viewport.$image.originalWidth); jQuery('#actualheight').val($viewport.$image.originalHeight);		    
		}
	})
	// React on all viewport events.
	.bind('jrac_events', function(event, $viewport) {
		var inputs = $(this).parents('.pane').find('.coords input');
		inputs.css('background-color',($viewport.observator.crop_consistent())?'chartreuse':'salmon');
	});

});
jQuery(document).ready(function (){

	jQuery('.createimage').click(function(){			
		var form= jQuery("#item-form");
		jQuery.ajax({
		    type:"POST",
		    url:'index.php?option=com_crop&task=item.saveImage',
		    data:jQuery('#item-form').serialize()+ "&imagepath="+jQuery('#cropimage').attr('src') ,			  
		    success: function(response){
			alert(response);
			//jQuery('.factsmessage').html(response);				
		    }
		});
		return false;
	});		
	jQuery('#toolbar-cancel > button').click(function(){						
		var url_redirect = 'index.php?option=com_media';
		window.location.href = url_redirect;
		return false;
	});
	jQuery('.refreshme').click(function(){
		width = jQuery('#actualwidth').val();
		height = jQuery('#actualheight').val();		
		jQuery('#cropimage').css({"width":width,"height":height});	
		return false;
	});		
	jQuery('.set-img').click(function(){		 
		jQuery('input[name="resizewidth"]').blur();
		jQuery('input[name="resizeheight"]').blur();
		return false;
	});
	
});	
function loadimage( ) {
	//jQuery('#item-form').show();
	var basepath = "<?php echo  JURI::root(); ?>";	//alert( basepath + jQuery('#jform_images_image_intro').val() );
	jQuery('#cropimage').attr('src', basepath + jQuery('#jform_images_image_intro').val() );
		jQuery('.pane img').jrac();
		//image_load_handler();
		
		
		 
}
	
</script>
