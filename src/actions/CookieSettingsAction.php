<?php


class CookieSettingsAction extends CAction
{
    public $viewFilePath = 'GDPR.views.default.cookie-settings';
    
    public function run()
    {
        $this->registerAssets();
        
        $form = new CookieSettingsForm();
        
        if (isset($_POST['CookieSettingsForm'])) {
            $form->setAttributes($_POST['CookieSettingsForm'], $safeOnly = false);
            if ($form->validate()) {
                $this->storeSettingsInCookies($form);
                if (Yii::app()->request->isAjaxRequest) {
                    die('OK');
                } else {
                    Yii::app()->user->setFlash('success', Yii::t('cookieconsent/form', 'flash.message.success'));
                }
            }
        }
        
        /** @var Component $component */
        $component = CookieHelper::getComponent();
        
        $renderMethod = Yii::app()->request->isAjaxRequest ? 'renderPartial' : 'render';
        return $this->controller->{$renderMethod}($this->viewFilePath, [
            'model' => $form,
            'categories' => $component->getCategories(),
            'resetLink' => $component->urlSettings[0],
            'ajax' => Yii::app()->request->isAjaxRequest,
        ]);
    }
    
    private function storeSettingsInCookies($form)
    {
        /** @var Component $component */
        $component = CookieHelper::getComponent();

        $expireAt = time() + $component->cookieExpire;
        foreach ($form->options as $category => $newValue) {
            $name = CookieConsentComponent::COOKIE_OPTION_PREFIX . $category;
            $currentValue = ArrayHelper::getValue($_COOKIE, $name);
            if ($currentValue !== $newValue) {
                unset($_COOKIE[$name]);
                setcookie($name, $newValue, $expireAt, $component->cookiePath, $component->cookieDomain, $component->cookieSecure);
            }
        }

        setcookie(
            CookieConsentComponent::COOKIECONSENT_STATUS, 
            $component->getNotAllowedTypeByComplianceType(), 
            $expireAt, 
            $component->cookiePath, 
            $component->cookieDomain, 
            $component->cookieSecure
        );
    }
    
    private function registerAssets()
    {
        
        /** @var Component $component */
        $component = CookieHelper::getComponent();

        Yii::app()->clientScript->registerScript('cookie-revoke-script', "
            $(document).on('click', '.cc-revoke-custom', function (e) {
            
                e.preventDefault();
                var cookieNames = " . json_encode($component->getCategories()) . ';
                $.each(cookieNames, function(){
                    document.cookie = ' . $component->removeCookieConfig("cookieconsent_option_' + this + '") . ';
                });
                document.cookie = ' . $component->removeCookieConfig('cookieconsent_status') . ';
                // update cookie settings page if cookieconsent status changed on this page
                window.location.reload();
            });
        ', CClientScript::POS_END);
    }
}