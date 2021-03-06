<?php
/**.
 * @link		http://stdesign.taobao.com
 */
class ItemGetRequest
{
	/** 
	 * 需要返回的商品对象字段。可选值：Item商品结构体中所有字段均可返回；多个字段用“,”分隔。如果想返回整个子对象，那字段为item_img，如果是想返回子对象里面的字段，那字段为item_img.url。新增返回字段：second_kill（是否秒杀商品）、auto_fill（代充商品类型）,props_name（商品属性名称）
	 **/
	private $fields;
	/** 
	 * 卖家昵称。强烈推荐在知道卖家昵称的情况下提供此字段以提高查询效率！
	 **/
	private $nick;
	/** 
	 * 商品数字ID
	 **/
	private $numIid;
	private $apiParas = array();
	public function setFields($fields)
	{
		$this->fields = $fields;
		$this->apiParas["fields"] = $fields;
	}
	public function getFields()
	{
		return $this->fields;
	}
	public function setNick($nick)
	{
		$this->nick = $nick;
		$this->apiParas["nick"] = $nick;
	}
	public function getNick()
	{
		return $this->nick;
	}
	public function setNumIid($numIid)
	{
		$this->numIid = $numIid;
		$this->apiParas["num_iid"] = $numIid;
	}
	public function getNumIid()
	{
		return $this->numIid;
	}
	public function getApiMethodName()
	{
		return "taobao.item.get";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
}
