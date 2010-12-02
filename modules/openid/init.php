<?php

// set the include path
ini_set('include_path', 'modules/openid/vendor');

// start the session
Session::instance();

require_once Kohana::find_file('vendor', 'Auth/OpenID/Consumer');
require_once Kohana::find_file('vendor', 'Auth/OpenID/FileStore');
require_once Kohana::find_file('vendor', 'Auth/OpenID/SReg');
require_once Kohana::find_file('vendor', 'Auth/OpenID/PAPE');
