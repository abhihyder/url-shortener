<?php

use App\Models\Setting;
use App\Utilities\Encryption;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

if (!function_exists('encrypted_value')) {
    function encrypted_value($value)
    {
        return Encryption::encodeId($value);
    }
}

if (!function_exists('decrypted_value')) {
    function decrypted_value($value)
    {
        return Encryption::decodeId($value);
    }
}

if (!function_exists('getAdminSetting')) {

    function getAdminSetting($key)
    {
        $adminSettings = Cache::get('admin_settings', function () {
            $configs =  Setting::get();
            Cache::put('admin_settings', $configs);
            return $configs;
        });

        $value = null;
        foreach ($adminSettings as $adminSetting) {
            if ($adminSetting->key == $key) {
                $value = $adminSetting->value;
            }
        }
        return $value;
    }
}

if (!function_exists('createdBetween')) {

    function createdBetween($model, $request)
    {
        if ($request->date_range) {
            $date = explode(' ', $request->date_range);
            if (count($date) == 1) {
                $model->whereBetween('created_at', [$date[0] . date(' 00:00:00'), $date[0] . date(' 23:59:59')]);
            } else {
                $model->whereBetween('created_at', [$date[0] . date(' 00:00:00'), $date[2] . date(' 23:59:59')]);
            }
        }
        return $model;
    }
}

if (!function_exists('percentageCalculate')) {

    function percentageCalculate($partialValue, $totalValue)
    {
        if ($totalValue > 0 && $partialValue > 0) {
            return (100 * $partialValue) / $totalValue;
        } else {
            return 0;
        }
    }
}

if (!function_exists('valueByPercentage')) {

    function valueByPercentage($value, $percentage)
    {
        if ($value > 0 && $percentage > 0) {
            return number_format((($percentage / 100) * $value), 6);
        } else {
            return 0;
        }
    }
}

if (!function_exists('maskingCharacter')) {

    function maskingCharacter($number, $replaceBy = '*')
    {
        return substr($number, 0, 1) . str_repeat($replaceBy, strlen($number) - 2) . substr($number, -1);
    }
}

if (!function_exists('formatFileSizeUnits')) {
    function formatFileSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}

if (!function_exists('getIP')) {

    function getIP()
    {
        $ip = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}


if (!function_exists('generateSimpleDropdown')) {

    function generateSimpleDropdown($table, $column, $where = null, $selected = null)
    {
        $string = "select id, " . $column . " as column_name from " . $table;
        if ($where) {
            $string .= " where " . $where;
        }
        $string .= " order by " . $column . " asc";
        $query = DB::select($string);

        $htmlContent = "";

        if ($query) {
            foreach ($query as $q) {
                $htmlContent .= "<option value='$q->id'";

                if ($selected && $selected == $q->id) {
                    $htmlContent .= "selected";
                }

                $htmlContent .= ">$q->column_name</option>";
            }
        }
        echo $htmlContent;
    }
}


if (!function_exists('getBrowser')) {

    function getBrowser()
    {
        $u_agent = !empty($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $ub = 'Unknown';
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";
        $pattern = '';
        if (empty($u_agent)) {
            goto rtn;
        }

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac os';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }


        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = 0;
        if (isset($matches['browser'])) {
            $i = count($matches['browser']);
        }
        if ($i > 0) {
            if ($i != 1) {
                //we will have two since we are not using 'other' argument yet
                //see if version is before or after the name
                if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                    $version = $matches['version'][0];
                } else {
                    $version = $matches['version'][1];
                }
            } else {
                $version = $matches['version'][0];
            }
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }
        rtn:
        return array(
            'userAgent' => $u_agent,
            'name' => $bname,
            'version' => $version,
            'platform' => $platform,
            'pattern' => $pattern
        );
    }
}

if (!function_exists('getUserAgent')) {

    function getUserAgent()
    {
        $mobile_browser = '0';

        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $mobile_browser++;
        }

        if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            $mobile_browser++;
        }

        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
            'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
            'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
            'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
            'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
            'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
            'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
            'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
            'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
            'wapr', 'webc', 'winw', 'winw', 'xda ', 'xda-'
        );

        if (in_array($mobile_ua, $mobile_agents)) {
            $mobile_browser++;
        }

        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'OperaMini') > 0) {
            $mobile_browser++;
        }

        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') > 0) {
            $mobile_browser = 0;
        }

        if ($mobile_browser > 0) {
            //Mobile
            return 2;
        } else {
            // Desktop
            return 1;
        }
    }
}

if (!function_exists('getUserAgentDetails')) {

    function getUserAgentDetails()
    {
        $ip = getIP();
        return json_decode(file_get_contents("http://ipinfo.io/" . $ip . "/json"));
    }
}

if (!function_exists('getUserOS')) {

    function getUserOS()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];

        $osPlatforms = array(
            '/windows nt 10/i'      =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($osPlatforms as $regex => $os) {
            if (preg_match($regex, $userAgent)) {
                return $os;
            }
        }

        return 'Unknown OS';
    }
}

if (!function_exists('getBrowserName')) {

    function getBrowserName()
    {
        $browser = getBrowser();
        return isset($browser['name']) ? $browser['name'] : 'Unknown';
    }
}
