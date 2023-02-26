<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' - Privacy Policy';
$this->breadcrumbs = array(
	'Privacy Policy',
);
$companyName = 'Polichronopoulos de Queiroz Pablo und Igova Silvina GbR';
$siteName = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].'/';

ob_start();
require ('lang/'.Yii::app()->language.'/privacy-policy.php');
$text = ob_get_clean();

$text = str_replace('https://salsamas.de/', $siteName, $text);
$text = str_replace('Pablo de Queiroz und Silvina Igova GbR', $companyName, $text);

echo $text;

?>

<!--<hr>
<h1> <?php echo Yii::t('form', 'Cookie Settings') ?> </h1>-->
<?php 
//Yii::app()->controller->renderPartial('application.extensions.cookieconsent.views.cookie-settings', [
//    
//])
?>
