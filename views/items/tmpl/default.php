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
	 
	//JHTML::_('behavior.modal');
	//JHtml::_('behavior.tooltip');

	//JHtml::_('behavior.framework');
	//JHtml::_('behavior.modal');
		/*
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
			JFactory::getDocument()->addScriptDeclaration(implode("\n", $script)); 	*/		 
?>
<script>	 
function jInsertFieldValue(value, id) {	 
	var path = '<?php echo str_replace("administrator/", "", JURI::base()); ?>'+value;	
	jQuery("#jform_images_image_intro").val(value);
	TINY.box.hide();	
	loadimage(path);
	jQuery('#actualimage').val(path);
}
function jModalClose() {	 
	 return false;
}
function loadimage(path){	 
	jQuery('#item-form').show();	
	jQuery('#cropimage').attr('src', path );
	var img = document.getElementById('cropimage');	 
	jQuery('#actualwidth').val(img.clientWidth); jQuery('#actualheight').val(img.clientHeight);		
	jQuery('input[name="resizewidth"]').val(img.clientWidth); jQuery('input[name="resizeheight"]').val(img.clientHeight);	
	reintilise();
}
function reintilise() {	
	jQuery('.pane img').jrac();
	jQuery('.refreshme').removeClass('disabled-refresh');
	jQuery('.createimage').removeClass('disabled-reclick');
	jQuery('.jrac_viewport > .ui-draggable').css('display','block');
}
</script>
<script type="text/javascript" src="<?php echo JURI::base(); ?>templates/kms/tinybox/tinybox.js"></script>
<link rel="stylesheet" href="<?php echo JURI::base(); ?>components/com_crop/assets/style.css" />



<div class="controls">
	<div class="input-prepend input-append select-crop-img">
	
<input type="hidden" class="input-small"   value="" id="jform_images_image_intro" name="jform[images][image_intro]">
	<?php /*<a rel="{handler: 'iframe', size: {x: 800, y: 500}}" href="index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;asset=91&amp;author=587&amp;fieldid=jform_images_image_intro&amp;folder=" title="Select" class="modal btn">
		Select Image
	</a>
	<a onclick="jInsertFieldValue('', 'jform_images_image_intro');return false;" href="#" title="" class="btn hasTooltip hide-item" data-original-title="Clear">
		<i class="icon-remove "></i>
	</a>*/?>
	<a class="btn" onclick="TINY.box.show({iframe:'index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;asset=91&amp;author=587&amp;fieldid=jform_images_image_intro&amp;folder=',boxid:'frameless',width:750,height:450,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){}})">Select Image</a>
	</div>
</div>

   
<form id="item-form" method="POST" style="display:none;" >
	
	<div class="pane clearfix crop-wrap">
		
		<img src="<?php echo JURI::base(); ?>components/com_crop/assets/images/placeholder.png"  id='cropimage' />
		<!--<img src=""  id='cropimage' />-->
		<table class="coords">
		  <tr><td colspan="2"><label>Zoom:</label></td></tr>
		  <tr><td colspan="2" height="30"><span class="zoomin-slider"></span> <span class="zoomout-slider"></span></td></tr>	 
		  <tr class="hide-item"><td>crop x</td><td><input name="cropx" type="text" /></td></tr>
		  <tr class="hide-item"><td>crop y</td><td><input name="cropy" type="text" /></td></tr>
		  <tr><td colspan="2"><label>Set image dimensions:</label></td></tr>
		  <tr><td><input  name="cropwidth" id="cropwidth" placeholder="Width" type="text" /></td><td><input name="cropheight" id="cropheight" type="text" placeholder="Height"  /></td></tr>
		   <tr><td class="hide-item"><input  name="resizewidth" placeholder="Width" type="text" /></td><td class="hide-item"><input  name="resizeheight" placeholder="Height" type="text" /></td></tr>
		   <tr><td colspan="2" align="right" style="text-align:right;"><a href="#" class="set-img">Set</a></td></tr>
		  <tr class="hide-item"><td>lock proportion</td><td><input type="checkbox" checked="checked" /></td></tr> 
		</table>
		<span class="notification_img">Changes made to this image will overwrite the original image</span>
		<input id="actualwidth" type="hidden" />
		<input id="actualheight" type="hidden" />
		<input id="actualimage" type="hidden" />
		<a class="refreshme" href="javascript:void(0);"></a>
		<div class="message"></div>
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
		'zoom_min': 100,
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
        jQuery('#toolbar-cancel > button').removeAttr('onclick');
	jQuery('.createimage').click(function(){
		var image_path = jQuery('#cropimage').attr('src');
		pos = image_path.indexOf("?");		
		if(pos>0){
			image_path = image_path.substring(0, pos);
		}
		
		var form= jQuery("#item-form");
		jQuery.ajax({
		    type:"POST",
		    url:'index.php?option=com_crop&task=item.saveImage',
		    data:jQuery('#item-form').serialize()+ "&imagepath="+image_path ,			  
		    success: function(response){			
			var output = jQuery.parseJSON(response);
			
			if( jQuery('#cropimage').attr('src',output.imagepath +'?rand='+Math.random() ) ){
				jQuery('#cropimage').removeAttr('style');
				jQuery('.message').html(output.message);
			}
				jQuery('.jrac_viewport > .ui-draggable').css('display','none');
				//jQuery('.jrac_viewport > #cropimage').css('display','block');				
				
				//code for resize			
				curwidth = jQuery('input[name="resizewidth"]').val();				
				jQuery('.jrac_viewport > #cropimage').css({'display':'block', 'width':curwidth });
				
		    }
		});
		jQuery('.refreshme').addClass('disabled-refresh');
		jQuery(this).addClass('disabled-reclick');
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
		jQuery('input[name="resizewidth"]').val(width); jQuery('input[name="resizeheight"]').val(height);
		jQuery('input[name="resizewidth"]').trigger('change');
		
		//loadimage(jQuery('#actualimage').val());
		//jQuery('#cropimage').removeAttr('style')
		return false;
	});		
	jQuery('.set-img').click(function(){		 
		jQuery('input[name="resizewidth"]').blur();
		jQuery('input[name="resizeheight"]').blur();
		return false;
	});
	
	
});	
</script>
