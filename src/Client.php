<?php

namespace Weiaibaicai\Hupun;

class Client extends BaseClient
{
    //B2C 相关 完结
    /**
     * 描述：批量查询库存，根据库存修改时间(变动时间)批量获取 ERP 中库存集,单次查询的开始时间与结束时间不能超过7天;
     *
     * @link http://open-doc.hupun.com/#/apidetial/408942084066973178/169290599653277536/B2C
     *
     * @param array $params
     *
     * @return array
     */
    public function getInventoriesErp(array $params = []): array
    {
        return $this->execute('/inventories/erp', $params, 'get', false);
    }

    /**
     * 描述：商家自有商城将商品同步到万里牛ERP，系统商品对应关系模块操作将推送的商品与万里牛系统商品进行关联，推送成功后返回商品ID;
     *
     * @link http://open-doc.hupun.com/#/apidetial/408942084066973178/269707471083849206/B2C
     *
     * @param array $params
     *
     * @return array
     */
    public function postItemsOpen(array $params = []): array
    {
        return $this->execute('/items/open', $params, 'post', false);
    }

    /**
     * 描述：商家自有商城的商品分类同步到对应的万里牛B2C店铺;
     *
     * @link http://open-doc.hupun.com/#/apidetial/408942084066973178/674297577751243968/B2C
     *
     * @param array $params
     *
     * @return array
     */
    public function postCategoriesOpen(array $params = []): array
    {
        return $this->execute('/categories/open', $params, 'post', false);
    }


    /**
     * 描述：通过该接口，可确认自有商城推送至万里牛ERP中的订单是否发货，并返回快递信息;
     *
     * @link http://open-doc.hupun.com/#/apidetial/408942084066973178/703867962550690686/B2C
     *
     * @param array $params
     *
     * @return array
     */
    public function getTradesErpStatus(array $params = []): array
    {
        return $this->execute('/trades/erp/status', $params, 'get', false);
    }


    /**
     * 描述：单笔查询万里牛ERP库存;
     *
     * @link http://open-doc.hupun.com/#/apidetial/408942084066973178/875754084793018377/B2C
     *
     * @param array $params
     *
     * @return array
     */
    public function getInventoriesErpSingle(array $params = []): array
    {
        return $this->execute('/inventories/erp/single', $params, 'get', false);
    }


    /**
     * 描述：商家自有商城将订单推送到万里牛,推送成功返回推送的订单号;oder_id、trade_id需要全局唯一;重新推送单据,单据的金额值、仓库、快递等已经存在明细值不会被修改；
     *
     * @link http://open-doc.hupun.com/#/apidetial/408942084066973178/876303274116687378/B2C
     *
     * @param array $params
     *
     * @return array
     */
    public function postTradesOpen(array $params = []): array
    {
        return $this->execute('/trades/open', $params, 'post', false);
    }


    /**
     * 描述：商家自有商城推送售后单到万里牛ERP生成线上售后单;
     *
     * @link http://open-doc.hupun.com/#/apidetial/408942084066973178/9876524346433575377/B2C
     *
     * @param array $params
     *
     * @return array
     */
    public function postRefundOpen(array $params = []): array
    {
        return $this->execute('/refund/open', $params, 'post', false);
    }


    //商品 相关 完结

    /**
     * 描述：分页查询线上商品信息
     *
     * @link http://open-doc.hupun.com/#/apidetial/215049398424697496/173812354021814672/%E5%95%86%E5%93%81
     *
     * @param array $params
     *
     * @return array
     */
    public function postRrpGoodsQueryOlngoods(array $params = []): array
    {
        return $this->execute('/erp/goods/query/olngoods', $params, 'post');
    }

    /**
     * 描述：新增组合商品信息
     *
     * @link http://open-doc.hupun.com/#/apidetial/215049398424697496/176101762750313326/%E5%95%86%E5%93%81
     *
     * @param array $params
     *
     * @return array
     */
    public function postRrpGoodsAddGoodspackage(array $params = []): array
    {
        return $this->execute('/erp/goods/add/goodspackage', $params, 'post');
    }

    /**
     * 描述：修改Bom信息,Bom在系统内不存在时新增Bom
     *
     * @link http://open-doc.hupun.com/#/apidetial/215049398424697496/1761017627509229901/%E5%95%86%E5%93%81
     *
     * @param array $params
     *
     * @return array
     */
    public function postErpGoodsItemBomUpdate(array $params = []): array
    {
        return $this->execute('/erp/goods/item/bom/update', $params, 'post');
    }

    /**
     * 描述：查询子组合商品信息
     *
     * @link http://open-doc.hupun.com/#/apidetial/215049398424697496/271832050430666528/%E5%95%86%E5%93%81
     *
     * @param array $params
     *
     * @return array
     */
    public function postErpGoodsQueryGoodspackage(array $params = []): array
    {
        return $this->execute('/erp/goods/query/goodspackage', $params, 'post');
    }

    /**
     * 描述：修改万里牛ERP中组合商品信息,对外开放;
     *
     * @link http://open-doc.hupun.com/#/apidetial/215049398424697496/673949850831829636/%E5%95%86%E5%93%81
     *
     * @param array $params
     *
     * @return array
     */
    public function postErpGoodsUpdateGoodspackage(array $params = []): array
    {
        return $this->execute('/erp/goods/update/goodspackage', $params, 'post');
    }

    /**
     * 描述：获取商品分类
     *
     * @link http://open-doc.hupun.com/#/apidetial/215049398424697496/676664580630525341/%E5%95%86%E5%93%81
     *
     * @param array $params
     *
     * @return array
     */
    public function postErpGoodsCatagoryQuery(array $params = []): array
    {
        return $this->execute('/erp/goods/catagory/query', $params, 'post');
    }

    /**
     * 描述：分页查询组合商品，包含子商品信息
     *
     * @link http://open-doc.hupun.com/#/apidetial/215049398424697496/762652706676164835/%E5%95%86%E5%93%81
     *
     * @param array $params
     *
     * @return array
     */
    public function postErpGoodsQueryGoodspackages(array $params = []): array
    {
        return $this->execute('/erp/goods/query/goodspackages', $params, 'post');
    }

    //基础信息 相关 完结

    /**
     * 描述：修改供应商，状态只能传0或1，其他状态返回异常
     *
     * @link http://open-doc.hupun.com/#/apidetial/406602329304549469/175691525615758546/%E5%9F%BA%E7%A1%80%E4%BF%A1%E6%81%AF
     *
     * @param array $params
     *
     * @return array
     */
    public function postErpBaseSupplierModify(array $params = []): array
    {
        return $this->execute('/erp/base/supplier/modify', $params, 'post');
    }

    /**
     * 描述：获取多牛经销商,对外开放
     *
     * @link http://open-doc.hupun.com/#/apidetial/406602329304549469/467772411033139769/%E5%9F%BA%E7%A1%80%E4%BF%A1%E6%81%AF
     *
     * @param array $params
     *
     * @return array
     */
    public function postErpB2bDistrQuery(array $params = []): array
    {
        return $this->execute('/erp/b2b/distr/query', $params, 'post');
    }

    /**
     * 描述：查询万里牛ERP中仓库信息
     *
     * @link http://open-doc.hupun.com/#/apidetial/406602329304549469/574012557544625891/%E5%9F%BA%E7%A1%80%E4%BF%A1%E6%81%AF
     *
     * @param array $params
     *
     * @return array
     */
    public function postErpBaseStorageQuery(array $params = []): array
    {
        return $this->execute('/erp/base/storage/query', $params, 'post');
    }

    /**
     * 描述：分页查询万里牛ERP中的店铺信息
     *
     * @link http://open-doc.hupun.com/#/apidetial/406602329304549469/574012559907221985/%E5%9F%BA%E7%A1%80%E4%BF%A1%E6%81%AF
     *
     * @param array $params
     *
     * @return array
     */
    public function postErpBaseShopPageGet(array $params = []): array
    {
        return $this->execute('/erp/base/shop/page/get', $params, 'post');
    }

    /**
     * 描述：根据单号查询批次信息,对外开放
     *
     * @link http://open-doc.hupun.com/#/apidetial/406602329304549469/608927477722185596/%E5%9F%BA%E7%A1%80%E4%BF%A1%E6%81%AF
     *
     * @param array $params
     *
     * @return array
     */
    public function postErpBatchBillbatch(array $params = []): array
    {
        return $this->execute('/erp/batch/billbatch', $params, 'post');
    }

    /**
     * 描述：修改万里牛ERP系统商品信息,对外开放;
     *
     * @link http://open-doc.hupun.com/#/apidetial/406602329304549469/701993608436045266/%E5%9F%BA%E7%A1%80%E4%BF%A1%E6%81%AF
     *
     * @param array $params
     *
     * @return array
     */
    public function postErpGoodsUpdateItem(array $params = []): array
    {
        return $this->execute('/erp/goods/update/item', $params, 'post');
    }

    /**
     * 描述：查询万里牛ERP系统商品规格列表,spec_code,item_code,modify_time,bar_code至少一个不能为空——对外开放
     *
     * @link http://open-doc.hupun.com/#/apidetial/406602329304549469/712989787127325553/%E5%9F%BA%E7%A1%80%E4%BF%A1%E6%81%AF
     *
     * @param array $params
     *
     * @return array
     */
    public function postErpGoodsSpecOpenQueryGoodswithspeclist(array $params = []): array
    {
        return $this->execute('/erp/goods/spec/open/query/goodswithspeclist', $params, 'post');
    }

    /**
     * 描述：获取商品对应关系,以规格列表形式返回;shop_name和shop_nick不能同时为空
     *
     * @link http://open-doc.hupun.com/#/apidetial/406602329304549469/776068318029907226/%E5%9F%BA%E7%A1%80%E4%BF%A1%E6%81%AF
     *
     * @param array $params
     *
     * @return array
     */
    public function postErpGoodsItemCorrespondence(array $params = []): array
    {
        return $this->execute('/erp/goods/item/correspondence', $params, 'post');
    }

    /**
     * 描述：查询商品规格集合编码,其中spec_code,item_code,modify_time,bar_code不能同时为空——对外开放
     *
     * @link http://open-doc.hupun.com/#/apidetial/406602329304549469/874064213581831712/%E5%9F%BA%E7%A1%80%E4%BF%A1%E6%81%AF
     *
     * @param array $params
     *
     * @return array
     */
    public function postErpGoodsSpecOpenQuery(array $params = []): array
    {
        return $this->execute('/erp/goods/spec/open/query', $params, 'post');
    }

    /**
     * 描述：推送给万里牛ERP系统商品，对外开放;
     *
     * @link http://open-doc.hupun.com/#/apidetial/406602329304549469/904410576977336142/%E5%9F%BA%E7%A1%80%E4%BF%A1%E6%81%AF
     *
     * @param array $params
     *
     * @return array
     */
    public function postErpGoodsAddItem(array $params = []): array
    {
        return $this->execute('/erp/goods/add/item', $params, 'post');
    }

    /**
     * 描述：推送供应商信息至万里牛ERP;
     *
     * @link http://open-doc.hupun.com/#/apidetial/406602329304549469/910339200115041066/%E5%9F%BA%E7%A1%80%E4%BF%A1%E6%81%AF
     *
     * @param array $params
     *
     * @return array
     */
    public function postErpBaseSupplierAdd(array $params = []): array
    {
        return $this->execute('/erp/base/supplier/add', $params, 'post');
    }

    /**
     * 描述：查询万里牛ERP里的供应商信息
     *
     * @link http://open-doc.hupun.com/#/apidetial/406602329304549469/971709885693627051/%E5%9F%BA%E7%A1%80%E4%BF%A1%E6%81%AF
     *
     * @param array $params
     *
     * @return array
     */
    public function postErpBaseSupplierQuery(array $params = []): array
    {
        return $this->execute('/erp/base/supplier/query', $params, 'post');
    }

}
