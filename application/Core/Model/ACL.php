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
 * @package     Core_Model
 * @subpackage  Core_Model_ACL
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: ACL.php 153 2009-05-10 21:20:21Z gnzsquall $
 */

/** @see Rox_Db_Table_Abstract */
require_once 'Rox/Db/Table/Abstract.php';
/** @see Core_Model_ACL_Roles */
require_once 'Core/Model/ACL/Roles.php';
/** @see Core_Model_ACL_Access */
require_once 'Core/Model/ACL/Access.php';
/** @see Core_Model_ACL_Resources */
require_once 'Core/Model/ACL/Resources.php';


/**
 *
 * Database structure:
 *
 * +------------------+       +----------------+       +-------------+      +--------------+
 * |    Resources     |       |    Access      |       |   Roles     |      |  Inheritance |
 * +------------------+       +----------------+       +-------------+      +--------------+
 * | *id              |<--.   | *role_id       |------>| *id         |<-----| *child_id    |
 * | parent_id        |---'`--| *resource_id  N|       +-------------+   `--| *parent_id   |
 * | *privilege      N|<------| *privilege    N|                            | order        |
 * +------------------+       | allow          |                            +--------------+
 *                            +----------------+
 *
 *
 *   *field = PRIMARY KEY( field )
 *   -----> = foreign key constraint
 *
 *   The actual table names should be: Rox_acl_resources, Rox_acl_access, acl_roles, Rox_acl_inheritance.
 *
 * access.allow is a boolean field, that specifies whether the respective rule is an allow rule or a deny rule (important for inherited access).
 *
 */

/**
 * @category    Gonium
 * @package     Core_Model
 * @subpackage  Core_Model_ACL
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: ACL.php 153 2009-05-10 21:20:21Z gnzsquall $
 */
class Core_Model_ACL extends Rox_Model_Abstract // implements Rox_Model_Resource_Interface // , Rox_Model_Roles_Interface, Rox_Model_Access_Interface
{
	/*
    public static function getResources($resources_id = null)
    {
        $resTable = new ResourcesTable($resources_id);
    }
    */
}


