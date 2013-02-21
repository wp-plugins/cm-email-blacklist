<?php

include_once CMEB_PATH . '/lib/models/Interface.php';
include_once CMEB_PATH . '/lib/models/WhiteList.php';

class CMEB_Validate implements CMEB_Interface {

    protected static $_availableValidators = array('UserList', 'FreeDomains', 'DNSBL',);
    const OPTION_ENABLED_VALIDATORS = 'cmeb_enabled_validators';
    const ERROR_MESSAGE_OPTION = 'cmeb_error_message';
    const DEFAULT_ERROR_MESSAGE = 'Your e-mail domain is blacklisted.';
    protected static $_enabledValidators = array();
    protected $_whiteListed = false;
    protected $_blackListed = false;

    public static function init() {
        self::$_enabledValidators = get_option(self::OPTION_ENABLED_VALIDATORS, self::$_availableValidators);
        $availableValidators = self::$_availableValidators;
        $availableValidators[] = 'WhiteList';
        foreach ($availableValidators as $validatorName) {
            $className = 'CMEB_' . $validatorName;
            include_once CMEB_PATH . '/lib/models/' . $validatorName . '.php';
            $className::init();
        }
        add_filter('cmeb_admin_settings', array(get_class(), 'handleAdminSettings'));
        add_action('register_form', array(get_class(), 'addRegisterFormField'));
        add_filter('registration_errors', array(get_class(), 'verifyDomain'), 100, 3);
    }

    public function isValid($domain) {
        $domain = strtolower(trim($domain));
        $whiteList = new CMEB_WhiteList();
        if ($whiteList instanceof CMEB_Interface && $whiteList->isValid($domain)) {
            $this->_whiteListed = true;
            return true;
        } else {
            foreach (self::$_enabledValidators as $validatorName) {
                $className = 'CMEB_' . $validatorName;
                include_once CMEB_PATH . '/lib/models/' . $validatorName . '.php';
                $validator = new $className();
                if ($validator instanceof CMEB_Interface && !$validator->isValid($domain)) {
                    $this->_blackListed = $validatorName;
                    return false;
                }
            }
            return true;
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
                add_action('login_head', 'wp_shake_js', 12);
                return new WP_Error('authentication_failed', '<strong>ERROR</strong>: ' . self::getErrorMessage());
            }
        } else {
            add_action('login_head', 'wp_shake_js', 12);
            return new WP_Error('authentication_failed', '<strong>ERROR</strong>: E-mail format is not valid.');
        }
        return $errors;
    }

    public static function getErrorMessage() {
        return get_option(self::ERROR_MESSAGE_OPTION, self::DEFAULT_ERROR_MESSAGE);
    }

    public static function handleAdminSettings($params) {
        if (!empty($_POST) && wp_verify_nonce($_POST['_nonce'], 'cmeb_settings')) {
            update_option(self::OPTION_ENABLED_VALIDATORS, !empty($_POST['enabledValidators']) ? $_POST['enabledValidators'] : array());
            update_option(self::ERROR_MESSAGE_OPTION, $_POST['errorMessage']);
            self::$_enabledValidators = get_option(self::OPTION_ENABLED_VALIDATORS, array());
            $params['messages'][] = 'Options updated';
        }
        $params['errorMessage'] = self::getErrorMessage();
        $params['availableValidators'] = self::$_availableValidators;
        $params['enabledValidators'] = self::$_enabledValidators;
        $params['validatorNames'] = array(
            'DNSBL' => 'Use DNSBL online service (<a href="http://www.spamhaus.org/zen/">http://www.spamhaus.org/zen/</a>)',
            'UserList' => 'Use user-defined blacklisted domains',
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
        return $this->_whiteListed;
    }

    public function isBlackListed() {
        return $this->_blackListed;
    }

    public static function addRegisterFormField() {
        ?>
        <style>
            #user_email {margin-bottom:0px;}
            .cmeb_poweredby {clear:both;float:none;font-size:8px;line-height:1.5;margin-bottom:16px;display: inline-block;color:#bbb;text-decoration:none;font-weight:bold}
            .cmeb_poweredby:before {content:'Powered by ';}
        </style>
        <!--// By leaving following snippet in the code, you're expressing your gratitude to creators of this plugin. Thank You! //-->
        <span class="cmeb_poweredby"><a href="http://www.cminds.com/" target="_new">CreativeMinds WordPress Plugin</a> <a href="http://www.cminds.com/plugins/cm-email-blacklist/" target="_new">E-Mail Blacklist</a></span>
        <?php

    }

}
?>
