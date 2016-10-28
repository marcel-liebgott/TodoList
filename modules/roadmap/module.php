<?php
/**
 * Contains the roadmap-module
 *
 * @package			todolist
 * @subpackage		modules
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
 * The roadmap-module
 *
 * @package			todolist
 * @subpackage		modules
 * @author			Marcel Liebgott <marcel@mliebgott.de>
 */
final class TDL_Module_Roadmap extends TDL_Module
{
	/**
	 * @see FWS_Module::init($doc)
	 *
	 * @param TDL_Document $doc
	 */
	public function init($doc)
	{
		parent::init($doc);

		$locale = FWS_Props::get()->locale();
		$input = FWS_Props::get()->input();
		$renderer = $doc->use_default_renderer();

		$mode = $input->get_predef(TDL_URL_MODE,'get');
		if($mode == 'show')
			$doc->use_raw_renderer();

			$renderer->add_breadcrumb($locale->_('Roadmap'), TDL_URL::get_mod_url()->to_url());
	}

	/**
	 * @see FWS_Module::run()
	 */
	public function run()
	{
		$input = FWS_Props::get()->input();

		$mode = $input->get_predef(TDL_URL_MODE,'get');
		if($mode == 'show')
		{
			$this->_show();
			return;
		}
	}

	private function _show()
	{
		$db = FWS_Props::get()->db();

		$text = '';

		$rows = $db->get_rows(
			'SELECT p.id,p.project_name, 
			SUM(IF(e.entry_status = "open", 1, 0)) as open,
			SUM(IF(e.entry_status = "fixed", 1, 0)) as fixed,
			SUM(IF(e.entry_status = "running", 1, 0)) as running,
			SUM(IF(e.entry_status = "not_tested", 1, 0)) as not_testet,
			SUM(IF(e.entry_status = "not_reproducable", 1, 0)) as not_reproducable,
			SUM(IF(e.entry_status = "need_info", 1, 0)) as need_info
		 	FROM '.TDL_TB_PROJECTS.' p, '.TDL_TB_ENTRIES.' e
		 	GROUP BY p.id'
		);
		print_r($rows);

		$doc = FWS_Props::get()->doc();
		$doc->set_mimetype('text/plain');
		$doc->use_raw_renderer()->set_content(FWS_StringHelper::htmlspecialchars_back($text));
	}
}
?>