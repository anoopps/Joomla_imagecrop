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
 * View class for a list of crop.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_crop
 * @since       1.5
 */
class CropViewItems extends JViewLegacy
{
	protected $state;

	protected $item;

	protected $form;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state	= $this->get('State');
		//$this->item		= $this->get('categories');		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		$this->addToolbar();		 
		parent::display();
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$user		= JFactory::getUser();	
		JToolbarHelper::title(JText::_('Image Cropper'), 'imagecropper');

		// If not checked out, can save the item.
		//if (!$checkedOut && ($canDo->get('core.edit')||(count($user->getAuthorisedCategories('com_facts', 'core.create')))))
		//{
		//JToolbarHelper::apply('categories.apply');
		//JToolbarHelper::apply('categories.SaveCategories');		
		if (empty($this->item->id))
		{
			JToolbarHelper::cancel('items.cancel', 'Close');
		}
		else
		{
			if ($this->state->params->get('save_history', 0) && $user->authorise('core.edit'))
			{
				JToolbarHelper::versions('com_facts.facts', $this->item->id);
			}

			JToolbarHelper::cancel('item.cancel', 'Close');
		}

		JToolbarHelper::divider();
		JToolbarHelper::help('JHELP_COMPONENTS_CROPS_CROPS_EDIT');
	}
}
