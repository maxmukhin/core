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
 * PHP version 5.3.0
 * 
 * @category  LiteCommerce
 * @author    Creative Development LLC <info@cdev.ru> 
 * @copyright Copyright (c) 2011 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 * @see       ____file_see____
 * @since     1.0.17
 */

namespace XLite\Model\DataSource;

/**
 * Data source Parameter model
 * 
 * @see   ____class_see____
 * @since 1.0.17
 *
 * @Entity
 * @Table  (name="data_source_parameters")
 */
class Parameter extends \XLite\Model\AEntity
{

    /**
     * Unique Data source parameter id
     *
     * @var   integer
     * @see   ____var_see____
     * @since 1.0.17
     *
     * @Id
     * @GeneratedValue (strategy="AUTO")
     * @Column (type="uinteger")
     */
    protected $id;

    /**
     * DataSource (relation)
     *
     * @var   \XLite\Model\DataSource
     * @see   ____var_see____
     * @since 1.0.17
     *
     * @ManyToOne (targetEntity="XLite\Model\DataSource", inversedBy="parameters")
     * @JoinColumn (name="data_source_id", referencedColumnName="id")
     */
    protected $dataSource;

    /**
     * Parameter name 
     * 
     * @var   string
     * @see   ____var_see____
     * @since 1.0.17
     *
     * @Column (type="string", length="255")
     */
    protected $name;

    /**
     * Serialized parameter value representation
     * 
     * @var   string
     * @see   ____var_see____
     * @since 1.0.17
     *
     * @Column (type="string", length="1024")
     */
    protected $value;

    /**
     * Get parameter value
     *
     * @return mixed
     * @see    ____func_see____
     * @since  1.0.17
     */
    public function getValue()
    {
        return empty($this->value) ? null : unserialize($this->value);
    }

    /**
     * Set parameter value
     *
     * @param mixed $value Parameter value
     *
     * @return void
     * @see    ____func_see____
     * @since  1.0.17
     */
    public function setValue($value)
    {
        $this->value = serialize($value);
    }
}
