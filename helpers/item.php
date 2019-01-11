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
 * Crops helper.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_crop
 * @since       1.6
 */
class ItemHelper extends JHelperContent
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string	$vName  The name of the active view.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public static function addSubmenu($vName = 'items')
	{
		/*JHtmlSidebar::addEntry(
			JText::_('COM_CROP_SUBMENU_CROP'),
			'index.php?option=com_crop&view=items',
			$vName == 'items'
		);
		  
			JHtmlSidebar::addEntry(
				JText::_('COM_CROP_SUBMENU_CATEGORIES'),
				'index.php?option=com_categories&extension=com_crop',
				$vName == 'categories'
			);*/
		
	}

}
