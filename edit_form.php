<?php
 
class block_module_info_edit_form extends block_edit_form {
 
    protected function specific_definition($mform) {

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
        
        // Module owner name
        $mform->addElement('advcheckbox', 'config_display_convenor_name', get_string('config_display_convenor_name', 'block_module_info'));
        $mform->setDefault('config_display_convenor_name', 1);
        $mform->addElement('text', 'config_convenor_name_override', get_string('config_convenor_name_override', 'block_module_info'));
        
        // Module owner email
        $mform->addElement('advcheckbox', 'config_display_convenor_email', get_string('config_display_convenor_email', 'block_module_info'));
        $mform->setDefault('config_display_convenor_email', 1);
        $mform->addElement('text', 'config_convenor_email_override', get_string('config_convenor_email_override', 'block_module_info'));
        $mform->setType('config_convenor_email_override', PARAM_EMAIL);
        
        // Module owner location
        $mform->addElement('advcheckbox', 'config_display_convenor_location', get_string('config_display_convenor_location', 'block_module_info'));
        $mform->setDefault('config_display_convenor_location', 1);
        $mform->addElement('text', 'config_convenor_location_override', get_string('config_convenor_location_override', 'block_module_info'));
        
        // Module owner office hours
        $mform->addElement('advcheckbox', 'config_display_convenor_office_hours', get_string('config_display_convenor_office_hours', 'block_module_info'));
        $mform->setDefault('config_display_convenor_office_hours', 1);
        $mform->addElement('text', 'config_convenor_office_hours_override', get_string('config_convenor_office_hours_override', 'block_module_info'));
        
        // Personal web page
        $mform->addElement('advcheckbox', 'config_display_convenor_personal_webpage', get_string('config_display_convenor_personal_webpage', 'block_module_info'));
        $mform->setDefault('config_display_convenor_personal_webpage', 1);
        
        // Additional teachers
        $mform->addElement('header', 'configheader', get_string('additional_teachers_header', 'block_module_info'));
        
        $mform->addElement('text', 'config_additional_teachers_heading', get_string('config_additional_teachers_heading', 'block_module_info'));
        $mform->setDefault('config_additional_teachers_heading', get_string('config_additional_teachers_heading_default', 'block_module_info'));
        
        $repeatarray = array();
        $repeatarray[] = $mform->createElement('header', '', get_string('config_additional_teacher','block_module_info').' {no}');
        $repeatarray[] = $mform->createElement('text', 'config_additional_teacher_name', get_string('config_additional_teacher_name','block_module_info'));
        $repeatarray[] = $mform->createElement('text', 'config_additional_teacher_email', get_string('config_additional_teacher_email','block_module_info'));
        $repeatarray[] = $mform->createElement('text', 'config_additional_teacher_location', get_string('config_additional_teacher_location','block_module_info'));
        $repeatarray[] = $mform->createElement('text', 'config_additional_teacher_office_hours', get_string('config_additional_teacher_office_hours','block_module_info'));
        $repeatarray[] = $mform->createElement('hidden', 'additionalteacherid', 0);
        
        if ($this->_instance) {
            $repeatno = $DB->count_records('moduleinfo_teachers', array('moduleinfoid'=>$this->_instance));
            $repeatno += 1;
        } else {
            $repeatno = 1;
        }
        
        // No settings options specified for now...
        $repeateloptions = array();
        
        $mform->setType('additionalteacherid', PARAM_INT);
        
        $this->repeat_elements($repeatarray, $repeatno,
                $repeateloptions, 'option_repeats', 'option_add_fields', 1);
        
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
        
        if ($this->_instance) {
            $sessionno = $DB->count_records('moduleinfo_sessions', array('moduleinfoid'=>$this->_instance));
            $sessionno += 1;
        } else {
            $sessionno = 1;
        }
        
        // No settings options specified for now...
        $repeateloptions = array();
        
        $mform->setType('additionalsessionid', PARAM_INT);
        
        $this->repeat_elements($sessionarray, $sessionno,
                $repeateloptions, 'option_repeats', 'option_add_fields', 1);
        
        
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
}