<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<!-- Latest compiled and minified Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css">
<!-- default theme includes datepicker style  -->
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
	<nav class="navbar navbar-dark bg-primary">
		<button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar2">&#9776;</button>
		<div class="collapse navbar-toggleable-xs" id="exCollapsingNavbar2">
			<ul class="nav navbar-nav">
				<li class="nav-item"> <a class="nav-link" href="app-form-generator.php">Create Script</a> </li>
				<li class="nav-item"> <a class="nav-link" href="app-about.php">About</a> </li>
				<li class="nav-item"> <a class="nav-link" href="app-installation.php">Installation</a> </li>
				<li class="nav-item active"> <a class="nav-link" href="app-docs.php" title="phpMyEdit Documentation Links">Documentation Links</a> </li>
			</ul>
			<span class="navbar-text float-xs-right text-white">for MySQL&trade; MyISAM tables and PHP</span>
		</div>
	</nav>
	<br>

	<div class="row">
		<div class="col-sm-12">
			<h2><a name="cheat" id="cheat"></a>phpMyEdit Cheat Sheet</h2>
			<p>Typical phpMyEdit field array:</p>
<pre class="pre-scrollable">
$opts['fdd']['customer_number'] = array(
  'default'    =&gt; '',
  'help|ACP'   =&gt; 'Limit 10 digits',
  'input'      =&gt; '',
  'name'       =&gt; 'Customer Number',
  'options'    =&gt; 'ACPVDFL',
  'select'     =&gt; 'T',
  'size'       =&gt; 10,
  'sort'       =&gt; true
);
// If the tab feature is implemented, the first column must have a tab.
// Scripts are sometimes more readable if certain options are post-initialized:
// $opts['fdd']['customer_number']['tab|ACP'] = 'Customer Number';
</pre>
			<p>Each field array can include display mode properties: 'options' =&gt; [A|C|P|V|D|F|I|L]</p>
			<p>Add, Change, coPy, View, Delete, Filter, Initial sort suppressed, List.</p>
			<p>List is assumed and technically does not have to be specified.</p>
			<p>Input is normally empty, yet can be set to R or W or H (Read only, passWord, Hidden)</p>
<pre class="pre-scrollable">
'input' =&gt; ''
'input' =&gt; 'R'
</pre>
			<p>Anatomy of a field definition (fdd) for a TEXT/BLOB field:</p>
<pre class="pre-scrollable">
$opts['fdd']['your_column_name'] = array(
 'default' =&gt; '', // BLOB fields won't have a default entry; the defined default for other column types often appears here
 'help|ACP' =&gt; 'Hello World', // Message appearing in the Help cell if the page mode is Add, Change, or coPy
 'input' =&gt; '', // Sometimes set as [R]ead-only, [H]idden, or [P]assword. Use R for virtual (dummy) fields.
 'maxlen|ACP' =&gt; 65535, // Field length defined in MySQL, could be used for input validation purposes
 'name' =&gt; 'Content', // Column label
 'options' =&gt; 'ACPVDFL', // Suppress [F]ilter by removing F, suppress [L]ist by removing L, suppress initial sorting by adding I
 'select' =&gt; 'T', // Filter (Search) box in List mode (set D for drop down, N for numeric range qualifiers, M for multiple SELECT)
 'sqlw' =&gt; 'TRIM(&quot;$val_as&quot;)', // Apply MySQL's trim() function to SQL write
 'strip_tags|FL' =&gt; true, // Usually true unless displaying HTML markup in which case false is typically applied
 'textarea' =&gt; array('rows' =&gt; '5', 'cols' =&gt; '80'), // Dimensions for the HTML TEXTAREA box
 'trimlen|FL' =&gt; 100, // In [F]ilter and [L]ist modes display only the first 100 characters
 'sort' =&gt; false // If set true, the column title is a sort link. BLOB fields should be false.
); 
</pre>
			<p>Post-initialized Javascript validation of a field named `col_name`:</p>
<pre class="pre-scrollable">
$opts['fdd']['col_name']['js']['required'] = true; // Entry is required
$opts['fdd']['col_name']['js']['regexp'] = '/^[a-zA-Z]*$/'; // Optionally apply Javascript REGEX / regular expression
$opts['fdd']['col_name']['js']['hint'] = 'Entry of Content is required'; // Contents of the Javascript alert 
</pre>
			<p>Field options ['fdd'] can be restricted to specific page modes (ACPVDFLI), for example: 'help|ACP' or 'trimlen|FL'.</p>
			<p>Refrain from defining columns with a NULL value unless you have a specific reason for using NULL.</p>
			<p>The following elements are available for use in a field definition arrays.</p>
<pre class="pre-scrollable">
'colattrs' - user-defined table cell attributes: 'colattrs|FL' =&gt; 'style=&quot;color:#ff0000; background-color:transparent;&quot;',
</pre>
<pre class="pre-scrollable">
'css' - user-defined style class '-right-justify' is a form generator element, not a phpMyEdit element
</pre>
<pre class="pre-scrollable">
'datemask' - applicable to TIMESTAMP(14) and DATETIME fields
'datemask' =&gt; 'Y-m-d H:i:s'
'datemask' =&gt; 'r'
</pre>
<pre class="pre-scrollable">
'default' - default values are extracted from MySQL when the script is created.
// NULL values, if found, are handled using the 'sqlw' element.
</pre>
<pre class="pre-scrollable">
'escape' - if set to true, htmlspecialchars() will be applied to data (set false to display HTML markup)
</pre>
<pre class="pre-scrollable">
'help|ACP' - help / guidance displayed in ACP modes in a 3rd column (TD tag next to data)
</pre>
<pre class="pre-scrollable">
'input' - Normally empty, applications are R, W, and H (Read only, passWord, Hidden)
R - indicates that a field is read only (TIMESTAMP or auto_increment)
W - indicates that a field is a password field
H - indicates that a field is to be hidden and marked as hidden
</pre>
<pre class="pre-scrollable">
'mask' - a string (e.g. '%01.2f') used by sprintf() to format output (see also number_format)
</pre>
<pre class="pre-scrollable">
'maxlen' - maxlength attribute in the display of INPUT boxes relating to add/edit/search
</pre>
<pre class="pre-scrollable">
'name' - title for column headings ... PHP's ucwords(strtolower(col_name))
</pre>
<pre class="pre-scrollable">
'nowrap' - HTML NOWRAP attribute for TD tags
</pre>
<pre class="pre-scrollable">
'number_format' emulates PHP's number_format() function
</pre>
<pre class="pre-scrollable">
'options' - ACPVDFLI - optional parameter to control whether a field is displayed:
A - add
C - change
P - copy
D - delete
V - view
F - filter
L - list
I - initial sort suppressed
</pre>
<pre class="pre-scrollable">
'php' - If the 'php' option is set, a file of that name is included (and executed) in place of a value.
Behavior is the same as the triggers feature.
</pre>
<pre class="pre-scrollable">
'required' - true or false (true invokes javascript to prevent null entries)
Do not use quotation marks (&quot;) within the 'hint'.
</pre>
			<p>The above post-initialization example may be easier to work with than the following examples which might be applied directly to a field options array.</p>
<pre class="pre-scrollable">
'js' =&gt; array(
  'required' =&gt; true,
  'regexp' =&gt; '/^[0-9]*$/',
  'hint' =&gt; 'Please enter only numbers 0-9 in the col_name field.'
  )
</pre>
<pre class="pre-scrollable">
'select' - HTML INPUT/SELECT box type used for filtering records.
T - text
N - numeric (=, &lt;=, =&gt;)
D - drop-down
 - multiple selection
Defining fields as ENUM or SET in MySQL will result in HTML SELECT boxes in Filter mode.
</pre>
<pre class="pre-scrollable">
'size' - size attribute applied to HTML INPUT boxes
</pre>
<pre class="pre-scrollable">
'strftimemask'  optinally applied to INT fields containing a Unix timestamp
'strftimemask' =&gt; '%c',
'strftimemask' =&gt; '%a %m-%d-%Y %H:%M %p',
</pre>
<pre class="pre-scrollable">
'sort' - In List mode, if set to true, the column header is a clickable link that
enables column sorting. BLOB columns should usually be set to false.
</pre>
<pre class="pre-scrollable">
'sql' - see documentation, examples follow
'sql|FLV' =&gt; 'if($col_name &gt; &quot;&quot;, CONCAT(DATE_FORMAT($col_name, &quot;%a %b %e %Y %h:%i %p&quot;)), &quot;&quot;)',
'sql|FLV' =&gt; 'if(FirstName &lt;&gt; &quot;&quot;, CONCAT(LastName, &quot;, &quot;, FirstName), LastName)'
'sql|FLV' =&gt; 'if(start_date &gt; &quot;&quot;, CONCAT(start_date, &quot;%b %e %Y - %a&quot;), &quot;&quot;)'
'sql|LV'  =&gt; 'CONCAT(FROM_UNIXTIME(col_name, &quot;%a %b %e %Y %h:%i %p&quot;))',
'sql|LV'  =&gt; 'if(FirstName &lt;&gt; &quot;&quot;, CONCAT(LastName, &quot;, &quot;, FirstName), LastName)',
'sql|LV'  =&gt; 'if(start_date &gt; &quot;&quot;, CONCAT(start_date, &quot;%b %e %Y - %a&quot;), &quot;&quot;)',
'sql'     =&gt; 'CONCAT(FROM_UNIXTIME(col_name, &quot;%a %b %e %Y %h:%i %p&quot;))'
</pre>
<pre class="pre-scrollable">
'sqlw' =&gt; 'IF($val_qas = &quot;&quot;, NULL, $val_qas)'
'sqlw' =&gt; 'TRIM(UPPER($val_as))'
</pre>
<pre class="pre-scrollable">
'strip_tags' - apply PHP's strip_tags($col_name)
</pre>
<pre class="pre-scrollable">
'tab|ACP' - If tabs are enabled in the $opts['display'] array, apply clickable Javascript tabs
(sub-forms) appear in ACP modes. Apply to column 0 and one (or more) additional fields.
</pre>
<p>Tab example: <a href="app-tab-example.php" target="_blank">app-tab-example.php</a> requires the schema from <a href="sql/a_test_table.txt" target="_blank">a_test_table.txt</a></p>
<pre class="pre-scrollable">
'textarea' - rows/cols attribute for HTML TEXTAREA boxes
</pre>
<pre class="pre-scrollable">
'trimlen|FL' - number of characters to display in [F]ilter and [L]ist modes (often applied to BLOB/TEXT fields)
</pre>
<pre class="pre-scrollable">
'URL' - used to make a field 'clickable' in the display
for email addresses: 'mailto:$value'
where the value might be www.domain.com: 'http://$value'
where the value might be http://www.domain.com: '$value'
'URLtarget' - HTML A HREF target parameter, e.g.  'target=&quot;_blank&quot;'
</pre>
<pre class="pre-scrollable">
'values' - $opts['fdd']['col_name']['values'] = array('0', '1', '2', '3');
</pre>
<pre class="pre-scrollable">
'values2' - $opts['fdd']['col_name']['values2'] = array('0' =&gt; 'No', '1' =&gt; 'Yes'); 
</pre>
<p>Notification examples:</p>
<pre class="pre-scrollable">
$opts['notify']['from']   = 'user@domain.com';
$opts['notify']['prefix'] = $_SERVER['REQUEST_URI'].' - ';
$opts['notify']['wrap']   = '72';
$opts['notify']['all']    = 'user@domain.com'; // events: insert, update, delete
$opts['notify']['delete'] = 'user@domain.com'; // event: delete
$opts['notify']['insert'] = 'user@domain.com'; // event: insert
$opts['notify']['update'] = 'user@domain.com'; // event: update 
</pre>
			<p>Native MySQL functions are supported, including CONCAT &amp; REPLACE.</p>
<pre class="pre-scrollable">
$opts['fdd']['dummy2'] = array (
   'name' =&gt; 'Thumbnail',
   'sql|VLF' =&gt; 'if(category = &quot;other&quot;,
      CONCAT(&quot;&lt;a href=\&quot;&quot;, dir, &quot;/&quot;, filename, &quot;\&quot; target=\&quot;_blank\&quot;&gt;link&lt;/a&gt;&quot;),
         if(category = &quot;thumb&quot;, CONCAT(&quot;&lt;a rel=\&quot;example_group\&quot; href=\&quot;&quot;, REPLACE(dir, &quot;/tn&quot;, &quot;/&quot;), filename, &quot;\&quot; target=\&quot;_blank\&quot;&gt;&lt;img src=\&quot;&quot;, dir, &quot;/&quot;, filename, &quot;\&quot; &quot;, &quot; alt=\&quot;\&quot; border=\&quot;0\&quot;&gt;&lt;/a&gt;&lt;br&gt;&lt;a href=\&quot;fancybox.change.php?upld_id=&quot;, upld_id, &quot;\&quot;&gt;Replace&lt;/a&gt;&quot;), &quot;&quot;))',
   'options'  =&gt; 'VLF',
   'input'  =&gt; 'R',
   'escape' =&gt; false,
   'sort'     =&gt; false
); 
</pre>
			<p>Task specific phpMyEdit cheat sheets (code clips) are listed on the right side of the <a href="app-docs.php" title="phpMyEdit Documentation">Documentation Links</a> page.</p>
			<p>See also <a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/index.html">English Documentation</a></p>

			<hr>

			<h2>Naming conventions for MySQL&trade; columns, tables, and databases</h2>
			<p>While the hyphen (-) may be a valid character in the names of databases, tables, and columns, don't use a hyphen. Use of hyphens in the name of a database, table, or column may cause problems. If a hyphenated resource name appears in a double-quoted string of PHP code, the hyphen will be interpreted as a minus sign and crash the script.</p>
			<p>Varied system configurations may cause portability issues if upper case letters are used when naming MySQL&trade; resources.  Use lower case letters to ensure portability to other system configurations. Lower case letters a-z, numeric digits 0-9, and the underscore character are preferred by most users. If using upper case letters, your code might not be portable to a different server, most notably when migrating from Linux to Windows.</p>
			<p>Avoid using <a href="http://dev.mysql.com/doc/refman/5.5/en/reserved-words.html" target="_blank">Reserved Words</a> when naming columns, tables, and databases.</p>
			<p>Consider using the underscore character in your column names, e.g. first_name and not FirstName or firstname. Subsequently in PHP scripts the underscore can be easily replaced with a space when displaying the column name in reports. </p>
			<p>Prefix the names of your tables with your initials and the underscore character, or another arbitrary prefix. Later on, if you install a different web application in the same database, the possibility of table name conflict is significantly reduced. </p>
			<h2>NULL values</h2>
			<p>The only time I've found it practical to store a NULL value in a MySQL&trade; table occurs with DATE type columns, where the date entry is either unknown or optional. Otherwise, it makes no sense to me to store NULL when storing an empty string conserves bytes and avoids adding complexity to subsequent queries for that field. Always assign the field attribute NOT NULL unless you have a specific reason for inserting NULL values. </p>
			<h2>UTF8 Collation and Connection with MySQL&trade; Improved Connection Method</h2>
			<p>Specifying a database collation as UTF8_GENERIC_CI, using appropriate META tags, and issuing queries for SET NAMES UTF8 and SET COLLATION_CONNECTION=UTF8_GENERAL_CI after the database connection seems to work well for web pages which may contain accented characters. English language users will do well with UTF8_GENERAL_CI. Other languages might best be handled using UTF8_UNICODE_CI. See this <a href="http://stackoverflow.com/questions/367711/what-is-the-best-collation-to-use-for-mysql-with-php" target="_blank">collation discussion thread</a>.</p>
			<p><a href="http://blog.oneiroi.co.uk/mysql/mysql-forcing-utf-8-compliance-for-all-connections/">Forcing UTF-8 Connections in MySQL 5.x or higher</a> can potentially be accomplished using a statement in the my.cnf file calling init_connect.</p>
			<p>With UTF8, you also need to be sure to apply the appropriate HTML META tags to your document.</p>
<pre>&lt;meta http-equiv="charset" content="UTF-8"&gt;
&lt;meta http-equiv="content-type" content="text/html; charset=UTF-8"&gt;</pre>
			<div class="alert alert-info" role="alert">
			<h2>Observations</h2>
			<p>For those of you who intend to create a development environment on a Windows PC, <a title="WampServer" href="http://www.wampserver.com/en/" target="_blank">WampServer</a> will quickly install Apache, <a title="MySQL&trade; database" href="http://www.mysql.com" target="_blank">MySQL</a>&trade;, and <a title="PHP scripting language" href="http://www.php.net" target="_blank">PHP</a>.</p>
			<p>Popular utilities for working with <a title="MySQL&trade; database" href="http://www.mysql.com" target="_blank">MySQL</a>&trade; include <a title="MySQL&trade; Workbench" href="http://mysql.com/products/workbench/" target="_blank">MySQL&trade; Workbench</a>, <a title="phpMyAdmin" href="http://www.phpmyadmin.net" target="_blank">phpMyAdmin</a>, <a href="http://www.heidisql.com/" target="_blank" title="HeidiSQL">HeidiSQL</a>, and <a title="phpMyEdit" href="http://www.phpmyedit.org">phpMyEdit</a></p>
			<p><a href="http://www.adminer.org/" target="_blank">Adminer</a> is a great MySQL&trade; interface which offers much the same functionality as phpMyAdmin using only 1 script.</p>
			<p><a href="http://dbug.ospinto.com/" target="_blank" title="dBug.php">dBug.php</a> is a great debugging script for PHP.</p>
			</div>

		</div>
	</div>

	<div class="row">
		<div class="col-sm-4">
			<h3>Example scripts</h3>
			<p><a href="txt/example0.txt" target="_blank">example0.txt</a> without toggle links</p>
			<p><a href="txt/example1.txt" target="_blank">example1.txt</a> with toggle links</p>
			<p><a href="app-tab-example.php" target="_blank">app-tab-example.php</a> requires the schema from <a href="sql/a_test_table.txt" target="_blank">a_test_table.txt</a></p>
			<hr>
			<h3>Task specific cheat sheets (new window).</h3>
			<p>The following code clips for phpMyEdit are deemed reliable but are not guaranteed. Examples often require modification to meet your requirements.</p>
			<p><a target="_blank" href="./txt/array.values.txt">array.values.txt</a> (1-dimensional arrays)</p>
			<p><a target="_blank" href="./txt/array.values2.txt">array.values2.txt</a> (2-dimensional arrays)</p>
			<p><a target="_blank" href="./txt/change_log.txt">change_log.txt</a></p>
			<p><a target="_blank" href="./txt/date_validation.txt">date_validation.txt</a></p>
			<p><a target="_blank" href="./txt/deleted.txt">deleted.txt</a></p>
			<p><a target="_blank" href="./txt/dummy_fields.txt">dummy_fields.txt</a></p>
			<p><a target="_blank" href="./txt/encryption.txt">encryption.txt</a></p>
			<p><a target="_blank" href="./txt/filters.clickable.txt">filters.clickable.txt</a></p>
			<p><a target="_blank" href="./txt/filters.txt">filters.txt</a></p>
			<p><a target="_blank" href="./txt/filters_a-z.txt">filters_a-z.txt</a></p>
			<p><a target="_blank" href="./txt/formatting.txt">formatting.txt</a></p>
			<p><a target="_blank" href="./txt/icon.legend.txt">icon.legend.txt</a></p>
			<p><a target="_blank" href="./txt/join.txt">join.txt</a></p>
			<p><a target="_blank" href="./txt/js_regexp.txt">js_regexp.txt</a></p>
			<p><a target="_blank" href="./txt/languages.txt">languages.txt</a></p>
			<p><a target="_blank" href="./txt/lookups.txt">lookups.txt</a></p>
			<p><a target="_blank" href="./txt/navigation.txt">navigation.txt</a></p>
			<p><a target="_blank" href="./txt/num_recs.txt">num_recs.txt</a></p>
			<p><a target="_blank" href="./txt/page_mode.txt">page_mode.txt</a></p>
			<p><a target="_blank" href="./txt/persist.txt">persist.txt</a></p>
			<p><a target="_blank" href="./txt/scroller.txt">scroller.txt</a></p>
			<p><a target="_blank" href="./txt/sessions.txt">sessions.txt</a></p>
			<p><a target="_blank" href="./txt/strftime.txt">strftime.txt</a></p>
			<p><a target="_blank" href="./txt/tabs.txt">tabs.txt</a></p>
			<p><a target="_blank" href="./txt/timestamp.txt">timestamp.txt</a></p>
			<p><a target="_blank" href="./txt/triggers.txt">triggers.txt</a></p>
			<p><a target="_blank" href="./txt/tweak.txt">tweak.txt</a></p>
			<p><a target="_blank" href="./txt/uploaded_files.txt">uploaded_files.txt</a></p>
			<p><a target="_blank" href="./txt/uploaded_files2.txt">uploaded_files2.txt</a></p>
			<p><a target="_blank" href="./txt/uploaded_files3.txt">uploaded_files3.txt</a></p>
			<p><a target="_blank" href="./txt/url.txt">url.txt</a></p>
			<p><a target="_blank" href="./txt/validation0.txt">validation0.txt</a></p>
			<p><a target="_blank" href="./txt/validation1.txt">validation1.txt</a></p>
			<p><a target="_blank" href="./txt/validation2.txt">validation2.txt</a></p>
			<p><a target="_blank" href="./txt/validation3.txt">validation3.txt</a></p>
			<hr>

			<p><a href="http://phpmyedit.com/">phpMyEdit.com</a></p>
			<p><a href="http://phpmyedit.com/article.php?features">Features</a></p>
			<p><a href="http://phpmyedit.com/article.php?support">Support</a></p>
			<p><a href="http://phpmyedit.com/article.php?commercial">Commercial Licenses</a></p>
			<p><a href="http://phpmyedit.com/article.php?download">Download Free Version</a></p>
			<p><a href="http://phpmyedit.com/demo/">Demo Free Version</a></p>
			<p><a href="http://opensource.platon.sk/projects/main_page.php?project_id=5">opensource.platon.sk</a></p>
			<p><a href="http://opensource.platon.sk/projects/proj_doc_page.php?project_id=5">Documentation Overview</a></p>
			<p><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/index.html">English Documentation</a></p>
			<p><a href="http://opensource.platon.sk/forum/projects/?c=5">Forum</a></p>
			<p><a href="http://opensource.platon.sk/projects/release_list_page.php?project_id=5">Download Free Version</a></p>
			<p><a href="http://opensource.platon.sk/cvs/cvs.php/phpMyEdit/">CVS Repository</a></p>

		</div><!-- /col -->

		<div class="col-sm-8">
			<h3>Links to phpMyEdit documentation on <a href="http://opensource.platon.org/projects/main_page.php?project_id=5">opensource.platon.sk</a></h3>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.unique-key.html" target="_blank">Unique key</a>
opts key
opts key_type</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.common-options.html" target="_blank">Common options</a>
opts page_name
opts inc
opts multiple
opts display ( form, num_pages, num_records, query, sort, tabs, time )
opts url (images)
opts execute (1)</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.permission-options.html" target="_blank">Permission options</a>
opts options ACPVDFLI
Add, Change, coPy, View, Delete, Filter, Initial sort suppressed</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.sorting.html" target="_blank">Sorting</a>
opts sort_field one field name or an array of field names</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.navigation.html" target="_blank">Navigation and buttons</a>
opts navigation
opts buttons</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.filters.html" target="_blank">Filters</a>
opts filters</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.triggers.html" target="_blank">Triggers</a>
opts triggers</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.logging.html" target="_blank">Logging user actions</a>
opts logtable
opts notify</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.languages.html" target="_blank">Languages</a>
opts language possible footer links to alternate language selections</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.cgi-variables.html" target="_blank">CGI variables</a>
opts cgi append
opts cgi overwrite
opts cgi persist
opts cgi prefix</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.js-and-dhtml.html" target="_blank">Javascript and DHTML</a>
opts dhtml
opts js</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.css.html" target="_blank">CSS classes policy</a>
opts css - prefix page_type position divider separator</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.fields.html" target="_blank">Fields options</a>
fdd overview</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.basic-options.html" target="_blank">Basic field options</a>
fdd css
fdd help|ACP ucwords/upper/lower
fdd input
fdd name ucwords/upper/lower
fdd options ACPVDFLI, field type, auto_increment, timestamp, by name, etc
fdd select SET, ENUM, T, N</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.fields.booleans.html" target="_blank">Booleans</a>
fdd escape is generally only set true if the field contains HTML markup
fdd sort is generally set false if the column type is TEXT/BLOB
fdd strip_tags false by default
sometimes strip_tags|LF =&gt; true is preferable 
if the field contains HTML markup</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.javascript-validation.html" target="_blank">JavaScript validation</a>
fdd js required [be sure to define a hint]
fdd js regexp [0-9] is conditionally applied herein to column type INT
fdd js hint generally omit auto_increment, NULL; problematic if applied to all fields</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.input-restrictions.html" target="_blank">Input restrictions</a>
fdd values
fdd values lookup
fdd values2
joining</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.output-control.html" target="_blank">Output control</a>
fdd colattrs
fdd cols textarea
fdd datemask
fdd mask
fdd maxlen
fdd nowrap
fdd number_format
fdd rows textarea
fdd size|F
fdd strftimemask
fdd trimlen|ACP</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.url-linking.html" target="_blank">URL linking</a>
fdd URL
fdd URLdisp
fdd URLprefix (legacy)
fdd URLtarget</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.fields.sql.html" target="_blank">SQL expressions</a>
fdd sql
fdd sqlw
fdd sqlw MD5</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.fields.php.html" target="_blank">PHP expressions</a>
php</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.tabs-feature.html" target="_blank">TABs feature</a>
fdd tab</pre>
<pre><a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.options-variability.html" target="_blank">Options variability</a>
fdd trimlen
fdd trimlen|LF</pre>
		</div><!-- /col -->
	</div><!-- /row -->
</div> 

<!-- jQuery first, then Tether, then Bootstrap JS, then local JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.8/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous" type="text/javascript"></script>
<script src="js/local.js" type="text/javascript"></script>
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/rem/1.3.4/js/rem.min.js"></script>
<![endif]-->
</body>
</html>