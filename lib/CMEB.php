<?php
include_once CMEB_PATH . '/lib/models/Validate.php';
include_once CMEB_PATH . '/backend/classes/Settings.php';

class CMEB {

    public static $cssPath = null;
    public static $class = null;

    const MENU = 'cmeb_menu';
    const MENU_ABOUT = 'cmeb_menu_about';
    const MENU_SETTINGS = 'cmeb_menu_settings';
    const MENU_LICENSE = 'cmeb_menu_license';
    const MENU_UPGRADE = 'cmeb_menu_upgrade';

    public static $isLicenseOK = NULL;

    public static function init() {
        CMEB_Validate::init();
        self::$class = __CLASS__;
        self::$cssPath = CMEB_URL . '/backend/assets/css/';
        add_action('admin_enqueue_scripts', array(self::$class, 'cmeb_settings_style'));
        add_action('admin_menu', array(self::$class, 'registerAdminPages'));
    }

    public static function install() {
        include_once CMEB_PATH . '/lib/models/Validate.php';
        CMEB_Validate::install();
    }

    public static function uninstall() {
        include_once CMEB_PATH . '/lib/models/Validate.php';
        CMEB_Validate::uninstall();
    }

    public static function registerAdminPages() {
        add_menu_page('Settings', 'CM E-Mail Registration Blacklist', 'manage_options', self::MENU, array(get_class(), 'displayAdminOptions'), '');
        do_action('cmeb_admin_pages');
        //add_submenu_page(self::MENU, 'CM Email Blacklist About', 'Settings', 'manage_options', self::MENU_SETTINGS, array(get_class(), 'displayAdminOptions'));
        add_submenu_page(self::MENU, 'CM Email Blacklist About', 'About', 'manage_options', self::MENU_ABOUT, array(get_class(), 'displayAboutPage'));
        add_submenu_page(self::MENU, 'CM Email Blacklist Upgrade', 'Upgrade to Pro', 'manage_options', self::MENU_UPGRADE, array(get_class(), 'displayUpgradePage'));
    }

    public static function getAdminNav() {
        global $submenu, $plugin_page, $pagenow;
        ob_start();
        $submenus = array();
        if (isset($submenu[self::MENU])) {
            $thisMenu = $submenu[self::MENU];
            foreach ($thisMenu as $item) {
                $slug = $item[2];
                $slugParts = explode('?', $slug);
                $name = '';
                if (count($slugParts) > 1)
                    $name = $slugParts[0];
                $isCurrent = ($slug == $plugin_page || (!empty($name) && $name === $pagenow));
                $url = (strpos($item[2], '.php') !== false) ? $slug : get_admin_url('', 'admin.php?page=' . $slug);
                $submenus[] = array(
                    'link' => $url,
                    'title' => $item[0],
                    'current' => $isCurrent
                );
            }

            require(CMEB_PATH . '/backend/views/nav.phtml');
        }
        $nav = ob_get_contents();
        ob_end_clean();
        return $nav;
    }

    public static function displayAdminPage($content) {
        $nav = self::getAdminNav();
        require CMEB_PATH . '/backend/views/template.phtml';
    }

    public static function displayAdminOptions() {

        if (class_exists('CMProductCatalog')) {
            $params = apply_filters('cmeb_admin_settings', array());
            extract($params);
            ob_start();
            require(CMEB_PATH . '/backend/views/settings.phtml');
            $content = ob_get_contents();
            ob_end_clean();
        } else {
            ?><div id="message" class="updated fade"><p><strong>You need to have CM Product Catalog Plugin</strong></p></div>
            <?php
        }
        self::displayAdminPage($content);
    }

    public static function cmeb_settings_style() {
        if (!empty($_GET['page'])) {
            $page = $_GET['page'];
            if ($page === 'cmeb_menu_settings' || $page === 'cmeb_menu') {
                wp_enqueue_style('jquery-ui-tabs-css', self::$cssPath . 'jquery-ui-tabs.css');
                wp_enqueue_script('jquery-ui-tabs', false, array(), false, true);
            }
        }
    }

    public static function displayAboutPage() {
        ob_start();
        require(CMEB_PATH . '/backend/views/about.phtml');
        $content = ob_get_contents();
        ob_end_clean();
        self::displayAdminPage($content);
    }
    public static function displayUpgradePage() {
        wp_enqueue_style('cmbl-upgrade', self::$cssPath . 'cmbl-get-pro.css');
        ob_start();
        require(CMEB_PATH . '/backend/views/upgrade.phtml');
        $content = ob_get_contents();
        ob_end_clean();
        self::displayAdminPage($content);
    }

}
?>
