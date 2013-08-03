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
     * Array of configuration data.
     * 
     * @var unknown_type
     */
    private $data = null;
    
    public function initialise($owner) {
        global $CFG,$COURSE;
        
        $result = false;
        
        if(!empty($data)) {
            return $result;
        }
        
        $this->data = new stdClass();
        
        $cparams = array('type' => get_config( 'block_module_info', 'dbconnectiontype' ),
                    'host' => get_config( 'block_module_info', 'dbhost' ),
                    'user' => get_config( 'block_module_info', 'dbuser' ),
                    'pass' => get_config( 'block_module_info', 'dbpass' ),
                    'dbname' => get_config( 'block_module_info', 'dbname' ),
                    'debug' => false);
        
        $dbc = new module_info_data_connection($cparams);
        $table = get_config('block_module_info','dbtable');
        //create the key that will be used in sql query
        $keyfields = array(get_config('block_module_info','extcourseid') => array('=' => "'$COURSE->idnumber'"));
    
        $module_code_field = get_config('block_module_info','module_code');
        $module_level_field = get_config('block_module_info','module_level');
        $module_credit_field = get_config('block_module_info','module_credit');
        $module_semester_field = get_config('block_module_info','module_semester');
        $convenor_name_field = get_config('block_module_info','convenor_name');
        $convenor_field = get_config('block_module_info','convenor');
    
        $fields = array();
        if(! empty ($module_code_field)) {
            $fields[] = $module_code_field;
        }
        if(! empty ($module_level_field)) {
            $fields[] = $module_level_field;
        }
        if(! empty ($module_credit_field)) {
            $fields[] = $module_credit_field;
        }
        if(! empty ($module_semester_field)) {
            $fields[] = $module_semester_field;
        }
        if(! empty ($convenor_name_field)) {
            $fields[] = $convenor_name_field;
        }
        if(! empty ($convenor_field)) {
            $fields[] = $convenor_field;
        }
        //$fields = array('MODULE_CODE', 'MODULE_LEVEL', 'MODULE_CREDITS', 'CONVENOR', 'CONVENOR_EMAIL');
        $this->data->info = $dbc->return_table_values($table, $keyfields, $fields);
        $this->data->block_config = $owner->config;
        $this->data->context = $owner->context;
        
        $convenor  = get_config('block_module_info','convenor');
        $convenorid = get_config('block_module_info','convenorid');
        
        $this->data->module_code = '';
        $this->data->module_level = '';
        $this->data->module_semester = '';
        $this->data->module_credit = '';
        $this->data->module_convenor_email = '';
        
        $module_code_field = get_config('block_module_info','module_code');
        $module_level_field = get_config('block_module_info','module_level');
        $module_credit_field = get_config('block_module_info','module_credit');
        $module_semester_field = get_config('block_module_info','module_semester');
        $convenor_name_field = get_config('block_module_info','convenor_name');
        $convenor_field = get_config('block_module_info','convenor');
        
        // Initially attempt to extract the semester from the course id
        $after_hyphen = strchr($COURSE->idnumber, "-");
        if(!empty($after_hyphen) && strlen($after_hyphen) > 2) {
            $this->data->module_semester = substr($after_hyphen, 1, 1);
        }
        
        foreach((array)$this->data->info as $field) {
            if (! empty($field[$module_code_field])) {
                $this->data->module_code = $field[$module_code_field];
            }
            if (! empty($field[$module_level_field]) && ! empty($this->data->block_config->module_level)) {
                $this->data->module_level = $field[$module_level_field];
            }
            if (! empty($field[$module_credit_field]) && ! empty($this->data->block_config->module_credit)) {
                $this->data->module_credit = $field[$module_credit_field];
            }
            if (! empty($field[$module_semester_field]) && ! empty($this->data->block_config->module_semester)) {
                $this->data->module_semester = $field[$module_semester_field];
            }
            if (! empty($field[$convenor_field]) && ! empty($this->data->block_config->display_convenor)) {
                $this->data->module_convenor_email = $field[$convenor_field];
            }
        }
        
        // override values out of the interim MIS if necessary
        if(! empty($this->data->block_config->module_code_override)) {
            $this->data->module_code = $this->data->block_config->module_code_override;
        }
        if(! empty($this->data->block_config->module_level_override)) {
            $this->data->module_level = $this->data->block_config->module_level_override;
        }
        if(! empty($this->data->block_config->module_semester_override)) {
            $this->data->module_semester = $this->data->block_config->module_semester_override;
        }
        if(! empty($this->data->block_config->module_credit_override)) {
            $this->data->module_credit = $this->data->block_config->module_credit_override;
        }
        if(! empty($this->data->block_config->module_convenor_override)) {
            $this->data->module_convenor_email = $this->data->block_config->module_convenor_override;
        }
        
        // Override location and Office hours
        $this->data->convenor_location = $this->data->block_config->convenor_location_override;
        $this->data->convenor_office_hours = $this->data->block_config->convenor_office_hours_override; 
        
        $result = true;
        
        return $result;
    }
    
    public function get_convenorinfo_output() {
        global $DB, $OUTPUT;
        
        $result = '';

        // Output module convenor information
        // Mug shot:
        if (! empty($this->data->block_config->display_convenor) && ! empty ($this->data->module_convenor_email)) {
            
            $result .= html_writer::start_tag('div', array('id' => 'convenor'));
            
            $headings_options = array(get_string('teacher_headings_options_not_configured', 'block_module_info'));
            $headings = get_config('block_module_info', 'convenor_role_name_options');
            if(!empty($headings) && strlen($headings) > 0) {
                $headings_options = explode("\r\n", $headings);
            }
            
            $result .= print_collapsible_region_start('convenor-heading', 'modinfo-viewlet-convenor', $headings_options[$this->data->block_config->module_owner_heading], 'modinfo-convenor', false, true);
             
            // NOTE: the following logic assumes that users can't change their email addresses...
            if($convenor = $DB->get_record('user', array('email' => $this->data->module_convenor_email))) {
                $display_options = array_values($this->data->block_config->display_convenor_options);
                // Profile picture - if needed
                if(in_array('profilepic', $display_options)) {
                    $pic_size = $this->data->block_config->convenor_profilepic_size;
                    $size = (strcmp($pic_size,'small')==0)?'50':'64';
                    $result .= $OUTPUT->user_picture($convenor, array('size' => $size, 'class'=>'convenor-profile-pic'));
                }
        
                // Name: 
                if(in_array('name', $display_options)) {      
                    $result .= html_writer::tag('div', fullname($convenor, true), array('class'=>'convenor-name'));
                }
         
                // Email address:
                if(in_array('name', $display_options)) {
                    $result .= html_writer::start_tag('div', array('class'=>'convenor-email'));
                    $result .= obfuscate_mailto($convenor->email, '');
                    $result .= html_writer::end_tag('div');
                }
        
                // Location:
                if(in_array('location', $display_options) && $this->data->convenor_location) {
                    $result .= html_writer::start_tag('div', array('class'=>'convenor-location'));
                    $result .= get_string('location', 'block_module_info').': '.s($this->data->convenor_location);
                    $result .= html_writer::end_tag('div');
                }
                // Office hours:
                if(in_array('officehours', $display_options) && $this->data->convenor_office_hours) {
                    $result .= html_writer::start_tag('div', array('class'=>'convenor-office-hours'));
                    $result .= get_string('officehours', 'block_module_info').': '.s($this->data->convenor_office_hours);
                    $result .= html_writer::end_tag('div');
                }
                
                // Standard fields:
                if(in_array('icq', $display_options) && $convenor->icq) {
                    $result .= html_writer::tag('div', get_string('icqnumber').': <a href=\"http://web.icq.com/wwp?uin=\"'.urlencode($convenor->icq).'\">'.s($thisteacher->icq).' <img src=\"http://web.icq.com/whitepages/online?icq=\"'.urlencode($convenor->icq).'&amp;img=5\" alt=\"\" /></a>', array('class'=>'convenor-icq'));
                }
                if(in_array('skype', $display_options) && $convenor->skype) {
                    $result .= get_string('skypeid').': '.'<a href="callto:'.urlencode($convenor->skype).'">'.s($convenor->skype).
                            ' <img src="http://mystatus.skype.com/smallicon/'.urlencode($convenor->skype).'" alt="'.get_string('status').'" '.
                            ' /></a>';
                }
                if(in_array('aim', $display_options) && $convenor->aim) {
                    $result .= html_writer::tag('div', '<a href="http://edit.yahoo.com/config/send_webmesg?.target='.urlencode($convenor->yahoo).'&amp;.src=pg">'.s($convenor->yahoo)." <img src=\"http://opi.yahoo.com/online?u=".urlencode($convenor->yahoo)."&m=g&t=0\" alt=\"\"></a>", array('class'=>'convenor-aim'));
                }
                if(in_array('yahoo', $display_options) && $convenor->yahooid) {
                    $result .= html_writer::tag('div', get_string('yahooid').': '.'<a href="http://edit.yahoo.com/config/send_webmesg?.target='.urlencode($convenor->yahoo).'&amp;.src=pg">'.s($convenor->yahoo)." <img src=\"http://opi.yahoo.com/online?u=".urlencode($convenor->yahoo)."&m=g&t=0\" alt=\"\"></a>", array('class'=>'additional-teacher-convenor'));
                }
                if(in_array('msn', $display_options) && $convenor->msnid) {
                    $result .= html_writer::tag('div', get_string('msnid').': '.s($convenor->msn), array('class'=>'convenor-msn'));
                }
                if(in_array('idnumber', $display_options) && $convenor->idnumber) {
                    $result .= html_writer::tag('div', get_string('idnumber').': '.s($convenor->idnumber), array('class'=>'convenor-idnumber'));
                }
                if(in_array('institution', $display_options) && $convenor->institution) {
                    $result .= html_writer::tag('div', get_string('institution').': '.s($convenor->institution), array('class'=>'convenor-institution'));
                }
                if(in_array('department', $display_options) && $convenor->department) {
                    $result .= html_writer::tag('div', get_string('department').': '.s($convenor->department), array('class'=>'convenor-department'));
                }
                if(in_array('phone1', $display_options) && $convenor->phone1) {
                    $result .= html_writer::tag('div', get_string('phone').': '.s($convenor->phone), array('class'=>'convenor-phone'));
                }
                if(in_array('phone2', $display_options) && $convenor->phone2) {
                    $result .= html_writer::tag('div', get_string('phone2').': '.s($convenor->phone2), array('class'=>'convenor-phone2'));
                }
                if(in_array('address', $display_options) && $convenor->address) {
                    $result .= html_writer::tag('div', get_string('address').': '.s($convenor->address), array('class'=>'convenor-address'));
                }
                
                // Custom fields:
                if ($fields = $DB->get_records('user_info_field')) {
                    foreach ($fields as $field) {
                        if(in_array($field->shortname, $display_options)) {
                            require_once($CFG->dirroot.'/user/profile/lib.php');
                            require_once($CFG->dirroot.'/user/profile/field/'.$field->datatype.'/field.class.php');
                            $newfield = 'profile_field_'.$field->datatype;
                            $formfield = new $newfield($field->id, $convenor->id);
                            if ($formfield->is_visible() and !$formfield->is_empty()) {
                                $result .= html_writer::tag('div', format_string($formfield->field->name.': ').$formfield->display_data(), array('class'=>'convenor-custom'));
                            }
                        }
                    }
                }
            } else {
                $result .= html_writer::start_tag('p');
                $result .= html_writer::tag('strong', $this->data->module_convenor_email.get_string( 'convenor_not_found', 'block_module_info' ));
                $result .= html_writer::end_tag('p');
        
            }
            
            // Display section heading if necessary
            if($this->data->block_config->additional_teachers_heading > 0) {
                $result .= print_collapsible_region_end(true);
            }
            
            $result .= html_writer::end_tag('div');
        }
        
        return $result;
    }
    
    public function get_additionteacherinfo_output() {
        global $DB, $OUTPUT, $CFG;
        
        $result = '';
        
        $result .= html_writer::start_tag('div', array('id' => 'additional-teachers'));
        
        // Display section heading if necessary
        $display_additional_teachers_heading = ($this->data->block_config->additional_teachers_heading > 0); 
        
        if($display_additional_teachers_heading) {
            $headings = get_config('block_module_info', 'additional_teacher_role_name_options');
            if(!empty($headings) && strlen($headings) > 0) {
                $headings_options = explode("\r\n", $headings);
            }
            $result .= print_collapsible_region_start('additional-teachers-heading', 'modinfo-viewlet-additional-teachers', $headings_options[$this->data->block_config->additional_teachers_heading], 'modinfo-teachers', false, true);
        }
        
        // First, check to see if there is any additional teacher information
        if (! empty($this->data->block_config->additional_teacher_email) ) {
            $result .= html_writer::start_tag('div', array('id'=>'additional_teachers_pane'));
            // Display each additional teacher
            foreach($this->data->block_config->additional_teacher_email as $key=>$value) {
                // NOTE: the following logic assumes that users can't change their email addresses...
                if($thisteacher = $DB->get_record('user', array('email' => $value))) {
                    $display_options = array_values($this->data->block_config->display_additional_teacher_options[$key]);
                    // Profile picture - if needed
                    if(in_array('profilepic', $display_options)) {
                        $pic_size = $this->data->block_config->additional_teacher_profilepic_size[$key];
                        $size = (strcmp($pic_size,'small')==0)?'50':'64';
                        $result .= $OUTPUT->user_picture($thisteacher, array('size' => $size, 'class'=>'additional-teacher-profile-pic'));
                    }
            
                    // Name:       
                    $result .= html_writer::tag('div', fullname($thisteacher, true), array('class'=>'additional-teacher-name'));
             
                    // Email address:
                    $result .= html_writer::start_tag('div', array('class'=>'additional-teacher-email'));
                    $result .= obfuscate_mailto($thisteacher->email, '');
                    $result .= html_writer::end_tag('div');
            
                    // Location:
                    if($this->data->block_config->additional_teacher_location[$key]) {
                        $result .= html_writer::start_tag('div', array('class'=>'additional-teacher-location'));
                        $result .= get_string('location', 'block_module_info').': '.s($this->data->block_config->additional_teacher_location[$key]);
                        $result .= html_writer::end_tag('div');
                    }
                    
                    // Office hours:
                    if($this->data->block_config->additional_teacher_office_hours[$key]) {
                        $result .= html_writer::start_tag('div', array('class'=>'additional-teacher-office-hours'));
                        $result .= get_string('officehours', 'block_module_info').': '.s($this->data->block_config->additional_teacher_office_hours[$key]);
                        $result .= html_writer::end_tag('div');
                    }
                    
                    // Standard fields:
                    if(in_array('icq', $display_options) && $thisteacher->icq) {
                        $result .= html_writer::tag('div', get_string('icqnumber').': <a href=\"http://web.icq.com/wwp?uin=\"'.urlencode($thisteacher->icq).'\">'.s($thisteacher->icq).' <img src=\"http://web.icq.com/whitepages/online?icq=\"'.urlencode($thisteacher->icq).'&amp;img=5\" alt=\"\" /></a>', array('class'=>'additional-teacher-icq'));
                    }
                    if(in_array('skype', $display_options) && $thisteacher->skype) {
                        $result .= get_string('skypeid').': '.'<a href="callto:'.urlencode($thisteacher->skype).'">'.s($thisteacher->skype).
                                ' <img src="http://mystatus.skype.com/smallicon/'.urlencode($thisteacher->skype).'" alt="'.get_string('status').'" '.
                                ' /></a>';
                    }
                    if(in_array('aim', $display_options) && $thisteacher->aim) {
                        $result .= html_writer::tag('div', '<a href="http://edit.yahoo.com/config/send_webmesg?.target='.urlencode($thisteacher->yahoo).'&amp;.src=pg">'.s($thisteacher->yahoo)." <img src=\"http://opi.yahoo.com/online?u=".urlencode($thisteacher->yahoo)."&m=g&t=0\" alt=\"\"></a>", array('class'=>'additional-teacher-aim'));
                    }
                    if(in_array('yahoo', $display_options) && $thisteacher->yahooid) {
                        $result .= html_writer::tag('div', get_string('yahooid').': '.'<a href="http://edit.yahoo.com/config/send_webmesg?.target='.urlencode($thisteacher->yahoo).'&amp;.src=pg">'.s($thisteacher->yahoo)." <img src=\"http://opi.yahoo.com/online?u=".urlencode($thisteacher->yahoo)."&m=g&t=0\" alt=\"\"></a>", array('class'=>'additional-teacher-yahoo'));
                    }
                    if(in_array('msn', $display_options) && $thisteacher->msnid) {
                        $result .= html_writer::tag('div', get_string('msnid').': '.s($thisteacher->msn), array('class'=>'additional-teacher-msn'));
                    }
                    if(in_array('idnumber', $display_options) && $thisteacher->idnumber) {
                        $result .= html_writer::tag('div', get_string('idnumber').': '.s($thisteacher->idnumber), array('class'=>'additional-teacher-idnumber'));
                    }
                    if(in_array('institution', $display_options) && $thisteacher->institution) {
                        $result .= html_writer::tag('div', get_string('institution').': '.s($thisteacher->institution), array('class'=>'additional-teacher-institution'));
                    }
                    if(in_array('department', $display_options) && $thisteacher->department) {
                        $result .= html_writer::tag('div', get_string('department').': '.s($thisteacher->department), array('class'=>'additional-teacher-department'));
                    }
                    if(in_array('phone1', $display_options) && $thisteacher->phone1) {
                        $result .= html_writer::tag('div', get_string('phone').': '.s($thisteacher->phone), array('class'=>'additional-teacher-phone'));
                    }
                    if(in_array('phone2', $display_options) && $thisteacher->phone2) {
                        $result .= html_writer::tag('div', get_string('phone2').': '.s($thisteacher->phone2), array('class'=>'additional-teacher-phone2'));
                    }
                    if(in_array('address', $display_options) && $thisteacher->address) {
                        $result .= html_writer::tag('div', get_string('address').': '.s($thisteacher->address), array('class'=>'additional-teacher-address'));
                    }
                    
                    // Custom fields:
                    if ($fields = $DB->get_records('user_info_field')) {
                        foreach ($fields as $field) {
                            if(in_array($field->shortname, $display_options)) {
                                require_once($CFG->dirroot.'/user/profile/lib.php');
                                require_once($CFG->dirroot.'/user/profile/field/'.$field->datatype.'/field.class.php');
                                $newfield = 'profile_field_'.$field->datatype;
                                $formfield = new $newfield($field->id, $thisteacher->id);
                                if ($formfield->is_visible() and !$formfield->is_empty()) {
                                    $result .= html_writer::tag('div', format_string($formfield->field->name.': ').$formfield->display_data(), array('class'=>'additional-teacher-custom'));
                                }
                            }
                        }
                    }
                } else {
                    $result .= html_writer::start_tag('p');
                    $result .= html_writer::tag('strong', $value.get_string( 'convenor_not_found', 'block_module_info' ));
                    $result .= html_writer::end_tag('p');
                }
            }
            $result .= html_writer::end_tag('div');
            
        } else {
            if($display_additional_teachers_heading) {
                $result .= $this->output->box(get_string('noadditionalteachersavailable', 'block_module_info'));
            }
        }
        
        $result .= html_writer::end_tag('div');
        $result .= print_collapsible_region_end(true);
        
        return $result;
    }
    
    private function get_personal_timetable() {
        
    }
    
    private function get_module_timetable() {
    
    }
    
    public function get_sessioninfo_output() {
        
        $result = '';
        
        // Display section heading
        $result .= print_collapsible_region_start('schedule-heading', 'modinfo-viewlet-schedule', get_string('schedule_header', 'block_module_info'), 'modinfo-schedule', false, true);
        $result .= html_writer::start_tag('div', array('id'=>'schedule_pane'));
        
        // First check to see if there is any session information
        if (! empty($this->data->block_config->additional_session_subheading) || $this->data->block_config->enable_personal_timetable_link || $this->data->block_config->enable_module_timetable_link) {
    
            $result .= html_writer::start_tag('div', array('id' => 'schedule'));
            
            // Personal timetable link
            
            
            // Module timetable link
            
            
            // Display each session
            foreach($this->data->block_config->additional_session_subheading as $key=>$value) {
                // Session title:
                $result .= html_writer::tag('h3', s($value), array('class'=>'session-title'));

                // Formatted session details:
                $a = new stdClass();
                $a->day = $this->data->block_config->additional_session_day[$key];
                $a->time = $this->data->block_config->additional_session_time[$key];
                $a->location = $this->data->block_config->additional_session_location[$key];
                $result .= html_writer::tag('div', get_string('session_details', 'block_module_info', $a));
            }
            
            $result .= html_writer::end_tag('div');
            
        } else {
            $result .= $this->output->box(get_string('nosessionsavailable', 'block_module_info'));
        }
        
        $result .= html_writer::end_tag('div');
        $result .= print_collapsible_region_end(true);
    
        return $result;
    }
    
    /**
     * Returns HTML to display module information.
     * 
     * @param unknown_type $info
     * @param unknown_type $config
     * @param unknown_type $contextid
     * @return string
     */
    public function get_moduleinfo_output() {
    	
        global $CFG,$DB,$OUTPUT;
        require_once($CFG->libdir . '/filelib.php');
 
        $result = '';

        
        // Now build HTML
        if (! empty($this->data->block_config->module_code) && ! empty ($this->data->module_code)) {
        	$result .= html_writer::start_tag('p');
        	$result .= html_writer::tag('span', get_string( 'module_code', 'block_module_info' ).': ',
        			array('class'=>'module_info_title'));
        	$result .= html_writer::tag('strong', $this->data->module_code);
        	$result .= html_writer::end_tag('p');
        }
        if (! empty($this->data->block_config->module_level) && ! empty ($this->data->module_level)) {
        	$result .= html_writer::start_tag('p');
        	$result .= html_writer::tag('span', get_string( 'module_level', 'block_module_info' ).': ',
        			array('class'=>'module_info_title'));
        	$result .= html_writer::tag('strong', $this->data->module_level);
        	$result .= html_writer::end_tag('p');
        }
        if (! empty($this->data->block_config->module_credit) && ! empty ($this->data->module_credit)) {
        	$result .= html_writer::start_tag('p');
        	$result .= html_writer::tag('span', get_string( 'module_credit', 'block_module_info' ).': ',
        			array('class'=>'module_info_title'));
        	$result .= html_writer::tag('strong', $this->data->module_credit);
        	$result .= html_writer::end_tag('p');
        }
        if (! empty($this->data->block_config->module_semester) && ! empty ($this->data->module_semester)) {
        	$result .= html_writer::start_tag('p');
        	$result .= html_writer::tag('span', get_string( 'module_semester', 'block_module_info' ).': ',
        			array('class'=>'module_info_title'));
        	$result .= html_writer::tag('strong', $this->data->module_semester);
        	$result .= html_writer::end_tag('p');
        }
        
        return $result;
        
    }
    
    /**
     * Internal function - creates htmls structure suitable for YUI tree.
     * 
     * @param unknown_type $context
     * @param unknown_type $block_context
     * @param unknown_type $dir
     * @return string
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
    
    /**
     * Returns a collapsible document tree. Documents are associated with this module - specified by the course owner.
     * 
     * @param unknown_type $block_context
     * @return string
     */
    public function get_documentinfo_output() {
        global $USER;
        
        $result = html_writer::start_tag('div', array('id'=>'documents'));
        
        $result .= print_collapsible_region_start('documents-heading', 'modinfo-viewlet-documents', get_string('documents_header', 'block_module_info'), 'modinfo-documents', false, true);
        
        // Get the stored files
        $fs = get_file_storage();
        $dir = $fs->get_area_tree($this->page->context->id, 'block_module_info', 'documents', $this->data->context->id);
        
        $module = array('name'=>'block_module_info', 'fullpath'=>'/blocks/module_info/module.js', 'requires'=>array('yui2-treeview'));
        
        $result .= html_writer::start_tag('div', array('id'=>'documents-pane'));
        
        if (empty($dir['subdirs']) && empty($dir['files'])) {
            $result .= $this->output->box(get_string('nofilesavailable', 'repository'));
        } else {
            $htmlid = 'document_tree_'.uniqid();
            $this->page->requires->js_init_call('M.block_module_info.init', array(false, $htmlid));
            $result .= '<div id="'.$htmlid.'">';
            $result .= $this->htmllize_document_tree($this->page->context, $this->data->context, $dir);
            $result .= '</div>';
        }
        
        $result .= html_writer::end_tag('div');
        $result .= html_writer::end_tag('div');
        
        $result .= print_collapsible_region_end(true);
        return $result;
    }

    /**
     * Return true for now
     */
    public function content_is_trusted() {
    	return true;
    }
}


