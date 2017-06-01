<?php

// Configuration of the Form Generator.

$tweak = array(); // Options oriented more toward user preferences. 

$tweak['align_right'] = 1; // [0|1] 1 = CSS based right-align style for numeric, date, set, and enum columns.

// If the above is set to 0 then an alternative right-align 
// method for individual columns would be to manually set 
// 'colattrs' => 'style="text-align:right;"'
// in the individual field arrays found in the generated script.

$tweak['email'] = 1; // [0|1] Author preference 1: if a column name contains email, apply the option 'URL' mailto: 

$tweak['url'] = 1; // [0|1] Author preference 1: if a column name contains url, apply the 'URL' option 

// Author preference: exact column names which, if found, may receive special treatment below.
$tweak['enum'] = array('active', 'hidden', 'deleted'); 

// Either 0 -or- 1 is passed from the Toggle No/Yes selection.
// 0 or 1 become part of the the generated filename.
$tweak['toggle'] = intval($_REQUEST['o1']); 

$pme = array(); // configuration options oriented more toward phpMyEdit

$pme['datemask_usage'] = 0; // [0|1] 1 enables phpMyEdit's seldom used datemask option

$pme['file']['write'] = 1; // [0|1] write to disk on/off

$pme['file']['backup'] = 0; // [0|1] append .bak to an existing script if it exists, then write the new script

$pme['file']['dir'] = './'; // relative output directory

// Filename prefix used in the naming convention draft.database.table.php
$pme['file']['prefix'] = 'draft.';

// Filename format: draft.database.table.toggle.n.php where n is either 0 or 1 depending on toggle selection. 
$pme['file']['format'] = $pme['file']['prefix'].$cfg['server'][$sn]['db'].'.'.$tb.'.'.$tweak['toggle'].'.php'; 

// Limit the number of columns assigned permission options of ACPVDFL.
// The auto_increment column 0 is can be easily suppressed with permission option VD.
// Set a large number if you always want all columns displayed.
$pme['list_mode_num_cols'] = 15; // Edit: column 0 will be displayed in List mode followed by the next 5 columns

// Help links displayed in ACP modes can provide users with information relevant to each field.
// MySQL column comments entered in phpMyAdmin when designing a table can be incorporated as Help.
// Many options are possible. Un-comment only one of the following options.
// $pme['help_method'] = 0; // omit help|ACP
// $pme['help_method'] = 1; // display character limit
// $pme['help_method'] = 2; // legacy, display link to Help popup (you must create popup.php, see $help_link in pme.config.php)
// $pme['help_method'] = 3; // display help|ACP commented out (no value) so that you can selectively configure individual fields
// $pme['help_method'] = 4; // display "Entry Required"
$pme['help_method'] = 5; // display the MySQL column comment (if phpMyAdmin was utilized to enter column comments)

// Javascript ['js']['requred'] usage settings are [0|1|-1]
// 0 applies JS to 3 columns then applies it (commented out) to the remaining columns.
// 1 applies JS to all columns.
// -1 (minus one) omits JS completely.
// Omitted where the default value is NULL. 
// If you defined the column as NULL, the odds are there won't be an entry.
$pme['js']['usage'] = -1; // [0|1|-1] affects ['js']['requred'] entry

 // Labels

$pme['label']['characters'] = 'characters';

$pme['label']['date'] = 'YYYY-MM-DD';

$pme['label']['datetime'] = 'YYYY-MM-DD HH:MM:SS';

$pme['label']['digits'] = 'digits';

$pme['label']['limit'] = 'Limit';

$pme['label']['required'] = 'Entry Required';

$pme['label']['select'] = 'Select';

$pme['label']['time'] = 'HH:MM:SS';

$pme['label']['timestamp'] = 'Timestamp';

$pme['label']['year'] = 'YYYY';

$pme['label']['js_hint'] = 'An entry is required for';

// Defaults for various TEXTAREA attributes. Bootstrap "may" elect to over-ride the rows and cols settings below.

$pme['textarea']['rows'] = 10; 

$pme['textarea']['sorting'] = 0; // [0|1] For performance reasons, BLOB column sorting should be disallowed using 0

$pme['textarea']['striptags'] = 1; // [0|1] Set 0 ONLY if entering HTML in a specific column.

$pme['textarea']['trimlen'] = 50;

// Following the conversion to Bootstrap, size value 
// for INPUT tags was hacked around line 1607 of generator.steps.php 
// and made relative: ($pme['textarea']['cols'] - 18)

if(empty($pme['help_method'])){

	$pme['textarea']['cols'] = 120; // If not using Help then TEXTAREA cols could be larger.

}else{

	$pme['textarea']['cols'] = 90; // if Help is utilized, reduce the TEXTAREA cols setting

}

// Query used to determine table properties. Does not facilitate reporting the number of rows in the selected table.

$table_sql = <<<HEREDOC_VAR
SELECT ORDINAL_POSITION, COLUMN_NAME, COLUMN_TYPE, DATA_TYPE,
CHARACTER_MAXIMUM_LENGTH, COLUMN_DEFAULT, NUMERIC_PRECISION,
COLUMN_KEY, EXTRA, IS_NULLABLE, CHARACTER_SET_NAME, COLLATION_NAME, COLUMN_COMMENT
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA = '%s' AND TABLE_NAME = '%s' ORDER BY ORDINAL_POSITION
HEREDOC_VAR;

// 2011 reserved words list for PHP and MySQL ... about 603 reserved words are tested against column names.
$reserved_words = array( 'abday_1', ' abday_2', ' abday_3', ' abday_4', ' abday_5', ' abday_6', ' abday_7', ' abmon_1', ' abmon_10', ' abmon_11', ' abmon_12', ' abmon_2', ' abmon_3', ' abmon_4', ' abmon_5', ' abmon_6', ' abmon_7', ' abmon_8', ' abmon_9', ' abstract', ' accessible', ' action', ' add', ' after', ' against', ' aggregate', ' algorithm', ' all', ' alter', ' alt_digits', ' am_str', ' analyse', ' analyze', ' and', ' array', ' as', ' asc', ' assert_active', ' assert_bail', ' assert_callback', ' assert_quiet_eval', ' assert_warning', ' autocommit', ' auto_increment', ' avg_row_length', ' backup', ' begin', ' between', ' binlog', ' both', ' break', ' by', ' cascade', ' case', ' case_lower', ' case_upper', ' catch', ' cfunction', ' change', ' changed', ' charset', ' char_max', ' check', ' checksum', ' class', ' clone', ' codeset', ' collate', ' collation', ' column', ' columns', ' comment', ' commit', ' committed', ' compressed', ' concurrent', ' connection_aborted', ' connection_normal', ' connection_timeout', ' const', ' constraint', ' contains', ' continue', ' convert', ' count_normal', ' count_recursive', ' create', ' credits_all', ' credits_docs', ' credits_fullpage', ' credits_general', ' credits_group', ' credits_modules', ' credits_qa', ' credits_sapi', ' crncystr', ' cross', ' crypt_blowfish', ' crypt_ext_des', ' crypt_md5', ' crypt_salt_length', ' crypt_std_des', ' currency_symbol', ' current_timestamp', ' database', ' databases', ' day', ' day_1', ' day_2', ' day_3', ' day_4', ' day_5', ' day_6', ' day_7', ' day_hour', ' day_minute', ' day_second', ' decimal_point', ' declare', ' default', ' default_include_path', ' definer', ' delayed', ' delay_key_write', ' delete', ' desc', ' describe', ' deterministic', ' die', ' directory_separator', ' distinct', ' distinctrow', ' div', ' do', ' drop', ' dumpfile', ' duplicate', ' dynamic', ' d_fmt', ' d_t_fmt', ' echo', ' else', ' elseif', ' empty', ' enclosed', ' end', ' enddeclare', ' endfor', ' endforeach', ' endif', ' endswitch', ' endwhile', ' engine', ' engines', ' ent_compat', ' ent_noquotes', ' ent_quotes', ' era', ' era_d_fmt', ' era_d_t_fmt', ' era_t_fmt', ' era_year', ' escape', ' escaped', ' eval', ' events', ' execute', ' exists', ' exit', ' explain', ' extended', ' extends', ' extr_if_exists', ' extr_overwrite', ' extr_prefix_all', ' extr_prefix_if_exists', ' extr_prefix_invalid', ' extr_prefix_same', ' extr_skip', ' e_all', ' e_compile_error', ' e_compile_warning', ' e_core_error', ' e_core_warning', ' e_deprecated', ' e_error', ' e_notice', ' e_parse', ' e_strict', ' e_user_deprecated', ' e_user_error', ' e_user_notice', ' e_user_warning', ' e_warning', ' false', ' fast', ' fields', ' file', ' final', ' first', ' fixed', ' flush', ' for', ' force', ' foreach', ' foreign', ' frac_digits', ' from', ' full', ' fulltext', ' function', ' gemini', ' gemini_spin_retries', ' global', ' goto', ' grant', ' grants', ' group', ' grouping', ' having', ' heap', ' high_priority', ' hosts', ' hour', ' hour_minute', ' hour_second', ' html_entities', ' html_specialchars', ' identified', ' if', ' ignore', ' implements', ' in', ' include', ' include_once', ' index', ' indexes', ' infile', ' info_all', ' info_configuration', ' info_credits', ' info_environment', ' info_general', ' info_license', ' info_modules', ' info_variables', ' ini_all', ' ini_perdir', ' ini_system', ' ini_user', ' inner', ' insert', ' insert_id', ' insert_method', ' instanceof', ' interface', ' interval', ' into', ' int_curr_symbol', ' int_frac_digits', ' invoker', ' is', ' isolation', ' isset', ' join', ' key', ' keys', ' kill', ' last_insert_id', ' lc_all', ' lc_collate', ' lc_ctype', ' lc_messages', ' lc_monetary', ' lc_numeric', ' lc_time', ' leading', ' left', ' level', ' like', ' limit', ' linear', ' lines', ' list', ' load', ' local', ' lock', ' locks', ' lock_ex', ' lock_nb', ' lock_sh', ' lock_un', ' logs', ' log_alert', ' log_auth', ' log_authpriv', ' log_cons', ' log_crit', ' log_cron', ' log_daemon', ' log_debug', ' log_emerg', ' log_err', ' log_info', ' log_kern', ' log_local0', ' log_local1', ' log_local2', ' log_local3', ' log_local4', ' log_local5', ' log_local6', ' log_local7', ' log_lpr', ' log_mail', ' log_ndelay', ' log_news', ' log_notice', ' log_nowait', ' log_odelay', ' log_perror', ' log_pid', ' log_syslog', ' log_user', ' log_uucp', ' log_warning', ' low_priority', ' maria', ' master', ' master_connect_retry', ' master_host', ' master_log_file', ' master_log_pos', ' master_password', ' master_port', ' master_user', ' match', ' max_connections_per_hour', ' max_queries_per_hour', ' max_rows', ' max_updates_per_hour', ' max_user_connections', ' medium', ' merge', ' minute', ' minute_second', ' min_rows', ' mode', ' modify', ' month', ' mon_1', ' mon_10', ' mon_11', ' mon_12', ' mon_2', ' mon_3', ' mon_4', ' mon_5', ' mon_6', ' mon_7', ' mon_8', ' mon_9', ' mon_decimal_point', ' mon_grouping', ' mon_thousands_sep', ' mrg_myisam', ' myisam', ' m_1_pi', ' m_2_pi', ' m_2_sqrtpi', ' m_e', ' m_ln10', ' m_ln2', ' m_log10e', ' m_log2e', ' m_pi', ' m_pi_2', ' m_pi_4', ' m_sqrt1_2', ' m_sqrt2', ' names', ' namespace', ' natural', ' negative_sign', ' new', ' noexpr', ' nostr', ' not', ' null', ' n_cs_precedes', ' n_sep_by_space', ' n_sign_posn', ' offset', ' old_function', ' on', ' open', ' optimize', ' option', ' optionally', ' or', ' order', ' outer', ' outfile', ' pack_keys', ' page', ' partial', ' partition', ' partitions', ' password', ' pathinfo_basename', ' pathinfo_dirname', ' pathinfo_extension', ' path_separator', ' pear_extension_dir', ' pear_install_dir', ' php_bindir', ' php_config_file_path', ' php_config_file_scan_dir', ' php_datadir', ' php_debug', ' php_eol', ' php_extension_dir', ' php_extra_version', ' php_int_max', ' php_int_size', ' php_libdir', ' php_localstatedir', ' php_major_version', ' php_maxpathlen', ' php_minor_version', ' php_os', ' php_output_handler_cont', ' php_output_handler_end', ' php_output_handler_start', ' php_prefix', ' php_release_version', ' php_sapi', ' php_shlib_suffix', ' php_sysconfdir', ' php_version', ' php_version_id', ' php_windows_nt_domain_controller', ' php_windows_nt_server', ' php_windows_nt_workstation', ' php_windows_version_build', ' php_windows_version_major', ' php_windows_version_minor', ' php_windows_version_platform', ' php_windows_version_producttype', ' php_windows_version_sp_major', ' php_windows_version_sp_minor', ' php_windows_version_suitemask', ' php_zts', ' pm_str', ' positive_sign', ' primary', ' print', ' private', ' privileges', ' procedure', ' process', ' processlist', ' protected', ' public', ' purge', ' p_cs_precedes', ' p_sep_by_space', ' p_sign_posn', ' quick', ' radixchar', ' raid0', ' raid_chunks', ' raid_chunksize', ' raid_type', ' range', ' read', ' read_only', ' read_write', ' references', ' regexp', ' reload', ' rename', ' repair', ' repeatable', ' replace', ' replication', ' require', ' require_once', ' reset', ' restore', ' restrict', ' return', ' returns', ' revoke', ' right', ' rlike', ' rollback', ' row', ' rows', ' row_format', ' second', ' security', ' seek_cur', ' seek_end', ' seek_set', ' select', ' separator', ' serializable', ' session', ' share', ' show', ' shutdown', ' slave', ' soname', ' sort_asc', ' sort_desc', ' sort_numeric', ' sort_regular', ' sort_string', ' sounds', ' sql', ' sql_auto_is_null', ' sql_big_result', ' sql_big_selects', ' sql_big_tables', ' sql_buffer_result', ' sql_cache', ' sql_calc_found_rows', ' sql_log_bin', ' sql_log_off', ' sql_log_update', ' sql_low_priority_updates', ' sql_max_join_size', ' sql_no_cache', ' sql_quote_show_create', ' sql_safe_updates', ' sql_select_limit', ' sql_slave_skip_counter', ' sql_small_result', ' sql_warnings', ' start', ' starting', ' static', ' status', ' stop', ' storage', ' straight_join', ' string', ' striped', ' str_pad_both', ' str_pad_left', ' str_pad_right', ' super', ' switch', ' table', ' tables', ' temporary', ' terminated', ' then', ' thousands_sep', ' thousep', ' throw', ' to', ' trailing', ' transactional', ' true', ' truncate', ' try', ' type', ' types', ' t_fmt', ' t_fmt_ampm', ' uncommitted', ' union', ' unique', ' unlock', ' unset', ' update', ' usage', ' use', ' using', ' values', ' var', ' variables', ' view', ' when', ' where', ' while', ' with', ' work', ' write', ' xor', ' year_month', ' yesexpr', ' yesstr', ' __class__', ' __compiler_halt_offset__', ' __dir__', ' __file__', ' __function__', ' __line__', ' __method__', ' __namespace__' );

?>
