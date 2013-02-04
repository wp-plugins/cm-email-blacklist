<?php
interface CMEB_Interface {
    /**
     * Checks if domain is not blacklisted
     * @param string $domain
     * @return boolean
     */
    public function isValid($domain);
    public static function install();
    public static function uninstall();
}
?>
