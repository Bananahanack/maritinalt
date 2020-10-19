<?php
// No direct access
defined( '_JEXEC' ) or die;

/**
 * View for  current element
 * @author Bananahanack
 */
class Maritina_RatesViewForm extends JViewLegacy
{
	/**
	 * @var $form JForm
	 */
	public $form;
	/**
	 * @var $item stdClass
	 */
	public $item;
	/**
	 * @var $state JObject
	 */
	public $state;

	protected $script;

	/**
	 * Method of display current template
	 * @param type $tpl
	 */
	public function display( $tpl = null )
	{
	    /*$this->item = $this->get( 'Items' ); - в этой строке мы
	    вызываем метод getItems в модели category.php модель должна лежать в папке models*/
		$this->item = $this->get( 'Item' );
		$this->form = $this->get( 'Form' );
		$this->state = $this->get( 'State' );
        $this->script = $this->get('Script');
		maritina_ratesSiteHelper::setDocument( 'view title');
		parent::display( $tpl );
	}

//    protected function setDocument()
//    {
//        $document = JFactory::getDocument();
//        $document->addScript(JURI::root() . $this->script);
//        $document->addScript(
//            JURI::root() . "components/com_helloworld/views/helloworld/submitbutton.js");
//        JText::script('COM_HELLOWORLD_HELLOWORLD_ERROR_UNACCEPTABLE');
//    }

}