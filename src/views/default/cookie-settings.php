<?php
/** @var $this View */
/** @var $model CookieSettingsForm */
/** @var $categories array */
/** @var $resetLink array */
/** @var $ajax boolean */
?>

<?php if (!$ajax): ?>
    <h2> <?php echo Yii::t('GDPRModule.form', 'title.cookie-settings') ?> </h2>
<?php endif; ?>

<div id="cookie-settings">
<?php 
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'cookieSettingsForm',
    'enableAjaxValidation' => true,
    'htmlOptions'=>array(
        'onsubmit' => $ajax ? "return ajaxSubmit();" : '',/* Disable normal form submit */
    ),
//    'validateOnType' => true,
    'focus'=>array($model,'firstName'),
));
?>
<dl>
<?php foreach ($categories as $category): ?>
<?php 
    $labelText = Yii::t('GDPRModule.form', $model->getAttributeLabel($category));
    $hintText = Yii::t('GDPRModule.form', 'hint.'.$category);

    $checkbox = $form->checkBox($model, 'options[' . $category . ']', [
                'id'=>'cookie_option_'.$category, 
                'required'=> CookieHelper::getComponent()->isRequiredToAllow($category)
//                , 'disabled'=> CookieHelper::getComponent()->isRequiredToAllow($category)
            ]);

    echo '<dt>', 
            $checkbox,
            $form->label($model, $labelText, ['for'=>'cookie_option_'.$category]),
        '</dt>',
        '<dd>', $hintText, '</dd>';
?>
    
<?php endforeach; ?>
</dl>
<!--    <div class="row">
        <div class="col-xs-offset-3 col-xs-9">-->
            <?php echo CHtml::submitButton(Yii::t('GDPRModule.form', 'btn.save'), ['class' => 'btn btn-success']) ?>
            <?php
//            echo CHtml::link(Yii::t('cookieconsent/widget', 'Reset to default'), Yii::app()->createAbsoluteUrl($resetLink), [
//                'class' => 'btn btn-default cc-revoke-custom',
//            ]) 
            ?>
<!--        </div>
    </div>-->
<?php $this->endWidget(); ?>
</div>
    
<script>
    $(document).on('click', '.cc-revoke-custom', function (e) {
        e.preventDefault();
        var cookieNames = <?php echo json_encode(CookieHelper::getComponent()->getCategories()) ?>;
        $.each(cookieNames, function(){
            document.cookie = <?php echo CookieHelper::getComponent()->removeCookieConfig("cookieconsent_option_' + this + '") ?>;
        });
        document.cookie = <?php echo CookieHelper::getComponent()->removeCookieConfig('cookieconsent_status') ?>;
        
        // update cookie settings page if cookieconsent status changed on this page
        window.location.reload();
    });
</script>

<script>
    function ajaxSubmit() {
        $.ajax({
            type: 'POST',
            url: '<?php echo $_SERVER['REQUEST_URI'] ?>',
            data: $('#cookieSettingsForm').serialize(),
            success: function(result) {
//                console.log(result);
                if (result == 'OK') {
//                    alert('Cookie settings saved successfully');
                    window.location.reload();
                }
            }, 
            error: function(e) {
//                window.CC.revokeChoice();
                console.log(e);
            }
        });
        
        return false;
    }
</script>