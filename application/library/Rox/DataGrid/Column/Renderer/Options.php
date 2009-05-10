<?php
/**
 * Zsamer Framework
 *
 * Rox_DataGrid_Column_Renderer_Options
 *
 * It class to provide a Grid column widget for rendering grid cells that contains mapped values
 *
 * @package     Rox_DataGrid
 * @subpackage  Rox_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Options.php 115 2008-12-03 03:01:49Z gnzsquall $
 */

/**
 * @package     Rox_DataGrid
 * @subpackage  Rox_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Options.php 115 2008-12-03 03:01:49Z gnzsquall $
 */
class Rox_DataGrid_Column_Renderer_Options extends Rox_DataGrid_Column_Renderer_Text
{
    public function render($row)
    {
        $options = $this->getColumn()->getOptions();
        if (!empty($options) && is_array($options)) {
            $value = $row[$this->getColumn()->getIndex()];
            if (is_array($value)) {
                $res = array();
                foreach ($value as $item) {
                    $res[] = isset($options[$item]) ? $options[$item] : $item;
                }
                return implode(', ', $res);
            }
            elseif (isset($options[$value])) {
                return $options[$value];
            }
        }
        return '';
    }

}
