<div id="dialog" title="Cookie Settings"></div>
<script>
    var popupOptions = {
        layouts: {
            // Use custom layout to introduce `settings` button that neither allows nor denies cookies, until the cookie form was saved, 
            // having them set by BE
           'basic-settings': '<div role="dialog" aria-live="polite" aria-label="cookieconsent" aria-describedby="cookieconsent:desc" class="cc-window cc-banner cc-type-opt-out cc-theme-block cc-bottom cc-color-override-814037081 " style="">\n\
                    <!--googleoff: all-->\n\
                    {{messagelink}} \n\
                    <div class="cc-compliance cc-highlight">\n\
                        <a aria-label="settings cookies" tabindex="0" class="cc-btn cc-settings"> <?php echo Yii::t('GDPRModule.widget', 'content.settings') ?> </a>\n\
                        {{dismiss}}\n\
                    </div>\n\
                    <!--googleon: all--></div>'
        },
        layout: 'basic-settings',
        theme: "block",
        content: {
            message: '<?php echo Yii::t('GDPRModule.widget', 'content.message') ?>',
            dismiss: '<?php echo Yii::t('GDPRModule.widget', 'content.dismiss') ?>',
            allow: '<?php echo Yii::t('GDPRModule.widget', 'content.allow') ?>',
            deny: '<?php echo Yii::t('GDPRModule.widget', 'content.deny') ?>',
            link: '<?php echo Yii::t('GDPRModule.widget', 'content.link') ?>',
            href: '<?php echo CookieHelper::getComponent()->urlPrivacyPolicy ?>',
            target: '_blank',
            policy: '<?php echo Yii::t('GDPRModule.widget', 'content.policy') ?>',
        },
        palette: {
            popup: { background: "rgba(0, 0, 0, 0.9);" },
            button: { background: "#aa0000", padding: '5px 50px' },
        },
                
        revokable: true,
        type: '<?php echo CookieHelper::getComponent()->complianceType ?>',
        autoAttach: true,
        autoOpen: true,
        
        law: {
            regionalLaw: true,
        },
        location: true,
        
        onPopupOpen: function() {
            // Used to control the cookie popup's behavior at a later stage
            window.cookiePopup = this;
        },
        onInitialise: function (status) {
            console.log('cookie allowance:', status);
            /*
            var type = this.options.type;
            var didConsent = this.hasConsented();
            if (type == 'opt-in' && didConsent) {
                console.log('enable cookies?');
                
            } else if (type == 'opt-out' && !didConsent) {
                console.log('disable cookies?');
            }
            */
        }   
    };

    window.cookieconsent.initialise(popupOptions);
   
    // Create cookie notification popup separately, if necessary
//    window.cookiePopup = new window.cookieconsent.Popup(popupOptions);
//    if (!window.cookiePopup.hasConsented()) {
//        document.body.appendChild(cookiePopup.element);
//    }
    
   
   // Settings dialog
   $(document).on('click', '.cc-btn.cc-settings', function(event) {
        var dlg = $("#dialog").load('<?php echo CookieHelper::getComponent()->urlSettings ?>').dialog({
            modal: true,
            resizable: false,
            title: '<?php echo Yii::t('GDPRModule.form', 'title.cookie-settings') ?>',
            minWidth: window.innerWidth > 1024 ? 600 : 0,
            position: { my: "center top", at: "center top" },
            closeOnEscape: false,
            open: function(event, ui) {
                window.cookiePopup.close();
                // Close for now, can later call setStatus() if necessary
            }
        });
    });
   
</script>