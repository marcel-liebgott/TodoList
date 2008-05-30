<?php
/**
 * Contains the add-project-action
 *
 * @version			$Id: action_add_project.php 475 2008-04-04 15:40:32Z nasmussen $
 * @package			todoList
 * @subpackage	modules
 * @author			Nils Asmussen <nils@script-solution.de>
 * @copyright		2003-2007 Nils Asmussen
 * @link				http://www.script-solution.de
 */

/**
 * The add-project-action
 *
 * @author			Nils Asmussen <nils@script-solution.de>
 */
class TDL_Action_edit_project_add_project extends PLIB_Actions_Base
{
	public function perform_action()
	{
		$project_name = $this->input->get_var('project_name','post',PLIB_Input::STRING);
		$project_name_short = $this->input->get_var('project_name_short','post',PLIB_Input::STRING);
		$start_day = $this->input->get_var('start_day','post',PLIB_Input::INTEGER);
		$start_month = $this->input->get_var('start_month','post',PLIB_Input::INTEGER);
		$start_year = $this->input->get_var('start_year','post',PLIB_Input::INTEGER);
		
		$start = mktime(0,0,0,$start_month,$start_day,$start_year);
		
		$project = new TDL_Objects_Project(TDL_TB_PROJECTS);
		$project->set_project_name($project_name);
		$project->set_project_name_short($project_name_short);
		$project->set_project_start($start);
		
		if(!$project->check('create'))
			return $project->errors();
		
		$project->create();
		$id = $project->get_id();
		
		$this->set_success_msg('Das Projekt wurde erfolgreich hinzugef&uuml;gt');
		$this->set_redirect(
			true,
			$this->url->get_URL('edit_project','&amp;'.TDL_URL_MODE.'=edit&amp;'.TDL_URL_ID.'='.$id)
		);
		$this->set_action_performed(true);
	
		return '';
	}
}
?>