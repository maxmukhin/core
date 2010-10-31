<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * LiteCommerce
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@litecommerce.com so we can send you a copy immediately.
 * 
 * @category   LiteCommerce
 * @package    XLite
 * @subpackage Includes_Decorator
 * @author     Creative Development LLC <info@cdev.ru> 
 * @copyright  Copyright (c) 2010 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version    SVN: $Id$
 * @link       http://www.litecommerce.com/
 * @see        ____file_see____
 * @since      3.0.0
 */

namespace Includes\Decorator;

/**
 * ADecorator 
 * 
 * @package    XLite
 * @see        ____class_see____
 * @since      3.0.0
 */
abstract class ADecorator
{
    /**
     * Indexes in "classesInfo" array
     *
     * FIXME - to remove
     */

    const INFO_FILE          = 'file';
    const INFO_CLASS         = 'class';
    const INFO_CLASS_ORIG    = 'class_orig';
    const INFO_EXTENDS       = 'extends';
    const INFO_EXTENDS_ORIG  = 'extends_orig';
    const INFO_IS_DECORATOR  = 'is_decorator';
    const INFO_IS_ROOT_CLASS = 'is_top_class';
    const INFO_CLASS_TYPE    = 'class_type';
    const INFO_ENTITY        = 'entity';
    const INFO_CLASS_COMMENT = 'class_comment';


    /**
     * Class node field names
     */

    const N_NAME_SPACE    = 'nameSpace';
    const N_CLASS_COMMENT = 'classComment';
    const N_TAGS          = 'tags';
    const N_CLASS         = 'class';
    const N_PARENT_CLASS  = 'parentClass';
    const N_INTERFACES    = 'interfaces';
    const N_FILE_PATH     = 'filePath';


    /**
     * Classes tree
     *
     * @var    \Includes\Decorator\DataStructure\ClassData\Tree
     * @access protected
     * @see    ____var_see____
     * @since  3.0.0
     */
    protected static $classesTree;


    /**
     * Return (and initialize, if needed) classes tree
     *
     * @return \Includes\Decorator\DataStructure\ClassData\Tree
     * @access protected
     * @see    ____func_see____
     * @since  3.0.0
     */
    protected static function getClassesTree()
    {
        if (!isset(static::$classesTree)) {
            static::$classesTree = new \Includes\Decorator\DataStructure\ClassData\Tree();
        }

        return static::$classesTree;
    }
}
