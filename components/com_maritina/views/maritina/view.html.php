<?php
// No direct access
defined( '_JEXEC' ) or die;

/**
 * View for  current element
 * @author Bananahanack
 */
class MaritinaViewMaritina extends JViewLegacy
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

	public $items;

	public $a;

	/**
	 * Method of display current template
	 * @param type $tpl
	 */
	public function display( $tpl = null )
	{
//		$this->item = $this->get( 'Item' );
//		$this->form = $this->get( 'Form' );
//		$this->state = $this->get( 'State' );
        $this->items = $this->getData();

		maritinaSiteHelper::setDocument( '');

		parent::display( $tpl );
	}

    public function getData(){
        $riga_20ft_40ft_list = json_decode($this->getModel()->getDataFromDb('riga_data_list'), true);
        $klaipeda_20ft_40ft_list = json_decode($this->getModel()->getDataFromDb('klaipeda_data_list'), true);
        $riga_ports = array_column($riga_20ft_40ft_list, 'port');
        $klaipeda_ports = array_column($klaipeda_20ft_40ft_list, 'port');
	    return $riga_ports + $klaipeda_ports;;
    }

}