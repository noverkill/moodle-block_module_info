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
 * Strings for component 'block_module_info', language 'en', branch 'MOODLE_20_STABLE'
 *
 * @package   block_module_info
 * @copyright 2012 onwards University of London Computer Centre
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
$mis_settings 	= new admin_setting_heading('block_module_info/mis_connection', get_string('mis_connection', 'block_module_info'), '');
$settings->add($mis_settings);

$options = array(
    ' '     => get_string('noconnection','block_module_info'),
    'mssql' => 'Mssql',
    'mysql' => 'Mysql',
    'odbc' => 'Odbc',
    'oci8' => 'Oracle',
    'postgres' => 'Postgres',
    'sybase' => 'Sybase'
);
$mis_connection			= 	new admin_setting_configselect('block_module_info/dbconnectiontype',get_string('db_connection','block_module_info'),'', '', $options);
$settings->add( $mis_connection );
/*
*/

$dbname			=	new admin_setting_configtext('block_module_info/dbname',get_string( 'db_name', 'block_module_info' ),get_string( 'set_db_name', 'block_module_info' ),'',PARAM_RAW);
$settings->add($dbname);

$dbprefix			=	new admin_setting_configtext('block_module_info/dbprefix',get_string( 'db_prefix', 'block_module_info' ),get_string( 'prefix_for_tablenames', 'block_module_info' ),'',PARAM_RAW);
$settings->add($dbprefix);

$dbhost			=	new admin_setting_configtext('block_module_info/dbhost',get_string( 'db_host', 'block_module_info' ), get_string( 'host_name_or_ip', 'block_module_info' ),'',PARAM_RAW);
$settings->add($dbhost);

$dbtable			=	new admin_setting_configtext('block_module_info/dbtable',get_string( 'db_table', 'block_module_info' ), get_string( 'db_table', 'block_module_info' ),'',PARAM_RAW);
$settings->add($dbtable);

$dbuser			=	new admin_setting_configtext('block_module_info/dbuser',get_string( 'db_user', 'block_module_info' ), get_string( 'db_user', 'block_module_info' ),'',PARAM_RAW);
$settings->add( $dbuser );

$dbpass			=	new admin_setting_configtext('block_module_info/dbpass',get_string( 'db_pass', 'block_module_info' ), get_string( 'db_pass', 'block_module_info' ),'',PARAM_RAW);
$settings->add($dbpass);

$data_mapping 	= new admin_setting_heading('block_module_info/data_mapping', get_string('data_mapping', 'block_module_info'), '');
$settings->add($data_mapping);

$extcourseid = new admin_setting_configtext('block_module_info/extcourseid',get_string('extcourseid', 'block_module_info'),get_string('extcourseiddesc', 'block_module_info'),'',PARAM_RAW);
$settings->add($extcourseid);

$module_code		=	new admin_setting_configtext('block_module_info/module_code',get_string( 'module_code', 'block_module_info' ), get_string( 'module_code', 'block_module_info' ),'',PARAM_RAW);
$settings->add($module_code);

$module_level		=	new admin_setting_configtext('block_module_info/module_level',get_string( 'module_level', 'block_module_info' ), get_string( 'module_level', 'block_module_info' ),'',PARAM_RAW);
$settings->add($module_level);

$module_credit		=	new admin_setting_configtext('block_module_info/module_credit',get_string( 'module_credit', 'block_module_info' ), get_string( 'module_credit', 'block_module_info' ),'',PARAM_RAW);
$settings->add($module_credit);

$module_semester	=	new admin_setting_configtext('block_module_info/module_semester',get_string( 'module_semester', 'block_module_info' ), get_string( 'module_semester', 'block_module_info' ),'',PARAM_RAW);
$settings->add($module_semester);

$convenor_name		=	new admin_setting_configtext('block_module_info/convenor_name',get_string( 'convenor_name', 'block_module_info' ), get_string( 'convenor_name', 'block_module_info' ),'',PARAM_RAW);
$settings->add($convenor_name);

// Allow display of an extra profile field (e.g. candidate number or idnumber).
$profile_fields = array('none' => get_string('noid', 'block_module_info'),
						'username' => get_string('username'),
						'idnumber' => get_string('idnumber'),
						'email' => get_string('email'));

$convenorid = new admin_setting_configselect('block_module_info/convenorid',get_string('convenorid', 'block_module_info'),get_string('convenorid', 'block_module_info'),'none', $profile_fields);
$settings->add($convenorid);

$convenor =	new admin_setting_configtext('block_module_info/convenor',get_string( 'convenor', 'block_module_info' ), get_string( 'convenor', 'block_module_info' ),'',PARAM_RAW);
$settings->add($convenor);

$default 	= new admin_setting_heading('block_module_info/default', get_string('default', 'block_module_info'), '');
$settings->add($default);

$defaulthtml =	new admin_setting_confightmleditor('block_module_info/defaulthtml',get_string( 'defaulthtml', 'block_module_info' ), get_string( 'defaulthtml', 'block_module_info' ),'');
$settings->add($defaulthtml);
