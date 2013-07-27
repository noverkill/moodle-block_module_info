<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 * Constructs HTML for Module Info block
 *
 * @package    block_module_info
 * @copyright  2013 Queen Mary, University of London
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/blocks/module_info/lib.php');

class block_module_info_renderer extends plugin_renderer_base {

    /**
     * Prints module information
     * @return string
     */
    public function get_output($info, $config, $contextid) {
    	
        global $CFG,$DB,$OUTPUT;
        require_once($CFG->libdir . '/filelib.php');
        
 
        $result = '';
        
        $convenor  = get_config('block_module_info','convenor');
        $convenorid = get_config('block_module_info','convenorid');
       	
        $module_code = '';
        $module_level = '';
        $module_semester = '';
        $module_credit = '';
        $module_convenor_email = '';
        
        $module_code_field = get_config('block_module_info','module_code');
        $module_level_field = get_config('block_module_info','module_level');
        $module_credit_field = get_config('block_module_info','module_credit');
        $module_semester_field = get_config('block_module_info','module_semester');
        $convenor_name_field = get_config('block_module_info','convenor_name');
        $convenor_field = get_config('block_module_info','convenor');
        
        foreach($info as $field) {
        	if (! empty($field[$module_code_field])) {
        		$module_code = $field[$module_code_field];
        	}
            if (! empty($field[$module_level_field]) && ! empty($config->module_level)) {
                $module_level = $field[$module_level_field];
            }
            if (! empty($field[$module_credit_field]) && ! empty($config->module_credit)) {
                $module_credit = $field[$module_credit_field];
            }
            if (! empty($field[$module_semester_field]) && ! empty($config->module_semester)) {
            	$module_semester = $field[$module_semester_field];
            }
            if (! empty($field[$convenor_field]) && ! empty($config->display_convenor)) {
                $module_convenor_email = $field[$convenor_field];
            }
        }

        // override values out of the interim MIS if necessary
        if(! empty($config->module_code_override)) {
        	$module_code = $this->config->module_code_override;
        }
        if(! empty($config->module_level_override)) {
        	$module_level = $this->config->module_level_override;
        }
        if(! empty($config->module_semester_override)) {
        	$module_semester = $this->config->module_semester_override;
        }
        if(! empty($config->module_credit_override)) {
        	$module_credit = $this->config->module_credit_override;
        }
        if(! empty($config->module_convenor_override)) {
        	$module_convenor_email = $this->config->module_convenor_override;
        }
        
        // Now build HTML
        if (! empty($config->module_code) && ! empty ($module_code)) {
        	$result .= html_writer::start_tag('p');
        	$result .= html_writer::tag('span', get_string( 'module_code', 'block_module_info' ).': ',
        			array('class'=>'module_info_title'));
        	$result .= html_writer::tag('strong', $module_code);
        	$result .= html_writer::end_tag('p');
        }
        if (! empty($config->module_level) && ! empty ($module_level)) {
        	$result .= html_writer::start_tag('p');
        	$result .= html_writer::tag('span', get_string( 'module_level', 'block_module_info' ).': ',
        			array('class'=>'module_info_title'));
        	$result .= html_writer::tag('strong', $module_level);
        	$result .= html_writer::end_tag('p');
        }
        if (! empty($config->module_credit) && ! empty ($module_credit)) {
        	$result .= html_writer::start_tag('p');
        	$result .= html_writer::tag('span', get_string( 'module_credit', 'block_module_info' ).': ',
        			array('class'=>'module_info_title'));
        	$result .= html_writer::tag('strong', $module_credit);
        	$result .= html_writer::end_tag('p');
        }
        if (! empty($config->module_semester) && ! empty ($module_semester)) {
        	$result .= html_writer::start_tag('p');
        	$result .= html_writer::tag('span', get_string( 'module_semester', 'block_module_info' ).': ',
        			array('class'=>'module_info_title'));
        	$result .= html_writer::tag('strong', $module_semester);
        	$result .= html_writer::end_tag('p');
        }
        
        // Output module convenor information#
        // Mug shot:
        if (! empty($config->display_convenor) && ! empty ($module_convenor_email)) {
        	
        	//debugging(format_text($module_convenor_email), DEBUG_DEVELOPER);
        	$result .= html_writer::start_tag('div', array('id' => 'convenor'));
        	$result .= html_writer::tag('h2', get_string( 'convenor', 'block_module_info' ),
        			array('class'=>'convenor'));
        	
        	// NOTE: the following logic assumes that users can't change their email addresses...
        	if($thisconvenor = $DB->get_record('user', array('email' => $module_convenor_email))) {
        		// Mugshot
        		$result .= $OUTPUT->user_picture($thisconvenor, array('size' => '50', 'class'=>'profile-pic'));
        		
	        	// Name:
	        	$result .= html_writer::start_tag('p');
	        	/*$this->content->text .= html_writer::tag('span', get_string( 'convenor_name', 'block_module_info' ).': ',
	        			array('class'=>'module_info_title'));*/
	        	$result .= html_writer::tag('strong', fullname($thisconvenor, true));
	        	$result .= html_writer::end_tag('p');
        	
        		// Email address:
        		$result .= html_writer::link('mailto:'.$thisconvenor->email, $thisconvenor->email);
        		
        	} else {
        		$result .= html_writer::start_tag('p');
        		$result .= html_writer::tag('strong', $module_convenor_email.get_string( 'convenor_not_found', 'block_module_info' ));
        		$result .= html_writer::end_tag('p');
        		
        	}
        	$result .= html_writer::end_tag('div');
        }
 
        return $result;
        
    }
    
    /**
     * Internal function - creates htmls structure suitable for YUI tree.
     */
    protected function htmllize_document_tree($context, $block_context, $dir) {
        global $CFG;
        
        $result = '';
        
        $yuiconfig = array();
        $yuiconfig['type'] = 'html';
    
        if (empty($dir['subdirs']) and empty($dir['files'])) {
            return '';
        }
        $result = '<ul>';
        foreach ($dir['subdirs'] as $subdir) {
            $image = $this->output->pix_icon("f/folder", $subdir['dirname'], 'moodle', array('class'=>'icon'));
            $result .= '<li yuiConfig=\''.json_encode($yuiconfig).'\'><div>'.$image.s($subdir['dirname']).'</div> '.$this->htmllize_document_tree($context, $block_context, $subdir).'</li>';
        }
        foreach ($dir['files'] as $file) {
            $url = file_encode_url("$CFG->wwwroot/pluginfile.php", '/'.$context->id.'/block_module_info/documents/'.$block_context->id.$file->get_filepath().$file->get_filename(), true);
            $filename = $file->get_filename();
            $icon = mimeinfo("icon", $filename);
            $image = $this->output->pix_icon("f/$icon", $filename, 'moodle', array('class'=>'icon'));
            $result .= '<li yuiConfig=\''.json_encode($yuiconfig).'\'><div>'.html_writer::link($url, $image.$filename).'</div></li>';
        }
        $result .= '</ul>';
    
        return $result;
    }
    
    public function get_document_tree($block_context) {
        global $USER;
        
        $result = html_writer::tag('h2', get_string( 'documents_header', 'block_module_info' ),
                array('class'=>'documents'));
        
        // Get the stored files
        $fs = get_file_storage();
        $dir = $fs->get_area_tree($this->page->context->id, 'block_module_info', 'documents', $block_context->id);
        
        $module = array('name'=>'block_module_info', 'fullpath'=>'/blocks/module_info/module.js', 'requires'=>array('yui2-treeview'));
        if (empty($dir['subdirs']) && empty($dir['files'])) {
            $result .= $this->output->box(get_string('nofilesavailable', 'repository'));
        } else {
            $htmlid = 'document_tree_'.uniqid();
            $this->page->requires->js_init_call('M.block_module_info.init_tree', array(false, $htmlid));
            $result .= '<div id="'.$htmlid.'">';
            $result .= $this->htmllize_document_tree($this->page->context, $block_context, $dir);
            $result .= '</div>';
        }
        
        return $result;
    }

    /**
     * Return true for now
     */
    public function content_is_trusted() {
    	return true;
    }
}


