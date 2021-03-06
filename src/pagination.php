<?php
/**
 * Contains the pagination-class
 * 
 * @package			todolist
 * @subpackage	src
 *
 * Copyright (C) 2003 - 2016 Nils Asmussen
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

/**
 * The pagination for the todolist. Determines the page-number automaticly.
 * 
 * @package			todolist
 * @subpackage	src
 * @author			Nils Asmussen <nils@script-solution.de>
 */
class TDL_Pagination extends FWS_Pagination
{
	/**
	 * Constructor
	 * 
	 * @param int $per_page the number of entries per page
	 * @param int $num the total number of entries
	 */
	public function __construct($per_page,$num)
	{
		$input = FWS_Props::get()->input();

		$page = $input->get_var($this->get_page_param(),'get',FWS_Input::INTEGER);
		parent::__construct($per_page,$num,$page);
	}
	
	/**
	 * @return string the name of the page-param
	 */
	protected function get_page_param()
	{
		return TDL_URL_SITE;
	}

	/**
	 * Puts all variables to the template inc_pagination.htm so that it can be included.
	 *
	 * @param TDL_URL $url the URL-instance
	 */
	public function populate_tpl($url)
	{
		$tpl = FWS_Props::get()->tpl();

		if(!($url instanceof TDL_URL))
			FWS_Helper::def_error('instance','url','TDL_URL',$url);;
		
		if($this->get_page_count() > 1)
		{
			$param = $this->get_page_param();
			$page = $this->get_page();
			$numbers = $this->get_page_numbers();
			$tnumbers = array();
			foreach($numbers as $n)
			{
				$number = $n;
				$link = '';
				if(FWS_Helper::is_integer($n))
				{
					$url->set($param,$n);
					$link = $url->to_url();
				}
				else
					$link = '';
				$tnumbers[] = array(
					'number' => $number,
					'link' => $link
				);
			}
			
			$start_item = $this->get_start() + 1;
			$end_item = $start_item + $this->get_per_page() - 1;
			$end_item = ($end_item > $this->get_num()) ? $this->get_num() : $end_item;
			
			$tpl->set_template('inc_pagination.htm');
			$tpl->add_variable_ref('numbers',$tnumbers);
			$tpl->add_variables(array(
				'page' => $page,
				'total_pages' => $this->get_page_count(),
				'start_item' => $start_item,
				'end_item' => $end_item,
				'total_items' => $this->get_num(),
				'prev_url' => $url->set($param,$page - 1)->to_url(),
				'next_url' => $url->set($param,$page + 1)->to_url(),
				'first_url' => $url->set($param,1)->to_url(),
				'last_url' => $url->set($param,$this->get_page_count())->to_url()
			));
			$tpl->restore_template();
		}
	}
}
?>