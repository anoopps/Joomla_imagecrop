<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_crop
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Crop controller class.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_crop
 * @since       1.6
 */
class CropControllerItem extends JControllerForm
{
	/**
	 * Method override to check if you can add a new record.
	 *
	 * @param   array  $data  An array of input data.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowAdd($data = array())
	{
		$user = JFactory::getUser();
		$categoryId = JArrayHelper::getValue($data, 'catid', $this->input->getInt('filter_category_id'), 'int');
		$allow = null;

		if ($categoryId)
		{
			// If the category has been passed in the URL check it.
			$allow = $user->authorise('core.create', $this->option . '.category.' . $categoryId);
		}

		if ($allow === null)
		{
			// In the absense of better information, revert to the component permissions.
			return parent::allowAdd($data);
		}
		else
		{
			return $allow;
		}
	}

	/**
	 * Method to check if you can add a new record.
	 *
	 * @param   array   $data  An array of input data.
	 * @param   string  $key   The name of the key for the primary key.
	 *
	 * @return  boolean
	 * @since   1.6
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		$recordId = (int) isset($data[$key]) ? $data[$key] : 0;
		$categoryId = 0;

		if ($recordId)
		{
			$categoryId = (int) $this->getModel()->getItem($recordId)->catid;
		}

		if ($categoryId)
		{
			// The category has been set. Check the category permissions.
			return JFactory::getUser()->authorise('core.edit', $this->option . '.category.' . $categoryId);
		}
		else
		{
			// Since there is no asset tracking, revert to the component permissions.
			return parent::allowEdit($data, $key);
		}
	}

	/**
	 * Method to run batch operations.
	 *
	 * @param   object  $model  The model.
	 *
	 * @return  boolean   True if successful, false otherwise and internal error is set.
	 *
	 * @since   1.7
	 */
	public function batch($model = null)
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Set the model
		$model = $this->getModel('Item', '', array());

		// Preset the redirect
		$this->setRedirect(JRoute::_('index.php?option=com_crop&view=items' . $this->getRedirectToListAppend(), false));

		return parent::batch($model);
	}

	/**
	 * Function that allows child controller access to model data after the data has been saved.
	 *
	 * @param   JModelLegacy  $model      The data model object.
	 * @param   array         $validData  The validated data.
	 *
	 * @return	void
	 * @since	1.6
	 */
	protected function postSaveHook(JModelLegacy $model, $validData = array())
	{
		$task = $this->getTask();

		if ($task == 'save')
		{
			$this->setRedirect(JRoute::_('index.php?option=com_crop&view=items', false));
		}
	}
	
	public function saveImage(){
		 
		$basepath = JURI::root();		
		$cropx = JRequest::getVar('cropx');
		$cropy = JRequest::getVar('cropy');
		$cropwidth = JRequest::getVar('cropwidth');
		$cropheight = JRequest::getVar('cropheight');
		$resizewidth = JRequest::getVar('resizewidth');
		$resizeheight = JRequest::getVar('resizeheight');
		$imagepath = JRequest::getVar('imagepath');
		//actual image propertise
		$image_properties = getimagesize($imagepath);		
		$actualwidth = $image_properties[0];
		$actualheight = $image_properties[1];
		$type = strtolower($image_properties["mime"]);		 
		
		$saveimage = str_replace($basepath,'',$imagepath); 
		
		if($this->thumbnail($imagepath,$saveimage,$resizewidth,$resizeheight, $type)){
			$this->cropIt($imagepath, $saveimage, $cropx, $cropy, $cropwidth, $cropheight, $type);	
		}	     
		
		$result = array('message'=>'Image saved','imagepath'=> $imagepath);
		echo json_encode($result);
		exit;
	}
		
	
	function thumbnail($image,$replaceimg, $width, $height,$type) {		
		 
		$image_properties = getimagesize($image);	
		$image_width = $image_properties[0];
		$image_height = $image_properties[1];
		
		$image_ratio = $image_width / $image_height;		
		
		if(!$width && !$height) {
			$width = $image_width;
			$height = $image_height;
		}
		if(!$width) {
			$width = round($height * $image_ratio);
		}
		if(!$height) {
			$height = round($width / $image_ratio);
		}
		$temp_image = imagecreatetruecolor($width, $height);
		
		switch($type){			
			case 'image/jpeg':
				$thumb = imagecreatefromjpeg($image);
				break;
			case 'image/png':
				$thumb = imagecreatefrompng($image);
				$allocate = imagecolorallocate($temp_image, 255, 255, 255);
				imagefill($temp_image,0,0,$allocate);
				break;
			case 'image/gif':
				$thumb =imagecreatefromgif($image);
				break;
			default:
				return false;			
		}		
		$resize_image_path = JPATH_SITE.'/'.$replaceimg;			
		if( imagecopyresampled($temp_image, $thumb, 0, 0, 0, 0, $width, $height, $image_width, $image_height) ){
			
			if($type == "image/jpeg") {
				imagejpeg($temp_image,$resize_image_path,100);
			} elseif ($type == "image/png") {			
				imagepng($temp_image,$resize_image_path,8);
			} elseif ($type == "image/gif"){
				imagegif($temp_image,$resize_image_path,100);
			}			
			imagedestroy($temp_image); 
			imagedestroy($thumbnail);
			return true;
		}		
	}
	
	
	public function cropIt($image, $cropimage, $xaxis, $yaxis, $cropwidth, $cropheight, $type) {	 
		
		$dst_x = 0;   // X-coordinate of destination point
		$dst_y = 0;   // Y-coordinate of destination point
		$dst_w = $cropwidth;
		$dst_h = $cropheight;
		 
		$cropimg_path = JPATH_SITE.'/'.$cropimage;		
		 
		$dst_image = imagecreatetruecolor($dst_w, $dst_h);		 
		
		// Get original image		
		//$src_image = imagecreatefromjpeg($image);
		if($type == "image/jpeg") {			
			$src_image = imagecreatefromjpeg($image);
		} elseif($type == "image/png") {		
			$src_image = imagecreatefrompng($image);
		} elseif($type == "image/gif") {			
			$src_image =imagecreatefromgif($image);
		}
		
		if( imagecopyresampled($dst_image, $src_image, 0, 0, $xaxis, $yaxis, $dst_w, $dst_h ,$dst_w, $dst_h ) ){			
			if($type == "image/jpeg") {
			imagejpeg($dst_image, $cropimg_path,100);
			} elseif ($type == "image/png") {			
				imagepng($dst_image, $cropimg_path,8);
			} elseif ($type == "image/gif"){
				imagegif($dst_image, $cropimg_path,100);
			}
			imagedestroy($dst_image);			 
			return true;				
		}
	}
	
}
