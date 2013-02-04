<?php

include_once CMEB_PATH . '/lib/models/Interface.php';

class CMEB_WhiteList implements CMEB_Interface {
    const MENU_OPTION = 'cmeb_user_whitelist_option';
    const TABLE_NAME = 'cmeb_userlist';

    public function isValid($domain) {
        global $wpdb;
        $sql = "SELECT COUNT(*) FROM " . $wpdb->prefix . self::TABLE_NAME . " WHERE whitelist=1 AND '".$wpdb->escape($domain)."' LIKE REPLACE(domain, '*', '%')";
        $found = $wpdb->get_var($sql);
        return ($found > 0);
    }
    public static function init() {
        add_action('cmeb_admin_pages', array(get_class(), 'registerAdminPages'));
    }
    public static function install() {
        //covered already by UserList
    }
    public static function uninstall() {
        //covered already by UserList
    }
    public static function registerAdminPages() {
        add_submenu_page(CMEB::MENU_OPTION, 'Whitelist', 'Whitelist', 'manage_options', self::MENU_OPTION, array(get_class(), 'displayAdminPage'));
    }

    public static function getUserWhitelist() {
        global $wpdb;
        $sql = "SELECT * FROM " . $wpdb->prefix . self::TABLE_NAME . ' WHERE whitelist=1 ORDER BY domain ASC';
        return $wpdb->get_results($sql);
    }

    public static function displayAdminPage() {
        if (!empty($_POST) && isset($_POST['cmeb_action'])) {
            try {
                self::_processAdminRequest();
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
        }
        $domains = self::getUserWhitelist();
        ob_start();
        require(CMEB_PATH . '/views/backend/user-whitelist.phtml');
        $content = ob_get_contents();
        ob_end_clean();
        CMEB::displayAdminPage($content);
    }

    protected static function _processAdminRequest() {
        switch ($_POST['cmeb_action']) {
            case 'add':
                self::addDomain($_POST['domain']);
                break;
            case 'edit':
                self::editDomain($_POST['domain_id'], $_POST['domain']);
                break;
            case 'delete':
                self::deleteDomain($_POST['domain_id']);
                break;
        }
    }
    public static function sanitizeDomainName($name) {
        $regex = '/(\*{2,})/';
        return strtolower(preg_replace($regex, '*', $name));
    }
    public static function isValidDomainName($name) {
        $regex = '/^(\*|[a-z0-9])([\*\.a-z0-9\-]+)(\*|[a-z])$/';
        $isAsterisk = (strpos($name, '*')!==false);
        $isDot = (strpos($name, '.')!==false);
        return (preg_match($regex, $name) && ($isAsterisk || $isDot) && strlen($name)<=63);
    }
    public static function domainExists($name, $id = null) {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT COUNT(*) FROM " . $wpdb->prefix . self::TABLE_NAME . ' WHERE whitelist=1 AND domain=%s', $name);
        if (!empty($id) && is_numeric($id)) {
            $sql.=' AND id='.$id;
        }
        return ($wpdb->get_var($sql)>0);
    }
    public static function addDomain($name) {
        global $wpdb;
        $name = self::sanitizeDomainName($name);
        if (!self::isValidDomainName($name)) {
            throw new Exception('Domain name ('.$name.') is not valid');
        } elseif (self::domainExists($name)) {
            throw new Exception('Domain ('.$name.') already exists in the system');
        } else {
            $wpdb->insert($wpdb->prefix . self::TABLE_NAME, array('domain' => $name, 'whitelist' => 1));
        }
    }

    public static function editDomain($id, $name) {
        global $wpdb;
        $name = self::sanitizeDomainName($name);
        if (!self::isValidDomainName($name)) {
            throw new Exception('Domain name ('.$name.') is not valid');
        } elseif (self::domainExists($name, $id)) {
            throw new Exception('Domain ('.$name.') already exists in the system');
        } else {
            $wpdb->update($wpdb->prefix . self::TABLE_NAME, array('domain' => $name, 'whitelist' => 1), array('id' => $id));
        }
    }

    public static function deleteDomain($id) {
        global $wpdb;
        $wpdb->delete($wpdb->prefix . self::TABLE_NAME, array('id' => $id));
    }
}

?>
