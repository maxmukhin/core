{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * "You save" label (internal list element)
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 * @since     1.0.9
 *
 * @ListChild (list="product.details.page.info.market_price.text", weight="200")
 *}

, {t(#you save#)} <span class="you-save">{formatPrice(getSaveDifference(product),null,1):h}</span>
