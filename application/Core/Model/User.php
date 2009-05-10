<?php
/**
 * Gonium, Zend Framework based Content Manager System.
 *  Copyright (C) 2008 Gonzalo Diaz Cruz
 *
 * LICENSE
 *
 * Gonium is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or any
 * later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * @category    Gonium
 * @package     Core_Model
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: User.php 153 2009-05-10 21:20:21Z gnzsquall $
 */

/** Zend_Auth */
require_once 'Zend/Auth.php';
/** @see Rox_Model_Abstract */
require_once 'Rox/Db/Table/Abstract.php';
/** @see Rox_Model_User_Interface */
require_once 'Rox/Model/User/Interface.php'; 

/**
 * @category    Gonium
 * @package     Core_Model
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: User.php 153 2009-05-10 21:20:21Z gnzsquall $
 */
class Core_Model_User 
    extends Rox_Db_Table_Abstract
    implements Rox_Model_User_Interface 
{
    public $_name = 'core_users';
    public $_primary = 'uid';
    
    protected static $_identityColumn = 'username';
    protected static $_credentialColumn = 'password';
    
    public static function getIdentityColumn()
    {
    	return self::$_identityColumn;
    }
    
    public static function getCredentialColumn()
    {
        return self::$_credentialColumn;
    }

    public function getID($username)
    {
        $table =new self();
        $db = $table->getAdapter();

        $select = $table->select();
        $select
            ->from($table->_name, 'uid')
            ->where( $db->quoteInto('username = ?', $username ) );

        $result = $table->fetchRow( $select );

        if( is_null($result) )
            return null;
        else
            return $result->uid;
    }
    
    /**
     * Create a new user account. Password is encoded in SHA1 
     */
    public function create($username, $password)
    {
    	$this->insert(array(
    	   'username' => $username, 
    	   'password' => sha1($password)
    	));
    }
}
