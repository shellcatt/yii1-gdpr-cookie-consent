<?php

class CookieConsentWidget extends CWidget {
    
    // this method is called by CController::beginWidget()
    public function init() {
        parent::init();
    }
 
    // this method is called by CController::endWidget()
    public function run() {
        
        // Do not run the Osano script if the user's on the same form w/out dialog/ajax
        if (Yii::app()->controller->action->id == 'cookie-settings') {
            return false;
        }
        
        // Need to import the actual module file 
        // in order to benefit from its own translations
        Yii::import('application.modules.GDPR.GDPRModule');
        
        $this->render('cookie-script-osano');
    }
}