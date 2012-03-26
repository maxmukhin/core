{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Hello
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 * @since     1.0.19
 *
 * @ListChild (list="layout.header.bar.links.logged", weight="100")
 *}

<li class="account-link-1 first">{t(#Hello, user#,_ARRAY_(#name#^auth.profile.login))}</li>
