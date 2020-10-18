<?php
defined( '_JEXEC' ) or die; // No direct access

/**
 * View for  current element
 * @author Bananahanack
 */
class Maritina_RatesViewResult extends JViewLegacy
{
	/**
	 * Method of display current template
	 * @param type $tpl
	 */
	public function display( $tpl = null )
	{
		maritina_ratesSiteHelper::setDocument( '' );
		parent::display( $tpl );
	}

}