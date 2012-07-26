{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Main center part of page
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011-2012 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 *
 * @ListChild (list="admin.main.page.header.sw_version", weight="10")
 *}
<span class="current" IF="!auth.isLogged()">{t(#LiteCommerce shopping cart software#)}</span>
