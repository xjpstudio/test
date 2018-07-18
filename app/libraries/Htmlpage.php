<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**.
 * @link		http://stdesign.taobao.com
 */
// ------------------------------------------------------------------------
/**
 * Pagination Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Pagination
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/pagination.html
 */
class Htmlpage {
	var $base_url			= ''; // The page we are linking to
	var $total_rows  		= ''; // Total number of items (database results)
	var $per_page	 		= 10; // Max number of items you want shown per page
	var $num_links			=  2; // Number of "digit" links to show before/after the currently viewed page
	var $cur_page	 		=  0; // The current page being viewed
	var $para_value	 		=  0; // other param
	var $first_link   		= '&lsaquo; 首页';
	var $next_link			= '下一页';
	var $prev_link			= '上一页';
	var $last_link			= '尾页 &rsaquo;';
	var $uri_segment		= 4;
	var $full_tag_open		= '';
	var $full_tag_close		= '';
	var $first_tag_open		= '';
	var $first_tag_close	= '&nbsp;';
	var $last_tag_open		= '&nbsp;';
	var $last_tag_close		= '';
	var $cur_tag_open		= '&nbsp;<span>';
	var $cur_tag_close		= '</span>';
	var $next_tag_open		= '&nbsp;';
	var $next_tag_close		= '&nbsp;';
	var $prev_tag_open		= '&nbsp;';
	var $prev_tag_close		= '';
	var $num_tag_open		= '&nbsp;';
	var $num_tag_close		= '';
	var $page_query_string	= FALSE;
	var $query_string_segment = 'per_page';
	var $html_subfix = '.html';
	/**.
 * @link		http://stdesign.taobao.com
 */
	function Htmlpage($params = array())
	{
		if (count($params) > 0)
		{
			$this->initialize($params);
		}
		log_message('debug', "Pagination Class Initialized");
	}
	// --------------------------------------------------------------------
	/**
	 * Initialize Preferences
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */
	function initialize($params = array())
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				if (isset($this->$key))
				{
					$this->$key = $val;
				}
			}
		}
	}
	// --------------------------------------------------------------------
	/**.
 * @link		http://stdesign.taobao.com
 */
	function create_links()
	{
		// If our item count or per-page total is zero there is no need to continue.
		if ($this->total_rows == 0 OR $this->per_page == 0)
		{
			return '';
		}
		// Calculate the total number of pages
		$num_pages = ceil($this->total_rows / $this->per_page);
		// Is there only one page? Hm... nothing more to do here then.
		if ($num_pages == 1)
		{
			return '';
		}
		// Determine the current page number.
		$this->num_links = (int)$this->num_links;
		if ($this->num_links < 1)
		{
			show_error('Your number of links must be a positive number.');
		}
		if ( ! is_numeric($this->cur_page))
		{
			$this->cur_page = 0;
		}
		// Is the page number beyond the result range?
		// If so we show the last page
		if ($this->cur_page > $this->total_rows)
		{
			$this->cur_page = ($num_pages - 1) * $this->per_page;
		}
		$uri_page_number = $this->cur_page;
		$this->cur_page = floor(($this->cur_page/$this->per_page) + 1);
		// Calculate the start and end numbers. These determine
		// which number to start and end the digit links with
		$start = (($this->cur_page - $this->num_links) > 0) ? $this->cur_page - ($this->num_links - 1) : 1;
		$end   = (($this->cur_page + $this->num_links) < $num_pages) ? $this->cur_page + $this->num_links : $num_pages;
  		// And here we go...
		$output = '';
		// Render the "First" link
		$i=$this->para_value;
		$output .= $this->first_tag_open.'<a href="'.$this->base_url.$i.$this->html_subfix.'">'.$this->first_link.'</a>'.$this->first_tag_close;
		// Render the "previous" link
		if  ($this->cur_page != 1)
		{
			$i = $uri_page_number - $this->per_page;
			if ($i == 0) $i = '';
			$i=$this->para_value.$i;
			$output .= $this->prev_tag_open.'<a href="'.$this->base_url.$i.$this->html_subfix.'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
		}
		// Write the digit links
		for ($loop = $start -1; $loop <= $end; $loop++)
		{
			$i = ($loop * $this->per_page) - $this->per_page;
			if ($i >= 0)
			{
				if ($this->cur_page == $loop)
				{
					$output .= $this->cur_tag_open.$loop.$this->cur_tag_close; // Current page
				}
				else
				{
					$n = ($i == 0) ? '' : $i;
					$n = $this->para_value.$n;
					$output .= $this->num_tag_open.'<a href="'.$this->base_url.$n.$this->html_subfix.'">'.$loop.'</a>'.$this->num_tag_close;
				}
			}
		}
		// Render the "next" link
		if ($this->cur_page < $num_pages)
		{
			$i = $this->cur_page * $this->per_page;
			$i = $this->para_value.$i;
			$output .= $this->next_tag_open.'<a href="'.$this->base_url.$i.$this->html_subfix.'">'.$this->next_link.'</a>'.$this->next_tag_close;
		}
		// Render the "Last" link
		$i = (($num_pages * $this->per_page) - $this->per_page);
		$i = $this->para_value.$i;
		$output .= $this->last_tag_open.'<a href="'.$this->base_url.$i.$this->html_subfix.'">'.$this->last_link.'</a>'.$this->last_tag_close;
		// Kill double slashes.  Note: Sometimes we can end up with a double slash
		// in the penultimate link so we'll kill all double slashes.
		$output = preg_replace("#([^:])//+#", "\\1/", $output);
		// Add the wrapper HTML if exists
		$output = $this->full_tag_open.$output.$this->full_tag_close;
		$output .= "&nbsp;&nbsp; 每页 ".$this->per_page." 条记录,总共 ".$this->total_rows." 条记录.";
		return $output;
	}
}
?>
