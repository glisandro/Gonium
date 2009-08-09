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
 * @package     Bootstrap
 * @subpackage  Init_Plugin_Frontend
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 Gonzalo Diaz Cruz
 * @version     $Id$
 */


/** @see Gonium_ACL */
require_once 'Gonium/ACL.php';
/** Core_Model_ACL_Roles */
require_once 'Core/Model/ACL/Role.php';        // Who have the access
/** Core_Model_ACL_Access */
require_once 'Core/Model/ACL/Access.php';        // Rules of access
/** Core_Model_ACL_Resources */
require_once 'Core/Model/ACL/Resource.php';        // Resources to access
/** Core_Model_Modules */
require_once 'Core/Model/Module.php';

/** Zend_Controller_Plugin_Abstract */
require_once 'Zend/Controller/Plugin/Abstract.php';

/**
 * Checks the privileges of the user, to allow or to deny the access to a module
 *
 * @package     Bootstrap
 * @subpackage  Init_Plugin_Frontend
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class Core_Init_Plugin_Frontend_Module extends Zend_Controller_Plugin_Abstract
{
	protected $_acl;

    /**
    * Sets the ACL object
    *
    * @param mixed $aclData
    * @return void
    **/
    public function setAcl(Zend_Acl $aclData)
    {
        $this->_acl = $aclData;
    }

    /**
     * Returns the ACL object
     *
     * @return Zend_Acl
     */
    public function getAcl()
    {
        return $this->_acl;
    }

    /**
     * If has valid ACL returns true. In other case, return false
     *
     * @return boolean
     */
    public function hasAcl()
    {
    	if($this->_acl !== null)
    		return true;

   		return false;
    }

    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {

    	parent::routeStartup($request);
        /*
        if( null === $this->_acl)
        {
            $this->_acl = Zend_Registry::get('core_acl');
        }
        */

        $this->resources =
            Gonium_Controller_Action_Helper_LoadModel::getModel('ACL_Resource');
        $this->access =
            Gonium_Controller_Action_Helper_LoadModel::getModel('ACL_Access');
        $this->roles =
            Gonium_Controller_Action_Helper_LoadModel::getModel('ACL_Role');
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
    	parent::preDispatch($request);
        Zend_Loader::loadClass('Gonium_Controller_Action_Helper_LoadModel');

        if( !$this->hasAcl() )
        {
        	/*

            */
        }
/*
        $modules = Gonium_Controller_Action_Helper_LoadModel::getModel('Modules');

        var_dump( $request->getModuleName() );
        var_dump( $request->getControllerName() );
        var_dump( $request->getActionName() );


        $mod = $request->getModuleName();
        // comprobar si el modulo esta instalado

        if( $mod != 'default' && $mod != 'user' && !ModulesTable::isInstalled($mod) )
        {
            //Redirect to access denied page
            $this->throwError(
                new Exception('Module ['.$mod.'] is not installed')
            );
        }
*/
        //$this->_acl->loadResources( $modules->getResources( array($mod) ) );

        //var_dump( $this->_acl->has( 'mod_'.$mod) );
    }
}