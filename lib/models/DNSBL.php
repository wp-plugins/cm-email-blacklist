<?php

include_once CMEB_PATH . '/lib/models/Interface.php';

class CMEB_DNSBL implements CMEB_Interface {
    const DNSBL_HOST = 'zen.spamhaus.org';

    public function isValid($domain) {
        $ip = gethostbyname($domain);
        if ($ip && filter_var($ip, FILTER_VALIDATE_IP)) {
            $reverse_ip = implode(".", array_reverse(explode(".", $ip)));
            $on_win = substr(PHP_OS, 0, 3) == "WIN" ? 1 : 0;
            if (function_exists("checkdnsrr")) {
                if (checkdnsrr($reverse_ip . "." . self::DNSBL_HOST . ".", "A")) {
                    return false;
                }
            } else if ($on_win == 1) {
                $lookup = "";
                @exec("nslookup -type=A " . $reverse_ip . "." . self::DNSBL_HOST . ".", $lookup);
                foreach ($lookup as $line) {
                    if (strstr($line, self::DNSBL_HOST)) {
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }
    public static function init() {
        
    }
    public static function install() {
        
    }

    public static function uninstall() {
        
    }

}

?>
