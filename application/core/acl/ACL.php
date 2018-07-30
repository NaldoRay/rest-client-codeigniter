<?php

/**
 * Project name: SIA DEV
 * Author: Avin
 * Date & Time: 7/6/2018 - 8:51 PM
 */
class ACL
{
    function check_acl ()
    {
        require_once(APPPATH . "core/acl/acl_helper.php");

        // session di-start oleh CAS
        $this->initCas();
        if (!$this->isAuthenticated())
        {
            $this->forceAuthentication();
            return;
        }
    }

    function checkFunction ()
    {
        $username = $this->getUsername();
        if (getUsername() != $username)
        {
            setUsername($username);

            // refresh token
            $CI = get_instance();
            $CI->load->service(ACL_Service::class);
            $authResponse = $CI->acl_service->authorizeUser(getAppId(), getUserId());
            if ($authResponse->success)
            {
                $auth = $authResponse->data;
                APP_Web_service::setAccessToken($auth->token);
                setName($auth->name);
                setGroupUserName($auth->unit);
            }
            else
            {
                if ($authResponse->statusCode == 401)
                    logoutToTheMax(site_url());
                else
                    show_error($authResponse->error->message, 401);
            }
        }

        $CI = get_instance();
        $controller = getControllerName();
        $function = getFunctionName();

        /*cek logout jika logout token dihapus*/
        if ($function == "logout")
        {
            $CI->load->service(ACL_Service::class);
            $CI->acl_service->logout();
            return;
        }

        $noAppl = $CI->config->item('id_appl');
        $userId = getUserId();

        /*user punya akses*/
        $arrData = ['idAppl' => $noAppl, 'username' => $userId];
        $CI->load->service(ACL_Service::class);
        $access = $CI->acl_service->getUserMenu($arrData);
        if ($access->success)
        {
            $menuArr = $access->data;


            $accessible = false;
            foreach ($menuArr as $menu)
            {
                if ($menu->controller == $controller && $menu->function == $function)
                {
                    $accessible = true;
                    break;
                }
            }

            if ($accessible)
            {
                setAcl($menuArr);
            }
            else
            {
                show_error("Forbidden Menu", 403);
            }
        }
    }

    private function initCas ()
    {
        if (!function_exists('curl_init'))
        {
            echo '<strong>ERROR:</strong> You need to install the PHP module
				<strong><a href="http://php.net/curl">curl</a></strong> to be able
				to use CAS authentication.';
        }

        $phpcas_path = APPPATH . 'third_party/CAS-1.3.5/';
        $cas_server_url = 'https://sso.unpar.ac.id';

        if (empty($phpcas_path)
            or filter_var($cas_server_url, FILTER_VALIDATE_URL) === FALSE
        )
        {
            $this->cas_show_config_error();
        }
        $cas_lib_file = $phpcas_path . '/CAS.php';
        if (!file_exists($cas_lib_file))
        {
            echo("<strong>ERROR:</strong> Could not find a file <em>CAS.php</em> in directory
				<strong>$phpcas_path</strong><br /><br />
				Please, check your config file <strong>config/cas.php</strong> and make sure the
				configuration <em>phpcas_path</em> is a valid phpCAS installation.");
        }
        require_once $cas_lib_file;

        if (true)
        {
            phpCAS::setDebug();
        }

        // init CAS client
        $defaults = array('path' => '', 'port' => 443);
        $cas_url = array_merge($defaults, parse_url($cas_server_url));

        if (session_status() == PHP_SESSION_NONE)
            phpCAS::client(CAS_VERSION_2_0, $cas_url['host'], $cas_url['port'], $cas_url['path']); //let phpCAS manage the session
        else
            phpCAS::client(CAS_VERSION_2_0, $cas_url['host'], $cas_url['port'], $cas_url['path'], false);  //use existing session

        // configures SSL behavior
        $disableServerValidation = TRUE;
        if ($disableServerValidation)
        {
            phpCAS::setNoCasServerValidation();
        }
        else
        {
            $ca_cert_file = NULL;
            if (empty($ca_cert_file))
            {
                $this->cas_show_config_error();
            }
            else
            {
                phpCAS::setCasServerCACert($ca_cert_file);
            }
        }
    }

    private function cas_show_config_error ()
    {
        echo("CAS authentication is not properly configured.<br /><br />
	Please, check your configuration for the following file:
	<code>config/cas.php</code>
	The minimum configuration requires:
	<ul>
	   <li><em>cas_server_url</em>: the <strong>URL</strong> of your CAS server</li>
	   <li><em>phpcas_path</em>: path to a installation of
	       <a href=\"https://wiki.jasig.org/display/CASC/phpCAS\">phpCAS library</a></li>
	    <li>and one of <em>cas_disable_server_validation</em> and <em>cas_ca_cert_file</em>.</li>
	</ul>
	");
    }

    /**
     *  Return
     */
    private function getUsername ()
    {
        if ($this->isAuthenticated())
        {
            return phpCAS::getUser();
        }
        else
        {
            $this->forceAuthentication();
            return null;
        }
    }

    private function isAuthenticated ()
    {
        return phpCAS::isAuthenticated();
    }

    /**
     * Trigger CAS authentication if user is not yet authenticated.
     */
    private function forceAuthentication ()
    {
        phpCAS::forceAuthentication();
    }

}