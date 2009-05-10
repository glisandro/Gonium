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
 * @version     $Id: Modules.php 153 2009-05-10 21:20:21Z gnzsquall $
 */

/** @see Core_Model_ACL_Resources */
require_once 'Core/Model/ACL/Resources.php';

/**
 * @category    Gonium
 * @package     Core_Model
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: Modules.php 153 2009-05-10 21:20:21Z gnzsquall $
 */
class Core_Model_Modules extends Core_Model_ACL_Resources
{
    public $_name = 'core_modules';
    //public $_name = 'acl_resources';
    public $_primary = 'directory';
    //public $_primary = 'resource_id';
    protected $_scope = 'module';

    /**
    * @return Array of Resources
    */
    public function getResources(Array $resource_ids = array() )
    {
        $db = Zend_Registry::get('core_db');
        $results = array();
        $nodes_found = array();

        do {
            $select = $db->select()
            ->distinct()
            ->from( array('mod' => $this->_name) )
            ->joinLeft( array( 'res' => Rox_Db_Table_Abstract::getPrefix().'acl_resources'),
                    'mod.resource_id = res.resource_id',
                    array( 'resource_id', 'parent_id' ) );

            // Si hay varios recursos, tratarlos como "Or Where"
            foreach( $resource_ids as $resource_id)
            {
                if( is_scalar($resource_id) )
                    $select->orWhere('res.resource_id = ?', 'mod_'.$resource_id);
            }

            $orWhere = $select->getPart( Zend_Db_Select::WHERE );
            $select->reset( Zend_Db_Select::WHERE );

            $resource_ids = array();

            if( !empty($orWhere) )
                $select->orWhere( implode(' ', $orWhere), null, Zend_Db_Select::SQL_WHERE);

            $select->where('scope = ?', $this->_scope );

            //$result = $db->fetchAll( $select );

            // Mezclar resultados
            $results = array_merge( $results, $result = $db->fetchAll( $select ) );

            // Buscar posible padres
            //$add = 0;
            foreach($result as $res)
            {
                if( !in_array($res['resource_id'], $nodes_found) )
                    $nodes_found[$res['resource_id']] = $res['resource_id'];

                if( $res['parent_id'] != NULL && !in_array($res['parent_id'], $nodes_found) )
                    $resource_ids[] = $res['parent_id'];
            }
        } while( !empty( $resource_ids ) );

        if($this->_iterable)
        {
            $this->_result = array_reverse($results);
            return $this;
        }

        return $results;
    }

    public static function getModules()
    {
        $table = new ModulesTable();

        $select = $table->select()
            ->from($table->_name, '*');

        return $table->fetchAll( $select );
    }

    public static function isInstalled($mod)
    {
        $table = new ModulesTable();
        $db = $table->getAdapter();

        $select = $table->select();
        $select
            ->from($table->_name, '*')
            ->where( $db->quoteInto('directory = ?', $mod ) );

        return !is_null($table->fetchRow( $select ));
    }

    /*
    public static function createNewComments($data)
    {
        $commentsTable = new CommentsTable();
        $comment = $commentsTable->createRow($data);
        $comment->save();
    }
    */
}
