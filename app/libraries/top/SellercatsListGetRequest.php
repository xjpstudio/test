<?php
/**.
 * @link		http://stdesign.taobao.com
 */
class SellercatsListGetRequest
{
	/** 
	 * fields参数
	 **/
	private $fields;
	/** 
	 * 卖家昵称
	 **/
	private $nick;
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
	public function getApiMethodName()
	{
		return "taobao.sellercats.list.get";
	}
	public function getApiParas()
	{
		return $this->apiParas;
	}
}
