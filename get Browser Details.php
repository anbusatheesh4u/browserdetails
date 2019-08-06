function _getBrowser() {
        $user_agent     =   $_SERVER['HTTP_USER_AGENT'];
        $browser        =   "Unknown Browser";
        $browser_array  =   array(
                                '/msie/i'       =>  'Internet Explorer',
                                '/firefox/i'    =>  'Firefox',
                                '/safari/i'     =>  'Safari',
                                '/chrome/i'     =>  'Chrome',
                                '/opera/i'      =>  'Opera',
                                '/netscape/i'   =>  'Netscape',
                                '/maxthon/i'    =>  'Maxthon',
                                '/konqueror/i'  =>  'Konqueror',
                                '/mobile/i'     =>  'Handheld Browser'
                            );
        foreach ($browser_array as $regex => $value) { 
            if (preg_match($regex, $user_agent)) {
                $browserName    =   $value;
            }
        }

        //get the correct version number
        $known = array('Version', $browserName, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $user_agent, $matches)) {
            // we have no matching number just continue
        }
        
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //see if version is before or after the name
            if (strripos($user_agent,"Version") < strripos($user_agent,$browserName)){
                $version= $matches['version'][0];
            }
            else {
                $version= $matches['version'][1];
            }
        }
        else {
            $version= $matches['version'][0];
        }
        // check if we have a number
        if ($version==null || $version=="")
        {
            $version="?";
        }
        
        $_AbrowserDetails = array(
            'userAgent' => $user_agent,
            'name'      => $browserName,
            'version'   => $version,
            'pattern'   => $pattern
        );
        $_Abrowser = $_AbrowserDetails['name'].$_AbrowserDetails['version'];
        return $_Abrowser;
    }
