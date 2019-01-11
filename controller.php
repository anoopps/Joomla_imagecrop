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
 * Crops Crop Controller
 *
 * @package     Joomla.Administrator
 * @subpackage  com_crop
 * @since       1.5
 */
class CropController extends JControllerLegacy
{
	/**
	 * Method to display a view.
	 *
	 * @param   boolean			$cachable	If true, the view output will be cached
	 * @param   array  $urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JController		This object to support chaining.
	 * @since   1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT.'/helpers/item.php';

		$view   = $this->input->get('view', 'items');
		$layout = $this->input->get('layout', 'default');
		$id     = $this->input->getInt('id');
		

		// Check for edit form.
		if ($view == 'items' && $layout == 'edit' && !$this->checkEditId('com_crop.edit.items', $id))
		{
			// Somehow the person just went to the form - we don't allow that.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_crop&view=items', false));

			return false;
		}
		
		if ( $this->input->get('view') == '')
			$view   = $this->input->set('view', 'items');

		parent::display();

		return $this;
	}
}
