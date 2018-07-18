<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_catalog_model extends Model
{
	function Product_catalog_model()
	{
		parent::Model();
	}
	
	function add_record()
	{
		$parent_id=$this->input->post("parent_id");
		
		$data=array(
			'cat_name'=>$this->input->post("cat_name"),
			'seqorder'=>$this->input->post("seqorder"),
			'btitle'=>$this->input->post("btitle"),
			'keyword'=>$this->input->post("keyword",true),
			'description'=>$this->input->post("description",true),
			'parent_id'=>$parent_id,
			'is_has_chd'=>0
		);
		$this->db->insert("shop_product_catalog",$data);
		if($this->db->affected_rows())
		{
			$this->db->select_max('id');
			$query=$this->db->get("shop_product_catalog");
			$max_id=$query->row_array();
			$max_id=$max_id['id'];
			if($parent_id)
			{
				$query=$this->db->get_where("shop_product_catalog",array('id'=>$parent_id));
				if($query->num_rows()>0)
				{
					$row=$query->row_array();
					$deep_id=(int)$row['deep_id']+1;
					$queue=$row['queue'].$max_id.",";
				}
			}
			else
			{
				$deep_id=0;
				$queue=",".$max_id.",";
			}
			$data=array(
				'queue'=>$queue,
				'deep_id'=>$deep_id
			);
			$this->db->update("shop_product_catalog",$data,array('id'=>$max_id));
			if($parent_id)
			{
				$data=array('is_has_chd'=>1);
				$this->db->update("shop_product_catalog",$data,array('id'=>$parent_id));
			}
			return TRUE;	
		}
		else
		{
			return FALSE;
		}
	}
	
	function save_record()
	{
		$parent_id=$this->input->post("parent_id");
		$old_parent_id=$this->input->post("old_parent_id");
		$rd_id=$this->input->post("rd_id");
		if($parent_id==$old_parent_id)
		{
			$data=array(
				'cat_name'=>$this->input->post("cat_name"),
				'btitle'=>$this->input->post("btitle"),
				'keyword'=>$this->input->post("keyword",true),
				'description'=>$this->input->post("description",true),
				'seqorder'=>$this->input->post("seqorder")
			);
			$this->db->update("shop_product_catalog",$data,array('id'=>$rd_id));
		}
		else
		{
			$query=$this->db->get_where("shop_product_catalog",array('id'=>$parent_id));
			if($query->num_rows()>0)
			{
				$row=$query->row_array();
				$deep_id=(int)$row['deep_id']+1;
				$queue=$row['queue'].$rd_id.",";
			}
			else
			{
				$deep_id=0;
				$queue=",".$rd_id.",";
			}
			$data=array(
				'cat_name'=>$this->input->post("cat_name"),
				'seqorder'=>$this->input->post("seqorder"),
				'btitle'=>$this->input->post("btitle"),
				'keyword'=>$this->input->post("keyword",true),
				'description'=>$this->input->post("description",true),
				'parent_id'=>$parent_id,
				'queue'=>$queue,
				'deep_id'=>$deep_id
			);
			$query=$this->db->get_where("shop_product_catalog",array('id'=>$rd_id));
			$rs=$query->row_array();
			$this->db->update("shop_product_catalog",$data,array('id'=>$rd_id));
			if($old_parent_id)
			{
				$query=$this->db->get_where("shop_product_catalog",array('parent_id'=>$old_parent_id));
				if($query->num_rows()>0)
				{
					$this->db->update("shop_product_catalog",array("is_has_chd"=>1),array('id'=>$old_parent_id));
				}
				else
				{
					$this->db->update("shop_product_catalog",array("is_has_chd"=>0),array('id'=>$old_parent_id));
				}
			}
			if($parent_id)
			{
				$this->db->update("shop_product_catalog",array("is_has_chd"=>1),array('id'=>$parent_id));
			}
			$is_has_chd=$this->input->post("is_has_chd");
			if($is_has_chd)
			{
				$this->update_qd($rd_id,$queue,$deep_id);
			}
		}
		return TRUE;
	}
	
	function update_qd($p_id,$qu,$dp)
	{
		$query=$this->db->get_where("shop_product_catalog",array('parent_id'=>$p_id));
		foreach($query->result() as $row)
		{
			$data=array(
				'deep_id'=>$dp+1,
				'queue'=>$qu.$row->id.","
			);
			$this->db->update("shop_product_catalog",$data,array('id'=>$row->id));
			if($row->is_has_chd)
			{
				$this->update_qd($row->id,$data['queue'],$data['deep_id']);
			}
		}
	}
	
	function sort_record()
	{
		$rd_id=$this->input->post("rd_id");
		if(!is_array($rd_id))
		{
			return FALSE;
		}
		foreach($rd_id as $row)
		{
			$sort_value=$this->input->post("sort".$row)?(int)$this->input->post("sort".$row):0;
			$this->db->update("shop_product_catalog",array('seqorder'=>$sort_value),array('id'=>$row));
		}
		return TRUE;
	}
	function del_record()
	{
		$rd_id=$this->input->post("rd_id");
		if(!is_array($rd_id))
		{
			return FALSE;
		}
		$this->db->where_in("id",$rd_id);
		$query=$this->db->get("shop_product_catalog");
		$this->db->where_in("id",$rd_id);
		$this->db->delete("shop_product_catalog");
		if($this->db->affected_rows())
		{
			foreach($query->result() as $row)
			{
				$qy=$this->db->get_where("shop_product_catalog",array('parent_id'=>$row->parent_id));
				if($qy->num_rows()>0)
				{
					$this->db->update("shop_product_catalog",array('is_has_chd'=>1),array('id'=>$row->parent_id));
				}
				else
				{
					$this->db->update("shop_product_catalog",array('is_has_chd'=>0),array('id'=>$row->parent_id));
				}
				$this->db->like('queue',$row->queue);
				$this->db->delete('shop_product_catalog');
			}
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function get_record($id)
	{
		$query=$this->db->get_where("shop_product_catalog",array('id'=>$id));
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
	}
	
	function get_records()
	{
		return $this->parse_catalog(0);
	}
	
	function parse_catalog($id)
	{
		static $catalog_arr=array();
		$sql = 'SELECT c.*,(SELECT COUNT(*) FROM '.$this->db->dbprefix."shop_product WHERE INSTR(catalog_id,CONCAT(',',c.id,',')) > 0) AS num FROM ".$this->db->dbprefix.'shop_product_catalog AS c';
		$sql .= ' WHERE c.parent_id = '.$id;
		$sql .= ' ORDER BY c.seqorder DESC,c.id DESC';
		$catalog = $this->common_model->get_records($sql);
		foreach($catalog as $row)
		{
			$catalog_arr[]=$row;
			if($row->is_has_chd==1)
			{
				$this->parse_catalog($row->id);
			}
		}
		return $catalog_arr;
	}
}
?>