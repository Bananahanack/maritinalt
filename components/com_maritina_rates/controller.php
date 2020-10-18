<?php
defined( '_JEXEC' ) or die; // No direct access

/**
 * Default Controller
 * @author Bananahanack
 */
class Maritina_RatesController extends JControllerLegacy
{

	/**
	 * Method to display a view.
	 * @param bool $cachable
	 * @param array $urlparams
	 * @return JControllerLegacy
	 */
	function display( $cachable = false, $urlparams = array() )
	{
/*Если в адресной строке не указана задача (task) то контроллер выполнит метод dispaly который
является методом по умолчаниюВ переменной $this->default_view = 'category'; мы задаем вид
по умолчанию для этого компонента!Тоесть если мы в адресной строке не передадим переменную view
с указанием вида для отображения
то выведется тот вид который указан в переменной $this->default_view!
Если вид по умолчанию не указан и не передана переменная view мы получим ошибку!*/
		$this->default_view = 'form';
/*   Строка parent::display( $cachable ); получает текущий вид и
управление переходит в наш вид в котором вызываеться метод display() (view.html.php)*/
        parent::display( $cachable, $urlparams );

		return $this;
	}



	/**
	 * Call AJAX method
	 * @throws Exception
	 */
	public function getAjax()
	{
		$input = JFactory::getApplication()->input;
		$model = $this->getModel( 'ajax' );
		$action = $input->getCmd( 'action' );
		$reflection = new ReflectionClass( $model );
		$methods = $reflection->getMethods( ReflectionMethod::IS_PUBLIC );
		$methodList = array();
		foreach ( $methods as $method ) {
			$methodList[] = $method->name;
		}
		if ( in_array( $action, $methodList ) ) {
			$model->$action();
		}
		exit;
	}
}