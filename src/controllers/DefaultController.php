<?php

class DefaultController extends Controller {
    /**
	 * Declares class-based actions.
	 */
	public function actions() {
            return array(
                'cookie-settings' => array(
                    'class' => 'GDPR.actions.CookieSettingsAction',
                ),
            );
        }
        
        public function actionPrivacyPolicy() {
            return $this->render('privacy-policy');
        }
}

