<?php

class CMEB_Validate {

    protected static $_availableValidators = array('FreeDomains', 'WhiteList',);

    const OPTION_ENABLED_VALIDATORS = 'cmeb_enabled_validators';
    const ERROR_MESSAGE_OPTION = 'cmeb_error_message';

    protected static $_enabledValidators = array();
    public static $_whiteListed = false;
    public static $_freeDomainsListed = false;

    public static function init() {
        self::$_enabledValidators = get_option(self::OPTION_ENABLED_VALIDATORS, self::$_availableValidators);
        add_filter('cmeb_admin_settings', array(get_class(), 'handleAdminSettings'));
        add_action('register_form', array(get_class(), 'addRegisterFormField'));
        add_filter('registration_errors', array(get_class(), 'verifyDomain'), 100, 3);
    }

    public function isValid($domain) {
        $domain = strtolower(trim($domain));

        $isValid = true;
        $isEnable = CMEB_Settings::getOption(CMEB_Settings::OPTION_WHITE_LIST);
        if ($isEnable === 1) {
            include_once CMEB_PATH . '/lib/models/WhiteList.php';
            $isValid = CMEB_WhiteList::isValid($domain);
            self::$_whiteListed = $isValid;
        }
        $isBlack = false;
        $isEnable = CMEB_Settings::getOption(CMEB_Settings::OPTION_FREE_DOMAINS);

        if ($isEnable === 1 && $isValid == false && $isBlack == false) {
            include_once CMEB_PATH . '/lib/models/FreeDomains.php';
            $tmpIsValid = CMEB_FreeDomains::isValid($domain);
            if ($tmpIsValid === false) {
                $isBlack = true;
            }
            self::$_freeDomainsListed = ($tmpIsValid == false);
        }

        if ($isValid == true || $isBlack == false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Verify if user email domain is valid
     * @param array $errors
     * @param string $sanitized_user_login
     * @param string $user_email
     * @return WP_Error 
     */
    public static function verifyDomain($errors, $sanitized_user_login, $user_email) {
        $emailParts = explode('@', $user_email);
        if (isset($emailParts[1])) {
            $emailDomain = $emailParts[1];
            $validator = new self;
            if (!$validator->isValid($emailDomain)) {
                if (self::$_whiteListed === true)
                    $reason = CMEB_Settings::getOption(CMEB_Settings::OPTION_BECAUSE_WHITE);
                elseif (self::$_freeDomainsListed)
                    $reason = CMEB_Settings::getOption(CMEB_Settings::OPTION_BECAUSE_FREE_DOMAIN);
                else
                    $reason = CMEB_Settings::getOption(CMEB_Settings::OPTION_BECAUSE_NONE);
                add_action('login_head', 'wp_shake_js', 12);
                $loginFaild = CMEB_Settings::getOption(CMEB_Settings::OPTION_LOGIN_ERROR);
                return new WP_Error('authentication_failed', '<strong>' . $loginFaild . '</strong> </br>' . $reason . '</br>');
            }
        } else {
            add_action('login_head', 'wp_shake_js', 12);
            return new WP_Error('authentication_failed', '<strong>ERROR</strong>: E-mail format is not valid.');
        }
        return $errors;
    }

    public static function handleAdminSettings($params) {
        if (!empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'cmeb_settings')) {
            $params = CMEB_Settings::processPostRequest();
            update_option(self::OPTION_ENABLED_VALIDATORS, !empty($_POST['enabledValidators']) ? $_POST['enabledValidators'] : array());
            if (!empty($_POST['errorMessage']))
                update_option(self::ERROR_MESSAGE_OPTION, $_POST['errorMessage']);
            self::$_enabledValidators = get_option(self::OPTION_ENABLED_VALIDATORS, array());
            $params['messages'][] = 'Options updated';
        }
        $params['availableValidators'] = self::$_availableValidators;
        $params['enabledValidators'] = self::$_enabledValidators;
        $params['validatorNames'] = array(
            'FreeDomains' => 'Use predefined list of free e-mail domains (downloaded from SpamAssassin - http://svn.apache.org/repos/asf/spamassassin/trunk/rules/20_freemail_domains.cf)'
        );
        return $params;
    }

    public static function install() {
        foreach (self::$_availableValidators as $validatorName) {
            $className = 'CMEB_' . $validatorName;
            include_once CMEB_PATH . '/lib/models/' . $validatorName . '.php';
            $className::install();
        }
    }

    public static function uninstall() {
        foreach (self::$_availableValidators as $validatorName) {
            $className = 'CMEB_' . $validatorName;
            include_once CMEB_PATH . '/lib/models/' . $validatorName . '.php';
            $className::install();
        }
    }

    public function isWhiteListed() {
        return self::$_whiteListed;
    }

    public function isFreeDomainListed() {
        return self::$_freeDomainsListed;
    }

    public static function addRegisterFormField() {
        ob_start();
        ?>
        <style>
            #user_email {margin-bottom:0px;}
            .cmeb_poweredby {clear:both;float:none;font-size:8px;line-height:1.5;margin-bottom:16px;display: inline-block;color:#bbb;text-decoration:none;font-weight:bold}
            .cmeb_poweredby:before {content:'Powered by ';}
        </style>
        <!--// By leaving following snippet in the code, you're expressing your gratitude to creators of this plugin. Thank You! //-->
        <span class="cmeb_poweredby"><a href="http://plugins.cminds.com/" target="_new">CreativeMinds WordPress Plugins</a> <a href="http://plugins.cminds.com/cm-email-blacklist/" target="_new">E-Mail Blacklist</a></span>
        <?php

        ob_end_flush();
    }

}
