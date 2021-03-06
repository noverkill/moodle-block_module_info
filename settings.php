<?php

/****************************************************************

File:       block/module_info/settings.php

Purpose:    Global configuration page for the block

****************************************************************/

global $DB;

$settings->add(new admin_setting_heading('block_module_info/mis_connection', get_string('mis_connection', 'block_module_info'), get_string('mis_connection_desc', 'block_module_info')));

$options = array(
    ' '     => get_string('noconnection','block_module_info'),
    'mssql' => 'Mssql',
    'mysql' => 'Mysql',
    'odbc' => 'Odbc',
    'oci8' => 'Oracle',
    'postgres' => 'Postgres',
    'sybase' => 'Sybase'
);

$mis_connection	= new admin_setting_configselect('block_module_info/dbconnectiontype',get_string('db_connection','block_module_info'),'', '', $options);

$settings->add( $mis_connection );


$settings->add(new admin_setting_configtext('block_module_info/dbname',get_string( 'db_name', 'block_module_info' ),get_string( 'set_db_name', 'block_module_info' ),'',PARAM_RAW));

$settings->add(new admin_setting_configtext('block_module_info/dbprefix',get_string( 'db_prefix', 'block_module_info' ),get_string( 'prefix_for_tablenames', 'block_module_info' ),'',PARAM_RAW));

$settings->add(new admin_setting_configtext('block_module_info/dbhost',get_string( 'db_host', 'block_module_info' ), get_string( 'host_name_or_ip', 'block_module_info' ),'',PARAM_RAW));

$settings->add(new admin_setting_configtext('block_module_info/dbtable',get_string( 'db_table', 'block_module_info' ), get_string( 'db_table', 'block_module_info' ),'',PARAM_RAW));

$settings->add(new admin_setting_configtext('block_module_info/dbuser',get_string( 'db_user', 'block_module_info' ), get_string( 'db_user', 'block_module_info' ),'',PARAM_RAW));

$settings->add(new admin_setting_configtext('block_module_info/dbpass',get_string( 'db_pass', 'block_module_info' ), get_string( 'db_pass', 'block_module_info' ),'',PARAM_RAW));

$settings->add(new admin_setting_heading('block_module_info/data_mapping', get_string('data_mapping', 'block_module_info'), get_string('data_mapping_desc', 'block_module_info')));

$settings->add(new admin_setting_configtext('block_module_info/extcourseid',get_string('extcourseid', 'block_module_info'),get_string('extcourseiddesc', 'block_module_info'),'',PARAM_RAW));

$settings->add(new admin_setting_configtext('block_module_info/module_code',get_string( 'module_code', 'block_module_info' ), get_string( 'module_code', 'block_module_info' ),'',PARAM_RAW));

$settings->add(new admin_setting_configtext('block_module_info/module_level',get_string( 'module_level', 'block_module_info' ), get_string( 'module_level', 'block_module_info' ),'',PARAM_RAW));

$settings->add(new admin_setting_configtext('block_module_info/module_credit',get_string( 'module_credit', 'block_module_info' ), get_string( 'module_credit', 'block_module_info' ),'',PARAM_RAW));

$settings->add(new admin_setting_configtext('block_module_info/module_semester',get_string( 'module_semester', 'block_module_info' ), get_string( 'module_semester', 'block_module_info' ),'',PARAM_RAW));

$settings->add(new admin_setting_configtext('block_module_info/convenor_name',get_string( 'convenor_name', 'block_module_info' ), get_string( 'convenor_name', 'block_module_info' ),'',PARAM_RAW));

// Allow display of an extra profile field (e.g. candidate number or idnumber).
$profile_fields = array('none' => get_string('noid', 'block_module_info'),
						'username' => get_string('username'),
						'idnumber' => get_string('idnumber'),
						'email' => get_string('email'));

$settings->add(new admin_setting_configselect('block_module_info/convenorid',get_string('convenorid', 'block_module_info'),get_string('convenorid', 'block_module_info'),'none', $profile_fields));

$settings->add(new admin_setting_configtext('block_module_info/convenor',get_string( 'convenor', 'block_module_info' ), get_string( 'convenor', 'block_module_info' ),'',PARAM_RAW));

$settings->add(new admin_setting_heading('block_module_info/smart', get_string('setting_header_smart', 'block_module_info'), get_string('setting_header_smart_desc', 'block_module_info')));

$settings->add(new admin_setting_configtext('block_module_info/baseurl', get_string('setting_baseurl', 'block_module_info'),
        get_string('setting_baseurl_desc', 'block_module_info'), 'http://dev.timetables.qmul.ac.uk/dEVSCI1314SWS/timetable.asp', PARAM_RAW));

$settings->add(new admin_setting_configtext('block_module_info/day', get_string('setting_dayrange', 'block_module_info'),
        get_string('setting_dayrange_desc', 'block_module_info'), '1-5', PARAM_RAW));

$settings->add(new admin_setting_configtext('block_module_info/week', get_string('setting_weekrange', 'block_module_info'),
        get_string('setting_weekrange_desc', 'block_module_info'), '1-52', PARAM_RAW));

$settings->add(new admin_setting_configtext('block_module_info/period', get_string('setting_periodrange', 'block_module_info'),
        get_string('setting_periodrange_desc', 'block_module_info'), '1-2', PARAM_RAW));

$settings->add(new admin_setting_configtext('block_module_info/style', get_string('setting_style', 'block_module_info'),
        get_string('setting_style_desc', 'block_module_info'), 'individual', PARAM_RAW));

$settings->add(new admin_setting_configtext('block_module_info/template', get_string('setting_template', 'block_module_info'),
        get_string('setting_template_desc', 'block_module_info'), 'swsnet+object+individual', PARAM_RAW));

$settings->add(new admin_setting_heading('block_module_info/default', get_string('default', 'block_module_info'), get_string('default_desc', 'block_module_info')));

// Default settings

$settings->add(new admin_setting_configtextarea('block_module_info/convenor_role_name_options', get_string('convenor_role_name_options', 'block_module_info'), get_string('convenor_role_name_options_desc', 'block_module_info'), get_string('convenor_role_name_default', 'block_module_info'), PARAM_RAW, '65', '10'));

$settings->add(new admin_setting_configtextarea('block_module_info/additional_teacher_role_name_options', get_string('additional_teacher_role_name_options', 'block_module_info'), get_string('additional_teacher_role_name_options_desc', 'block_module_info'), get_string('additional_teacher_role_name_default', 'block_module_info'), PARAM_RAW, '65', '10'));

$profile_fields = array('name'=>get_string('fullname'));
$profile_fields = array_merge($profile_fields, array('profilepic'=>get_string('profilepic', 'block_module_info')));
$profile_fields = array_merge($profile_fields, array('email'=>get_string('email')));
$profile_fields = array_merge($profile_fields, array('url'=>get_string('url')));
$profile_fields = array_merge($profile_fields, array('icq'=>get_string('icqnumber')));
$profile_fields = array_merge($profile_fields, array('skype'=>get_string('skypeid')));
$profile_fields = array_merge($profile_fields, array('aim'=>get_string('aimid')));
$profile_fields = array_merge($profile_fields, array('yahoo'=>get_string('yahooid')));
$profile_fields = array_merge($profile_fields, array('msn'=>get_string('msnid')));
$profile_fields = array_merge($profile_fields, array('idnumber'=>get_string('idnumber')));
$profile_fields = array_merge($profile_fields, array('institution'=>get_string('institution')));
$profile_fields = array_merge($profile_fields, array('department'=>get_string('department')));
$profile_fields = array_merge($profile_fields, array('phone1'=>get_string('phone')));
$profile_fields = array_merge($profile_fields, array('phone2'=>get_string('phone2')));
$profile_fields = array_merge($profile_fields, array('address'=>get_string('address')));

// Add custom profile fields to display options
if ($fields = $DB->get_records('user_info_field')) {
    foreach ($fields as $field) {
        $profile_fields = array_merge($profile_fields, array(format_string($field->shortname)=>format_string($field->name)));
    }
}

$settings->add(new admin_setting_configmultiselect('block_module_info/person_display_options', get_string('person_display_options', 'block_module_info'), get_string('person_display_options_desc', 'block_module_info'), array(), $profile_fields));

$settings->add(new admin_setting_confightmleditor('block_module_info/defaulthtml',get_string( 'defaulthtml', 'block_module_info' ), get_string( 'defaulthtml', 'block_module_info' ),''));
