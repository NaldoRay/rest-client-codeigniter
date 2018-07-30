<?php
/**
 * Project name: sikur
 * Author: Avin
 * Date & Time: 4/2/2018 - 9:47 PM
 */

if (!function_exists('getUsername')) {
    function getUsername()
    {
        return isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
    }
}

if (!function_exists('getControllerName')) {
    function getControllerName()
    {
        $CI = get_instance();
        return $CI->router->fetch_class();
    }
}

if (!function_exists('getFunctionName')) {
    function getFunctionName()
    {
        $CI = get_instance();
        return $CI->router->fetch_method();
    }
}

if (!function_exists('getAppId')) {
    function getAppId()
    {
        $CI = get_instance();
        return $CI->config->item('id_appl');
    }
}

if (!function_exists('getUserId')) {
    function getUserId()
    {
        $username = getUsername();
        if (is_null($username)) {
            return null;
        } else {
            $parts = explode('@', $username);
            return $parts[0];
        }
    }
}

if (!function_exists('setUsername')) {
    function setUsername($username)
    {
        $_SESSION['username'] = $username;
    }
}

if (!function_exists('setGroupUser')) {
    function setGroupUserName($group_user_name)
    {
        $_SESSION['group_user_name'] = $group_user_name;
    }
}

if (!function_exists('getGroupUserName')) {
    function getGroupUserName()
    {
        return isset($_SESSION['group_user_name']) ? $_SESSION['group_user_name'] : NULL;
    }
}

if (!function_exists('setName')) {
    function setName($name)
    {
        $_SESSION['name'] = $name;
    }
}

if (!function_exists('getName')) {
    function getName()
    {
        return isset($_SESSION['name']) ? $_SESSION['name'] : NULL;
    }
}

if (!function_exists('setAcl')) {
    function setAcl($menuArr)
    {
        $GLOBALS['ArrAclMenu'] = $menuArr;
    }
}

if (!function_exists('getUserFakultasArr')) {
    function getUserFakultasArr($groupId = null)
    {
        if ($groupId == null) {
            $fakultas = [];
            foreach ($GLOBALS['arrGroupProdiUnit'] as $groupId => $groupProdi) {
                foreach ($groupProdi as $row) {
                    if (!in_array($row->id_fak, $fakultas)) {
                        $fakultas[] = $row->id_fak;
                    }
                }
            }
            return $fakultas;
        } else {
            $fakultas = [];
            foreach ($GLOBALS['arrGroupProdiUnit'][$groupId] as $row) {
                if (!in_array($row->id_fak, $fakultas)) {
                    $fakultas[] = $row->id_fak;
                }
            }
            return $fakultas;
        }
    }
}

if (!function_exists('getUserProdiArr')) {
    function getUserProdiArr($groupId = null)
    {
        if ($groupId == null) {
            $prodi = [];
            foreach ($GLOBALS['arrGroupProdiUnit'] as $groupId => $groupProdi) {
                foreach ($groupProdi as $row) {
                    if (!in_array($row->id_prodi, $prodi)) {
                        $prodi[] = $row->id_prodi;
                    }
                }
            }
            return $prodi;
        } else {
            $prodi = [];
            foreach ($GLOBALS['arrGroupProdiUnit'][$groupId] as $row) {
                if (!in_array($row->id_prodi, $prodi)) {
                    $prodi[] = $row->id_prodi;
                }
            }
            return $prodi;
        }
    }
}

if (!function_exists('getUserGroupId')) {
    function getUserGroupId()
    {
        $group_id = [];
        if (isset($GLOBALS['group'])) {
            foreach ($GLOBALS['group'] as $row) {
                $group_id[] = $row->id_group;
            }
        }
        return $group_id;
    }
}

if (!function_exists('getUserUnit')) {
    function getUserUnit()
    {
        $kode_unit = [];
        if (isset($GLOBALS['group'])) {
            foreach ($GLOBALS['group'] as $row) {
                $kode_unit[] = $row->kode_unit;
            }
        }
        return $kode_unit;
    }
}

if (!function_exists('cekLink')) {
    function cekLink($link)
    {
        if (!isset($GLOBALS[$link])) {
            $CI = get_instance();
            $CI->load->library(ACL_Service::class);

            $username = getUsername();
            $parts = explode('@', $username);
            $userId = $parts[0];
            $idAppl = $CI->config->item('id_appl');

            $arrCek = ['idAppl' => $idAppl, 'username' => $userId, 'link' => $link];
            $cek = $CI->acl_service->cekLink($arrCek);
            $GLOBALS[$link] = $cek->success;
        }

        return $GLOBALS[$link];
    }
}

if (!function_exists('menuAcl')) {

    function menuAcl()
    {
        $access = isset($GLOBALS['ArrAclMenu']) ? $GLOBALS['ArrAclMenu'] : array();
        $access = groupObjectArray($access, ['id_parent']);

        if ($access) {
            foreach ($access['00000'] as $row) {
                $menu = $row->menu;
                $id_parent = $row->id_parent;
                $id_menu = $row->id_menu;
                $f_menu = $row->f_menu;
                $nomor_urut = $row->nomor_urut;
                $required = $row->f_required;
                if (empty($row->link_menu)) {
                    if ($f_menu == 1) {
                        echo '<li aria-haspopup="true" class="menu-dropdown mega-menu-dropdown">
                                <a href="javascript:;">' . $menu . '
                                    <span class="arrow"></span>
                                </a>' .
                            menuSubAcl($access, $id_menu) . '
                            </li>';
                    }
                } else if ($f_menu) {
                    if ($required == 1) {
                        if (preg_match('/(http:|https:)/', $row->link_menu)) {
                            echo '<li aria-haspopup="true" class=" ">
                                <a target="_blank" href="' . $row->link_menu . '" class="nav-link  ">' . $menu . '
                                    <span style="color:red"> *</span></a>' . '
                                    </li>';
                        } else {
                            echo '<li aria-haspopup="true" class=" ">
                                <a href="' . base_url($row->link_menu) . '" class="nav-link  ">' . $menu . '
                                    <span style="color:red"> *</span></a>' . '
                                    </li>';
                        }
                    } else {
                        if (preg_match('/(http:|https:)/', $row->link_menu)) {
                            echo '<li aria-haspopup="true" class=" ">
                                <a target="_blank" href="' . $row->link_menu . '" class="nav-link  ">' . $menu . '</a>' . '
                                </li>';
                        } else {
                            echo '<li aria-haspopup="true" class=" ">
                                <a href="' . base_url($row->link_menu) . '" class="nav-link  ">' . $menu . '</a>' . '
                                </li>';
                        }
                    }
                }
            }
        }
    }

    function menuSubAcl($access, $id_parent)
    {
        $temp = "";
        if (!empty($access[$id_parent])) {
            $temp = '<ul class="dropdown-menu" style="min-width: 100px ">';
            foreach ($access[$id_parent] as $rows) {
                $menus = $rows->menu;
                if ($rows->f_menu == 1) {
                    if (empty($access[$rows->id_menu])) {
                        if ($rows->f_required != 1) {
                            if (preg_match('/(http:|https:)/', $rows->link_menu)) {
                                $temp .= '<li aria-haspopup="true" class=" ">
                                            <a target="_blank" href="' . $rows->link_menu . '" class="nav-link  ">' . $menus . '
                                            </a>' . menuSubAcl($access, $rows->id_menu) .
                                    '</li>';
                            } else {
                                $temp .= '<li aria-haspopup="true" class=" ">
                                            <a href="' . base_url($rows->link_menu) . '" class="nav-link  ">' . $menus . '
                                            </a>' . menuSubAcl($access, $rows->id_menu) .
                                    '</li>';
                            }
                        } else {
                            if (preg_match('/(http:|https:)/', $rows->link_menu)) {
                                $temp .= '<li aria-haspopup="true" class=" ">
                                        <a target="_blank" href="' . $rows->link_menu . '">' . $menus .
                                    '<span style="color:red"> *</span></a>' . menuSubAcl($access, $rows->id_menu) .
                                    '</li>';
                            } else {
                                $temp .= '<li aria-haspopup="true" class=" ">
                                        <a href="' . base_url($rows->link_menu) . '">' . $menus .
                                    '<span style="color:red"> *</span></a>' . menuSubAcl($access, $rows->id_menu) .
                                    '</li>';
                            }
                        }
                    } else {
                        if (preg_match('/(http:|https:)/', $rows->link_menu)) {
                            $temp .= '<li aria-haspopup="true" class="menu-dropdown mega-menu-dropdown">
                                    <a target="_blank" href="' . $rows->link_menu . '">' . $menus . '
                                        <span class="arrow"></span>
                                    </a>' . menuSubAcl($access, $rows->id_menu) . '
                                  </li>';
                        } else {
                            $temp .= '<li aria-haspopup="true" class="menu-dropdown mega-menu-dropdown">
                                    <a href="' . base_url($rows->link_menu) . '">' . $menus . '
                                        <span class="arrow"></span>
                                    </a>' . menuSubAcl($access, $rows->id_menu) . '
                                  </li>';
                        }
                    }
                }
            }
            $temp .= '</ul>';
        }
        return $temp;
    }
}

if (!function_exists('logoutToTheMax')) {
    function logoutToTheMax($url = '')
    {
        session_destroy();
        phpCAS::logoutWithRedirectService($url);
    }
}



