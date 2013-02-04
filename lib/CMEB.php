<?php
include_once CMEB_PATH.'/lib/models/Validate.php';
include_once CMEB_PATH.'/lib/Test.php';
class CMEB {
    const MENU_OPTION = 'cmeb_menu_option';
    const MENU_ABOUT = 'cmeb_menu_about';

    public static function init() {
        CMEB_Validate::init();
        add_action('admin_menu', array(get_class(), 'registerAdminPages'));
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
        add_menu_page('Settings', 'CM Email Blacklist', 'manage_options', self::MENU_OPTION, array(get_class(), 'displayAdminOptions'), '');
        CMEB_Test::init();
        do_action('cmeb_admin_pages');
        
        add_submenu_page(self::MENU_OPTION, 'CM Email Blacklist About', 'About', 'manage_options', self::MENU_ABOUT, array(get_class(), 'displayAboutPage'));
    }

    public static function getAdminNav() {
        global $submenu, $plugin_page, $pagenow;
        ob_start();
        $submenus = array();
        if (isset($submenu[self::MENU_OPTION])) {
            $thisMenu = $submenu[self::MENU_OPTION];
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
            require(CMEB_PATH . '/views/backend/nav.phtml');
        }
        $nav = ob_get_contents();
        ob_end_clean();
        return $nav;
    }

    public static function displayAdminPage($content) {
        $nav = self::getAdminNav();
        require CMEB_PATH . '/views/backend/template.phtml';
    }

    public static function displayAdminOptions() {
        $params = apply_filters('cmeb_admin_settings', array());
        extract($params);
        ob_start();
        require(CMEB_PATH . '/views/backend/settings.phtml');
        $content = ob_get_contents();
        ob_end_clean();
        self::displayAdminPage($content);
    }

    public static function displayAboutPage() {
        ob_start();
        require(CMEB_PATH . '/views/backend/about.phtml');
        $content = ob_get_contents();
        ob_end_clean();
        self::displayAdminPage($content);
    }

}

?>
