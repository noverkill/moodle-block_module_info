<?php
    $string['pluginname'] = 'Module Info';
    $string['module_info'] = 'Module Info';
	
	//Config Form DB Connection Section
	$string['noconnection'] = 'No Connection';
    $string['mis_connection'] = 'MIS Connection';
    $string['mis_connection_desc'] = 'Specify connection to the database containing course module data.';
    
    $string['db_connection'] = 'DB Connection';
    $string['db_name'] = 'DB Name';
    $string['set_db_name'] = 'set the name of the DB';
    $string['db_prefix'] = 'DB Prefix';
    $string['prefix_for_tablenames'] = 'Prefix for tablenames (if any)';
    $string['db_host'] = 'DB host';
    $string['host_name_or_ip'] = 'DB Hostname or IP';
    $string['db_table'] = 'DB table';
    $string['db_pass'] = 'DB Password';
    $string['db_user'] = 'DB Username';
	
	//Config Data Mapping Fields
	$string['data_mapping'] = 'Data Mapping';
	$string['data_mapping_desc'] = 'The name of the field in the remote table that maps onto the given variable.';
    $string['extcourseid']  = 'Course ID';
    $string['extcourseiddesc'] = 'This field should map to course->idnumber in Moodle';
	$string['module_code'] = 'Code';
	$string['module_level'] = 'Level';
	$string['module_credit'] = 'Credit Value';
	$string['module_semester'] = 'Semester';
	$string['convenor'] = 'Convenor';
	$string['convenorid'] = 'Convenor Identifier';
	$string['convenor_name']  = 'Convenor Name';
	$string['noid'] = 'No ID';
	
	// SMART Timetabling
	$string['setting_header_smart'] = "SMART Timtable Settings";
	$string['setting_header_smart_desc'] = "QMplus settings for timetabling service Scientia Enterprise also know as SMART (Space Management and Room Timetabling). ";
	
	$string['setting_baseurl'] = 'Base Url';
	$string['setting_baseurl_desc'] = 'the base Url for the service';
	
	$string['setting_title'] = 'Block Title';
	$string['setting_title_desc'] = 'the block title';
	
	$string['setting_weekrange'] = 'Week Range';
	$string['setting_weekrange_desc'] = 'The weeks to generate for the timetable. Can be a a single week (e.g. 1), a consecutive week range (e.g. 1-10) or set of non-consecutive weeks (e.g. 2;4;6). If omitted then the current week is displayed.';
	
	$string['setting_dayrange'] = 'Day Range';
	$string['setting_dayrange_desc'] = 'The days to include in the timetable where 1 = Monday through to 7 = Sunday. Can be a single day (e.g. 1), consecutive day range (e.g. 1-5) or set of non-consecutive days (e.g. 1,5). If omitted then all days are displayed.';
	
	$string['setting_periodrange'] = 'Period Range';
	$string['setting_periodrange_desc'] = 'A consecutive period range. You cannot have a single period or a non-consecutive period range. QMUL periods run from 08:00 – 23:00, so 09:00 would be period 3 and 18:00 would be period 20. If omitted then all periods are displayed.';
	
	$string['setting_template'] = 'Timetabling template';
	$string['setting_template_desc'] = 'Timetabling template';
	
	$string['setting_style'] = 'Timetabling Style';
	$string['setting_style_desc'] = 'Timetabling Style';
	
	$string['default_personal_smart_link'] = 'Personal timetable';
	$string['student_personal_smart_link'] = 'Personal timetable';
	$string['staff_personal_smart_link'] = 'Personal timetable';
	
	$string['default_module_smart_link'] = 'Module timetable';
	$string['student_module_smart_link'] = 'Module timetable';
	$string['staff_module_smart_link'] = 'Module timetable';
	
	//Config Defaults
	$string['default'] = 'Defaults';
	$string['default_desc'] = 'Block default configuration settings can be specified here.';
	
	$string['convenor_role_name_options'] = 'Module owner names';
	$string['convenor_role_name_options_desc'] = 'Possible valid alternative names for the module owner are \'Convenor\' or \'Module Organiser\', for instance. Write each option on a new line.';
	$string['convenor_role_name_default'] = 'Module Owner';
	$string['additional_teacher_role_name_options'] = 'Additional teacher names';
	$string['additional_teacher_role_name_options_desc'] = 'Possible valid alternative names for additional teachers are \'Additional teachers\' or \'Teaching assistants\', for example. Write each option on a new line.';
	$string['additional_teacher_role_name_default'] = 'Additional Teachers';
	
	$string['defaulthtml'] = 'Default HTML';

    //Customisations
    
	// Core info
	$string['core_info_header'] = 'Core info';
	$string['override_setting'] = 'Enter custom setting here';
    $string['config_title'] = 'Block title';
    $string['config_title_help'] = 'This is the title that will appear at the top of the block.';
    $string['config_module_code'] = 'Custom Module Code';
    $string['config_module_code_override'] = 'Custom Code';
    $string['config_module_level'] = 'Custom Module Level';
    $string['config_module_level_override'] = 'Override Level';
    $string['config_module_credit'] = 'Custom Module Credits';
    $string['config_module_credit_override'] = 'Override Credit Value';
    $string['config_module_semester'] = 'Custom Module Semester';
    $string['config_module_semester_override'] = 'Override Semester';

    // Help buttons
    $string['module_code_help'] = 'Enable this setting to override the module code. The code is taken automatically from information stored in SITS. However, this can be replaced by text entered into the text box on the right.';
    $string['module_level_help'] = 'Enable this setting to override the module level. The code is taken automatically from information stored in SITS. However, this can be replaced by text entered into the text box on the right.';
    $string['module_credit_help'] = 'Enable this setting to override the module credits. The code is taken automatically from information stored in SITS. However, this can be replaced by text entered into the text box on the right.';
    $string['module_semester_help'] = 'Enable this setting to override the semester. The code is taken automatically from information stored in SITS. However, this can be replaced by text entered into the text box on the right.';
    
    // Person display options
    $string['person_display_options'] = 'Global profile display options';
    $string['person_display_options_desc'] = 'Course owners can choose to display the profile fields selected here.';
    
    // Teaching
    $string['teaching_header'] = 'Teaching';
    
    $string['no_teacher_heading'] = 'None';
    $string['custom_teacher_heading'] = 'Custom';
    $string['config_custom_teacher_heading'] = 'Custom heading';
    
    $string['location'] = 'Location';
    $string['officehours'] = 'Office hours';
    $string['profilepic'] = 'Profile picture';
    $string['profilepic_size'] = 'Profile picture size';
    $string['small'] = 'Small';
    $string['large'] = 'Large';
    $string['config_module_owner_heading'] = 'Module Owner heading';
    $string['config_module_owner_heading_help'] = 'Schools and faculties have their own name to describe the module owner. Select from the predefined options or select \'Custom\' to enter your own.';
    $string['config_display_convenor_options'] = 'Module owner display options';
    $string['config_convenor_name_override'] = 'Module Owner name override';
    $string['config_convenor_email_override'] = 'Module owner email override';
    $string['config_convenor_location_override'] = 'Module owner location override';
    $string['config_display_convenor_office_hours'] = 'Display module owner office hours';
    $string['config_convenor_office_hours_override'] = 'Module owner office hours override';
    $string['config_display_convenor_personal_webpage'] = 'Display personal webpage';
    
    // Additional teachers
    $string['additional_teachers_header'] = 'Additional teachers';
    
    $string['config_additional_teachers_heading'] = 'Additional teachers heading';
    $string['config_additional_teachers_heading_help'] = 'Schools and faculties have their own name to describe additional teachers. Select from the predefined options or select \'Custom\' to enter your own.';
    $string['config_custom_additional_teachers_heading'] = 'Custom heading';
    
    $string['config_additional_teachers_heading_default'] = 'e.g. GTAs, TAs';
    $string['config_display_additional_teacher_options'] = 'Additional teacher display options';
    
    $string['config_additional_teacher'] = 'Additional teacher';
    $string['config_additional_teacher_name'] = 'Name';
    $string['config_additional_teacher_email'] = 'Email';
    $string['config_additional_teacher_location'] = 'Location';
    $string['config_additional_teacher_office_hours'] = 'Office hours';
    
    // Schedule
    $string['schedule_header'] = 'Schedule';
    $string['config_enable_personal_timetable_link'] = 'Display personal timetable link (SMART)';
    $string['config_enable_module_timetable_link'] = 'Display module timetable link (SMART)';
    $string['login_to_view_timetable'] = 'Log in to view your personal timetable.';
    
    $string['config_additional_session'] = 'Additional teaching session';
    $string['config_additional_session_subheading'] = 'Teaching subheading';
    $string['config_additional_session_day'] = 'Day';
    $string['config_additional_session_time'] = 'Time';
    $string['config_additional_session_location'] = 'Location';
    
    $string['session_details'] = '{$a->day} {$a->time} {$a->location}';
    $string['nosessionsavailable'] = 'No extra sessions configured';
    
    // Documents
    $string['documents_header'] = 'Documents';
    $string['config_hide_document_section_if_empty'] =  'Hide documents section if empty';
    
    // Legacy
    $string['legacy_header'] = 'Additional Content';
    
    $string['convenor_not_found'] = ' not found in QMplus database';
    
    $string['config_html'] = 'Display HTML';
    $string['config_htmlcontent'] = 'HTML Content';
    $string['reset'] = 'Reset HTML - cannot be undone';
    
    // Missing module
    $string['missing_module'] = 'Cannot find module details. Please ensure \'Course ID\' is set correctly for this page or edit this block to set your own values for module code, level, &c.';
    