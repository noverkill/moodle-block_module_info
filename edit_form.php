<?php
 
class block_module_info_edit_form extends block_edit_form {
	
    protected function specific_definition($mform) {
    	
    	global $DB;

        $defaulthtml = get_config('block_module_info', 'defaulthtml');

        $action = optional_param('action','',PARAM_TEXT);

        if($action == 'reset') {
        	$this->_form->values->config_module_code = true;
        	$this->_form->values->config_module_level = true;
        	$this->_form->values->config_module_credit = true;
        	$this->_form->values->config_module_semester = true;
        	$this->_form->values->config_display_convenor = true;
        	$this->_form->values->config_html = true;
            $this->_form->values->config_htmlcontent = $defaulthtml;
        }

        // Core info
        $mform->addElement('header', 'configheader', get_string('core_info_header', 'block_module_info'));
 
        // Block title
        $mform->addElement('text', 'config_title', get_string('config_title', 'block_module_info'));
        $mform->setDefault('config_title', get_string('module_info', 'block_module_info'));
        $mform->setType('config_title', PARAM_MULTILANG);

        $mform->addElement('advcheckbox', 'config_module_code', get_string('config_module_code', 'block_module_info'));
        $mform->setDefault('config_module_code', 1);
        $mform->addElement('text', 'config_module_code_override', get_string('config_module_code_override', 'block_module_info'));
        $mform->setType('config_module_code_override', PARAM_MULTILANG);
        
        $mform->addElement('advcheckbox', 'config_module_level', get_string('config_module_level', 'block_module_info'));
        $mform->setDefault('config_module_level', 1);
        $mform->addElement('text', 'config_module_level_override', get_string('config_module_level_override', 'block_module_info'));
        $mform->setType('config_module_level_override', PARAM_MULTILANG);
        
        $mform->addElement('advcheckbox', 'config_module_credit', get_string('config_module_credit', 'block_module_info'));
        $mform->setDefault('config_module_credit', 1);
        $mform->addElement('text', 'config_module_credit_override', get_string('config_module_credit_override', 'block_module_info'));
        $mform->setType('config_module_credit_override', PARAM_MULTILANG);
        
        $mform->addElement('advcheckbox', 'config_module_semester', get_string('config_module_semester', 'block_module_info'));
        $mform->setDefault('config_module_semester', 1);
        $mform->addElement('text', 'config_module_semester_override', get_string('config_module_semester_override', 'block_module_info'));
        $mform->setType('config_module_semester_override', PARAM_MULTILANG);
        
        // Teaching
        $mform->addElement('header', 'configheader', get_string('teaching_header', 'block_module_info'));
        
        // Module owner heading
        $headings_options = array(get_string('teacher_headings_options_not_configured', 'block_module_info'));
        $headings = get_config('block_module_info', 'convenor_role_name_options');
        if(!empty($headings) && strlen($headings) > 0) {
        	$headings_options = explode("\r\n", $headings);
        }
        $mform->addElement('select', 'config_module_owner_heading', get_string('config_module_owner_heading', 'block_module_info'), $headings_options);
        
        // Module owner property display options
        // What to display
        $display_options = array('name'=>get_string('fullname'));
        $display_options = array_merge($display_options, array('profilepic'=>get_string('profilepic', 'block_module_info')));
        $display_options = array_merge($display_options, array('email'=>get_string('email')));
        $display_options = array_merge($display_options, array('location'=>get_string('location', 'block_module_info')));
        $display_options = array_merge($display_options, array('officehours'=>get_string('officehours', 'block_module_info')));
        $display_options = array_merge($display_options, array('url'=>get_string('webpage')));
        
        $possible_options = array('icq'=>get_string('icqnumber'));
        $possible_options = array_merge($possible_options, array('skype'=>get_string('skypeid')));
        $possible_options = array_merge($possible_options, array('aim'=>get_string('aimid')));
        $possible_options = array_merge($possible_options, array('yahoo'=>get_string('yahooid')));
        $possible_options = array_merge($possible_options, array('msn'=>get_string('msnid')));
        $possible_options = array_merge($possible_options, array('idnumber'=>get_string('idnumber')));
        $possible_options = array_merge($possible_options, array('institution'=>get_string('institution')));
        $possible_options = array_merge($possible_options, array('department'=>get_string('department')));
        $possible_options = array_merge($possible_options, array('phone1'=>get_string('phone')));
        $possible_options = array_merge($possible_options, array('phone2'=>get_string('phone2')));
        $possible_options = array_merge($possible_options, array('address'=>get_string('address')));
        
        // Additional person display options are configured globally
        $additional_display_options = explode(',', get_config('block_module_info', 'additional_person_display_options'));
        foreach($additional_display_options as $option) {
            if(array_key_exists($option, $possible_options)) {
                $new_option = array($option=>$possible_options[$option]);
                $display_options = array_merge($display_options, $new_option);
            }
        }
        
        // Add custom profile fields to display options
        if ($fields = $DB->get_records('user_info_field')) {
        	foreach ($fields as $field) {
        		$display_options = array_merge($display_options, array(format_string($field->name)=>format_string($field->name)));
        	}
        }
        
        $attributes = array('size'=>'7'); 
        $select = $mform->addElement('select', 'config_display_convenor_options', get_string('config_display_convenor_options', 'block_module_info'), $display_options, $attributes);
        $select->setMultiple(true);
        $mform->setDefault('config_display_convenor_options', array('name', 'profilepic', 'email', 'location', 'officehours'));
        
        // Overrides
        // Module owner name
        $mform->addElement('text', 'config_convenor_name_override', get_string('config_convenor_name_override', 'block_module_info'));
        
        // Module owner profile picture size
        $sizeoptions = array('small'=>get_string('small', 'block_module_info'), 'large'=>get_string('large', 'block_module_info'));
        $mform->addElement('select', 'config_convenor_profilepic_size', get_string('profilepic_size', 'block_module_info'), $sizeoptions);
        $mform->setDefault('config_convenor_profilepic_size', 'small');
        
        // Module owner email
        $mform->addElement('text', 'config_convenor_email_override', get_string('config_convenor_email_override', 'block_module_info'));
        $mform->setType('config_convenor_email_override', PARAM_EMAIL);
        
        // Module owner location
        $mform->addElement('text', 'config_convenor_location_override', get_string('config_convenor_location_override', 'block_module_info'));
        
        // Module owner office hours
        $mform->addElement('text', 'config_convenor_office_hours_override', get_string('config_convenor_office_hours_override', 'block_module_info'));  
        
        // Additional teachers
        $mform->addElement('header', 'configheader', get_string('additional_teachers_header', 'block_module_info'));
        
        // Additional teachers heading
        $headings_options = array(get_string('teacher_headings_options_not_configured', 'block_module_info'));
        $headings = get_config('block_module_info', 'additional_teacher_role_name_options');
        if(!empty($headings) && strlen($headings) > 0) {
        	$headings_options = explode("\r\n", $headings);
        }
        $mform->addElement('select', 'config_additional_teachers_heading', get_string('config_additional_teachers_heading', 'block_module_info'), $headings_options);
        
        $teacherarray = array();
        $teacherarray[] = $mform->createElement('header', '', get_string('config_additional_teacher','block_module_info').' {no}');
        $teacherarray[] = $mform->createElement('text', 'config_additional_teacher_name', get_string('config_additional_teacher_name','block_module_info'));
        $teacherarray[] = $mform->createElement('text', 'config_additional_teacher_email', get_string('config_additional_teacher_email','block_module_info'));
        
        // Additional teacher property display options
        // What to display
        $display_options = array('profilepic'=>get_string('profilepic', 'block_module_info'));
        $display_options = array_merge($display_options, array('url'=>get_string('webpage')));
        
        // Additional person display options are configured globally
        $additional_display_options = explode(',', get_config('block_module_info', 'additional_person_display_options'));
        foreach($additional_display_options as $option) {
            if(array_key_exists($option, $possible_options)) {
                $new_option = array($option=>$possible_options[$option]);
                $display_options = array_merge($display_options, $new_option);
            }
        }
        
        // Add custom profile fields to display options
        if ($fields = $DB->get_records('user_info_field')) {
        	foreach ($fields as $field) {
        		$display_options = array_merge($display_options, array(format_string($field->name)=>format_string($field->name)));
        	}
        }
        $attributes = array('size'=>'7');
        $select = $mform->createElement('select', 'config_display_additional_teacher_options', get_string('config_display_additional_teacher_options', 'block_module_info'), $display_options, $attributes);
        $select->setMultiple(true);
        $teacherarray[] = $select;
        
        // Additional teacher profile picture size
        $profile_size = $mform->createElement('select', 'config_additional_teacher_profilepic_size', get_string('profilepic_size', 'block_module_info'), $sizeoptions);
        $mform->setDefault('config_additional_teacher_profilepic_size', 'small');
        $teacherarray[] = $profile_size;
        
        $teacherarray[] = $mform->createElement('text', 'config_additional_teacher_location', get_string('config_additional_teacher_location','block_module_info'));
        $teacherarray[] = $mform->createElement('text', 'config_additional_teacher_office_hours', get_string('config_additional_teacher_office_hours','block_module_info'));
        $teacherarray[] = $mform->createElement('hidden', 'additionalteacherid', 0);
        
        $teacherno = sizeof($this->block->config->additional_teacher_name); 
        $teacherno += 1;
        
        // No settings options specified for now...
        $repeateloptions = array();
        
        $mform->setType('additionalteacherid', PARAM_INT);
        
        $this->repeat_elements($teacherarray, $teacherno,
                $repeateloptions, 'teacher_repeats', 'option_add_fields', 1, null, false);
        
        // Schedule
        $mform->addElement('header', 'configheader', get_string('schedule_header', 'block_module_info'));
        
        $mform->addElement('advcheckbox', 'config_enable_personal_timetable_link', get_string('config_enable_personal_timetable_link', 'block_module_info'));
        $mform->setDefault('config_enable_personal_timetable_link', 1);
        $mform->addElement('advcheckbox', 'config_enable_module_timetable_link', get_string('config_enable_module_timetable_link', 'block_module_info'));
        $mform->setDefault('config_enable_module_timetable_link', 1);
        
        $sessionarray = array();
        $sessionarray[] = $mform->createElement('header', '', get_string('config_additional_session','block_module_info').' {no}');
        $sessionarray[] = $mform->createElement('text', 'config_additional_session_subheading', get_string('config_additional_session_subheading','block_module_info'));
        $sessionarray[] = $mform->createElement('text', 'config_additional_session_day', get_string('config_additional_session_day','block_module_info'));
        $sessionarray[] = $mform->createElement('text', 'config_additional_session_time', get_string('config_additional_session_time','block_module_info'));
        $sessionarray[] = $mform->createElement('text', 'config_additional_session_location', get_string('config_additional_session_location','block_module_info'));
        $sessionarray[] = $mform->createElement('hidden', 'additionalsessionid', 0);
        
        $sessionno = sizeof($this->block->config->additional_session_subheading); 
        $sessionno += 1;
        
        // No settings options specified for now...
        $repeateloptions = array();
        
        $mform->setType('additionalsessionid', PARAM_INT);
        
        $this->repeat_elements($sessionarray, $sessionno,
                $repeateloptions, 'session_repeats', 'option_add_fields', 1, null, false);
        
        // Documents
        $mform->addElement('header', 'configheader', get_string('documents_header', 'block_module_info'));
        
        global $COURSE;
        
        $fileoptions = array('subdirs'=>1,
        		'maxbytes'=>$COURSE->maxbytes,
        		'accepted_types'=>'*',
        		'return_types'=>FILE_INTERNAL);
        
        global $USER;
        $data = new stdClass();
        file_prepare_standard_filemanager($data,
        		'files',
        		$fileoptions,
        		$this->page->context,
        		'block_module_info',
        		'documents',
        		$this->block->context->id);
        
        $mform->addElement('filemanager', 'files_filemanager', get_string('files'), null, $fileoptions);
        $this->set_data($data);
        
        // Legacy
        $mform->addElement('header', 'configheader', get_string('legacy_header', 'block_module_info'));
        
        $mform->addElement('advcheckbox', 'config_html', get_string('config_html', 'block_module_info'));
        $mform->setDefault('config_html', 0);

        // A sample string variable with a default value.
        $editoroptions = array('maxfiles' => EDITOR_UNLIMITED_FILES, 'noclean'=>true, 'context'=>$this->block->context);
        $mform->addElement('editor', 'config_htmlcontent', get_string('config_htmlcontent', 'block_module_info'), null, $editoroptions);
        $mform->setDefault('config_htmlcontent',array('text'=>$defaulthtml, 'format'=>FORMAT_HTML));
        $mform->setType('config_htmlcontent', PARAM_RAW); // XSS is prevented when printing the block contents and serving files


        //$link = new moodle_url('/course/view.php', array('id' => $this->page->course->id, 'sesskey' => sesskey(),
        //    'bui_editid' => $this->block->instance->id, 'action' => 'reset'));

        //$mform->addElement('html', html_writer::link($link, get_string('reset', 'block_module_info')));

    }
    
    private function deleteArrayElement($anArray=array(), $index) {
        unset($anArray[$index]);
        $anArray = array_values($anArray);
        
        return $anArray;
    }
    
    function get_data() {
        
        $data = parent::get_data();
        
        if($data != null) {
            // If an additional teacher's name is blank then remove this element from the array
            $names = $data->config_additional_teacher_name;
            foreach($names as $key=>$value) {
                if(strlen($value) == 0 || $value == NULL) {
                    $data->config_additional_teacher_name = $this->deleteArrayElement($data->config_additional_teacher_name, $key);
                    $data->config_additional_teacher_email = $this->deleteArrayElement($data->config_additional_teacher_email, $key);
                    $data->config_additional_teacher_location = $this->deleteArrayElement($data->config_additional_teacher_location, $key);
                    $data->config_additional_teacher_office_hours = $this->deleteArrayElement($data->config_additional_teacher_office_hours, $key);
                    $data->teacher_repeats=$data->teacher_repeats-1;
                }
            }
            
            // Any empty additional teaching sessions also need to be removed
            $names = $data->config_additional_session_subheading;
            foreach($names as $key=>$value) {
                if(strlen($value) == 0 || $value == NULL) {
                    $data->config_additional_session_subheading = $this->deleteArrayElement($data->config_additional_session_subheading, $key);
                    $data->config_additional_session_day = $this->deleteArrayElement($data->config_additional_session_day, $key);
                    $data->config_additional_session_time = $this->deleteArrayElement($data->config_additional_session_time, $key);
                    $data->config_additional_session_location = $this->deleteArrayElement($data->config_additional_session_location, $key);
                    $data->session_repeats=$data->session_repeats-1;
                }
            }
            
            global $COURSE;
            $fileoptions = array('subdirs'=>1,
            		'maxbytes'=>$COURSE->maxbytes,
            		'accepted_types'=>'*',
            		'return_types'=>FILE_INTERNAL);
            
            file_postupdate_standard_filemanager($data,
            		'files',
            		$fileoptions,
            		$this->page->context,
            		'block_module_info',
            		'documents',
            		$this->block->context->id);
        } 
        return $data;
    }
    
    function set_data($default_values) {
        
        parent::set_data($default_values);
        
    }
    
    function validation($data, $files) {
        $errors = parent::validation($data, $files);
          
        return $errors;
    }
    
}