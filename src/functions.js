/**
 * Some general js-functions
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

function toggleBorder(id)
{
	FWS_toggleClassName(document.getElementById(id),'tl_highlight');
}

function invert_selection(prefix)
{
	for(var i = 0;;i++)
	{
		var checkbox = document.getElementById(prefix + i);
		if(checkbox == null)
			break;
		
		checkbox.checked = checkbox.checked ? false : true;
		toggleBorder('row_' + i);
	}
}

$(document).ready(function(){
	function toggleDiv(elemId, display){
		var elem = $('#' + elemId);
		
		if(display === 'none'){
			$('detailes_' + elemId).slideUp(1000);
		}else if(display === 'block'){
			$('detailes_' + elemId).slideDown(1000);
		}
	}
	
	// show detail div in entry overview
	$('.detail-icon').on('click', function(){
		if($(this).hasClass('fa-plus')){
			$(this).fadeTo(1000, .1, function(){
				$(this).removeClass('fa-plus').addClass('fa-minus').fadeTo(1000, 1);
			});
			
			toggleDiv($(this).attr('id'), 'none');
		}
		
		if($(this).hasClass('fa-minus')){
			$(this).fadeTo(1000, .1, function(){
				$(this).removeClass('fa-minus').addClass('fa-plus').fadeTo(1000, 1);
			});
			
			toggleDiv($(this).attr('id'), 'block');
		}
	});
});
