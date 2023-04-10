<?php

namespace Weiaibaicai\Hupun\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * //B2C 相关
 * @method static array getInventoriesErp(array $params=[])
 * @method static array postItemsOpen(array $params=[])
 * @method static array postCategoriesOpen(array $params=[])
 * @method static array getTradesErpStatus(array $params=[])
 * @method static array getInventoriesErpSingle(array $params=[])
 * @method static array postTradesOpen(array $params=[])
 * @method static array postRefundOpen(array $params=[])
 *
 * //商品 相关
 * @method static array postRrpGoodsQueryOlngoods(array $params=[])
 * @method static array postRrpGoodsAddGoodspackage(array $params=[])
 * @method static array postErpGoodsItemBomUpdate(array $params=[])
 * @method static array postErpGoodsQueryGoodspackage(array $params=[])
 * @method static array postErpGoodsUpdateGoodspackage(array $params=[])
 * @method static array postErpGoodsCatagoryQuery(array $params=[])
 * @method static array postErpGoodsQueryGoodspackages(array $params=[])
 *
 * //基础信息 相关
 * @method static array postErpBaseSupplierModify(array $params=[])
 * @method static array postErpB2bDistrQuery(array $params=[])
 * @method static array postErpBaseStorageQuery(array $params=[])
 * @method static array postErpBaseShopPageGet(array $params=[])
 * @method static array postErpBatchBillbatch(array $params=[])
 * @method static array postErpGoodsUpdateItem(array $params=[])
 * @method static array postErpGoodsSpecOpenQueryGoodswithspeclist(array $params=[])
 * @method static array postErpGoodsItemCorrespondence(array $params=[])
 * @method static array postErpGoodsSpecOpenQuery(array $params=[])
 * @method static array postErpGoodsAddItem(array $params=[])
 * @method static array postErpBaseSupplierAdd(array $params=[])
 * @method static array postErpBaseSupplierQuery(array $params=[])
 */
class Hupun extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'hupun';
    }
}
