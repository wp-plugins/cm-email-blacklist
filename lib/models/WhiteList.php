<?php
class CMEB_WhiteList {

    const MENU_OPTION = 'cmeb_user_whitelist_option';
    const TABLE_NAME = 'cmeb_userlist';

    public static function isValid($domain) {
        global $wpdb;
        $sql = "SELECT COUNT(*) FROM " . $wpdb->prefix . self::TABLE_NAME . " WHERE whitelist=1 AND '" . esc_sql($domain) . "' LIKE REPLACE(domain, '*', '%')";
        $found = $wpdb->get_var($sql);
        return ($found > 0);
    }

    public static function install() {
        //covered already by UserList
    }

    public static function uninstall() {
        //covered already by UserList
    }

    public static function getUserWhitelist() {
        global $wpdb;
        $sql = "SELECT * FROM " . $wpdb->prefix . self::TABLE_NAME . ' WHERE whitelist=1 ORDER BY domain ASC';
        return $wpdb->get_results($sql);
    }

    public static function _processAdminRequest() {
        isset($_POST['cmeb_white'])?$var = $_POST['cmeb_white']: $var = $_GET['cmeb_white'];
        switch ($var) {
            case 'add':
                self::addDomain($_POST['white_domain']);
                break;
            case 'edit':
                $ids = $_POST['white_id'];
                $domains = $_POST['white_domain'];
                foreach ($ids as $key => $id) {
                    self::editDomain($id, $domains[$key]);
                }
                break;
            case 'delete':
                self::deleteDomain($_GET['white_id']);
                break;
        }
       // $url = admin_url().'?page=cmeb_menu#tab-whitelist';
       // wp_redirect($url);
    }

    public static function sanitizeDomainName($name) {
        $regex = '/(\*{2,})/';
        return strtolower(preg_replace($regex, '*', $name));
    }

    public static function isValidDomainName($name) {
        $regex = '/^(\*|[a-z0-9])([\*\.a-z0-9\-]+)(\*|[a-z])$/';
        $isAsterisk = (strpos($name, '*') !== false);
        $isDot = (strpos($name, '.') !== false);
        return (preg_match($regex, $name) && ($isAsterisk || $isDot) && strlen($name) <= 63);
    }

    public static function domainExists($name, $id = null) {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT COUNT(*) FROM " . $wpdb->prefix . self::TABLE_NAME . ' WHERE whitelist=1 AND domain=%s', $name);
        if (!empty($id) && is_numeric($id)) {
            $sql.=' AND id=' . $id;
        }
        return ($wpdb->get_var($sql) > 0);
    }

    public static function addDomain($name) {
        global $wpdb;
        $name = self::sanitizeDomainName($name);
        if (!self::isValidDomainName($name)) {
            throw new Exception('Domain name (' . $name . ') is not valid');
        } elseif (self::domainExists($name)) {
            throw new Exception('Domain (' . $name . ') already exists in the system');
        } else {
            $wpdb->insert($wpdb->prefix . self::TABLE_NAME, array('domain' => $name, 'whitelist' => 1));
            $id = $wpdb->insert_id; //last insert
        }
    }

    public static function editDomain($id, $name) {
        global $wpdb;
        $name = self::sanitizeDomainName($name);
        if (!self::isValidDomainName($name)) {
            throw new Exception('Domain name (' . $name . ') is not valid');
        } elseif (self::domainExists($name, $id)) {
            throw new Exception('Domain (' . $name . ') already exists in the system');
        } else {
            $wpdb->update($wpdb->prefix . self::TABLE_NAME, array('domain' => $name, 'whitelist' => 1), array('id' => $id));
        }
    }

    public static function deleteDomain($id) {
        global $wpdb;
        $wpdb->delete($wpdb->prefix . self::TABLE_NAME, array('id' => $id));
    }
}
