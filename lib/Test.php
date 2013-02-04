<?php

class CMEB_Test {
    const MENU_OPTION = 'cmeb_tester_menu';

    public static function init() {
        add_action('cmeb_admin_pages', array(get_class(), 'registerAdminPages'));
    }

    public static function registerAdminPages() {
        add_submenu_page(CMEB::MENU_OPTION, 'Tester', 'Tester', 'manage_options', self::MENU_OPTION, array(get_class(), 'displayTesterPage'));
    }

    public static function displayTesterPage() {
        if (!empty($_POST) && !empty($_POST['domain'])) {
            $domain = $_POST['domain'];
            $regex = '/^ (?: [a-z0-9] (?:[a-z0-9\-]* [a-z0-9])? \. )*  #Subdomains
   [a-z0-9] (?:[a-z0-9\-]* [a-z0-9])?            #Domain
   \. [a-z]{2,6} $                               #Top-level domain
/ix';
            if (!preg_match($regex, trim(strtolower($domain)))) {
                $result = false;
                $reason = 'Not a valid domain name';
            } else {
                include_once CMEB_PATH . '/lib/models/Validate.php';
                $validator = new CMEB_Validate();

                $result = $validator->isValid($domain);
                $whiteListed = $validator->isWhiteListed();
                $blackListed = $validator->isBlackListed();
                if ($whiteListed)
                    $reason = 'Domain is whitelisted';
                elseif ($blackListed !== false)
                    $reason = 'Domain is blacklisted in ' . $blackListed;
                else
                    $reason = 'Domain is neither blacklisted nor whitelisted';
            }
        }
        ob_start();
        require(CMEB_PATH . '/views/backend/tester.phtml');
        $content = ob_get_contents();
        ob_end_clean();
        CMEB::displayAdminPage($content);
    }

}

?>
