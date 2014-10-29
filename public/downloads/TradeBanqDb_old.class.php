<?php
/**
 * Class for executing and logging queries on Tradebanq.com database
 * @author Haisum <haisumbhatti@gmail.com>
 */
class TradeBanqDb {
	/**
	 * stores link returned from mysql_connect from master
	 * on execution of first DML query
	 * @var mysql
	 */
	public $master_connection;
	/**
	 * stores link returned from mysql_connect from slave
	 * on execution of first SELECT query
	 * @var mysql
	 */
	public $slave_connection;
	private $last_connection_used;
	/**
	 * stores list of queries executed via this object
	 * @var array
	 */
	private $queries = array();
	/**
	 * @var float used for storing start time before query starts executing
	 */
	private $start_time;
	/**
	 * If set to auto, master or slave connection per query will be decided by isDML function
	 * If set to either of slave or master it will force using those connections
	 * Possible values: slave|master|auto
	 * @var string
	 */
	public $connection_type = "auto";
	/**
	 * @var boolean Toggles logging and tracking of queries
	 */
	public $enable_log = false;
	/**
	 * @var boolean Toggles write logging of queries in hard drive
	 */
	public $write_log = false;
	/**
	 * see function __construct for details
	 * @var array
	 */
	public $credentials;
	/**
	 * gets credentials and stores them in $this->credentials
	 * @param string $master_host
	 * @param string $master_username
	 * @param string $master_password
	 * @param string $master_db
	 * @param string $slave_host
	 * @param string $slave_username
	 * @param string $slave_password
	 * @param string $slave_db
	 */
	public function __construct($master_host, $master_username, $master_password, $master_db, $slave_host, $slave_username, $slave_password, $slave_db) {
		$this->credentials = array(
			'master' => array(
				'host'     => $master_host,
				'username' => $master_username,
				'password' => $master_password,
				'dbname'   => $master_db,
			),
			'slave' => array(
				'host'     => $slave_host,
				'username' => $slave_username,
				'password' => $slave_password,
				'dbname'   => $slave_db,
			),
		);
		$this->last_connection_used = null;
		$this->page_start_time = microtime(true);
		if(!isset($_SERVER['REQUEST_URI'])){
			$_SERVER['REQUEST_URI'] = $argv[1];
		}
	}
	/**
	 * When script has finished working, write query log
	 * to a file with name current SCRIPT_NAME if write_log boolean
	 * is set to true and close the connections
	 */
	public function __destruct() {

		if ($this->write_log) {
			$filename = str_replace("/", "--", ltrim($_SERVER["SCRIPT_FILENAME"], "/")) . ".log";
			$fp       = fopen("classes/queries/" . $filename, "a");

			foreach ($this->queries as $key => $value) {
				$query = str_replace("\n", " ", $value['query']);
				$query = str_replace("\t", " ", $query);
				$row   = "{$value['start']}\t{$query}\t{$value['records']}\t{$value['time']}\t{$value['error']}\t{$value['connection']}\t{$_SERVER['REMOTE_ADDR']}\t{$_SERVER['HTTP_HOST']}\t{$_SERVER['REQUEST_URI']}" . PHP_EOL;
				fwrite($fp, $row);
			}
			@fclose($fp);
		}

		@mysql_close($this->master_connection);
		@mysql_close($this->slave_connection);
		@mysql_close($this->last_connection_used);
		if (DEBUG && !is_ajax() && UserAuth::is_local()) {
			$this->print_log();
		}
	}
	/**
	 * checks type of query (DML or not) and returns master connection if DML
	 * or slave connection if select query. If connection is not already made,
	 * it makes one.
	 * @param  string $query
	 * @return mysql
	 */
	public function get_connection($query) {
		if ($this->connection_type === "master" || $this->isDML($query)) {//we need master
			if ($this->master_connection === null) {
				$creds                   = $this->credentials['master'];
				$this->master_connection = mysql_connect($creds['host'], $creds['username'], $creds['password']);
				mysql_select_db($creds['dbname'], $this->master_connection);
				mysql_query("SET NAMES 'utf8'", $this->master_connection);
			}
			unset($this->last_connection_used);
			$this->last_connection_used = $this->master_connection;
			return $this->master_connection;
		} else {//slave
			if ($this->slave_connection === null) {
				$creds                  = $this->credentials['slave'];
				$this->slave_connection = mysql_connect($creds['host'], $creds['username'], $creds['password']);
				mysql_select_db($creds['dbname'], $this->slave_connection);
				mysql_query("SET NAMES 'utf8'", $this->slave_connection);
			}
			unset($this->last_connection_used);
			$this->last_connection_used = $this->slave_connection;
			return $this->slave_connection;
		}
	}
	/**
	 * Force making a new connection
	 * NOTE: this function doesn't need to be called in normal
	 * circumstances, one of uses is when mysql server has gone away. Calling
	 * this function resets the connection
	 * When an existing connetion to either slave or master needs swapping
	 * this function shall be called after changing connection_type variable.
	 */
	public function new_connection() {

		if ($this->master_connection !== null || $this->slave_connection !== null) {
			tb_db_close();
		}
		//we have a master over here
		if ($this->connection_type == 'master' || $this->last_connection_used == null || ($this->master_connection != null && mysql_thread_id($this->last_connection_used) == mysql_thread_id($this->master_connection))) {
			$creds                   = $this->credentials['master'];
			$this->master_connection = mysql_connect($creds['host'], $creds['username'], $creds['password']);
			mysql_select_db($creds['dbname'], $this->master_connection);
			mysql_query("SET NAMES 'utf8'", $this->master_connection);
			unset($this->last_connection_used);
			$this->last_connection_used = $this->master_connection;
		} else {
			$creds                  = $this->credentials['slave'];
			$this->slave_connection = mysql_connect($creds['host'], $creds['username'], $creds['password']);
			mysql_select_db($creds['dbname'], $this->slave_connection);
			mysql_query("SET NAMES 'utf8'", $this->slave_connection);
			unset($this->last_connection_used);
			$this->last_connection_used = $this->slave_connection;
		}
	}

	/**
	 * executess query using mysql_query and logs the time and script name
	 * @param  string $query
	 * @return mysql_result
	 */
	public function query($query) {

		$query = rtrim(trim($query), ";");

		$query .= "; -- {$_SERVER['REQUEST_URI']} {$_SERVER['REMOTE_ADDR']}";
		$connection = $this->get_connection($query);
		$this->start_query();
		$result  = mysql_query($query, $connection);

		if($result){
			if($this->isDML($query)){
				$records = mysql_affected_rows();
			}
			else{	
				$records = mysql_num_rows($result);
			}
		}
		
		$this->end_query($query, $records);
		return $result;
	}
	/**
	 * checks if query is update/insert or delete
	 * @param  string  $query
	 * @return boolean
	 */
	private function isDML($query) {
		//if first charachter of query is s, it's select
		if (stripos(trim($query), 's') === 0) {
			return false;
		} else {
			return true;
		}
	}
	/**
	 * aliases of mysql_fetch_*
	 * @param  mysql_result $query_result (should be returned from TradeBanqDb::query)
	 * @return array
	 */
	public function fetch_array($query_result) {
		return mysql_fetch_array($query_result);
	}
	public function fetch_object($query_result) {
		return mysql_fetch_object($query_result);
	}
	public function fetch_row($query_result) {
		return mysql_fetch_row($query_result);
	}
	public function fetch_assoc($query_result) {
		return mysql_fetch_assoc($query_result);
	}
	/**
	 * alias of mysql_num_rows
	 * @param  mysql_result $query_result (should be returned from TradeBanqDb::query)
	 * @return int
	 */
	public function num_rows($query_result) {
		return ($query_result ? mysql_num_rows($query_result) : false);
	}

	/**
	 * stores start time of query in TradeBanqDb::start_time
	 * @return void
	 */
	private function start_query() {
		$this->start_time = microtime(true);
	}

	/**
	 * alias of mysql_insert_id
	 * @return int
	 */
	public function insert_id() {
		return mysql_insert_id($this->last_connection_used);
	}

	/**
	 * stores query, filenames, errors in TradeBanqDb::queries and TradeBanqDb::errors
	 * @param  string $query
	 * @return void
	 */
	private function end_query($query, $records = 0) {

		if ($this->enable_log) {
			$error           = mysql_error();
			$this->queries[] = array(
				'start'      => date("Y-m-d H:i:s"),
				'query'      => $query,
				'records'    => $records,
				'time'       => microtime(true) - $this->start_time,
				'error'      => $error,
				'connection' => ((($this->last_connection_used && $this->master_connection) && (mysql_thread_id($this->last_connection_used) == mysql_thread_id($this->master_connection))) ? "master" : "slave"),
			);
		}
		$this->start_time = 0;
	}
	/**
	 * alias of mysql_error
	 * @return string
	 */
	public function error() {
		return mysql_error($this->last_connection_used);
	}
	/**
	 * list of mysql queries, their execution time on this page. Logged via end_query function
	 * @return array
	 */
	public function get_queries() {
		return $this->queries;
	}
	/**
	 * close master connection
	 * @return void
	 */
	public function close_master() {
		@mysql_close($this->master_connection);
		$this->master_connection = null;
	}
	/**
	 * close slave connection
	 * @return void
	 */
	public function close_slave() {
		@mysql_close($this->slave_connection);
		$this->slave_connection = null;
	}
	/**
	 * alias of mysql_data_seek
	 * moves internal pointer of a result to specified row number
	 * @param  mysql_result  $result
	 * @param  integer $row
	 */
	public function data_seek($result, $row = 0) {
		return mysql_data_seek($result, $row);
	}
	/**
	 * echoes css and html for sql log
	 * @return void
	 */
	public function print_log() {
		if (!$this->enable_log || (DEV && !DEBUG) || !(UserAuth::is_local() || (php_sapi_name() == 'cli' && empty($_SERVER['REMOTE_ADDR'])))) {
			return;
		}

		echo '<style>.query_log {margin:0px;padding:0px; width:100%; box-shadow: 10px 10px 5px #888888; border:1px solid #000000; -moz-border-radius-bottomleft:0px; -webkit-border-bottom-left-radius:0px; border-bottom-left-radius:0px; -moz-border-radius-bottomright:0px; -webkit-border-bottom-right-radius:0px; border-bottom-right-radius:0px; -moz-border-radius-topright:0px; -webkit-border-top-right-radius:0px; border-top-right-radius:0px; -moz-border-radius-topleft:0px; -webkit-border-top-left-radius:0px; border-top-left-radius:0px; }.query_log table{border-collapse: collapse; border-spacing: 0; width:100%; height:100%; margin:0px;padding:0px; }.query_log tr:last-child td:last-child {-moz-border-radius-bottomright:0px; -webkit-border-bottom-right-radius:0px; border-bottom-right-radius:0px; } .query_log table tr:first-child td:first-child {-moz-border-radius-topleft:0px; -webkit-border-top-left-radius:0px; border-top-left-radius:0px; } .query_log table tr:first-child td:last-child {-moz-border-radius-topright:0px; -webkit-border-top-right-radius:0px; border-top-right-radius:0px; }.query_log tr:last-child td:first-child{-moz-border-radius-bottomleft:0px; -webkit-border-bottom-left-radius:0px; border-bottom-left-radius:0px; }.query_log tr:hover td{} .query_log tr.master{ background-color:#ffaa56; } .query_log tr.slave   { background-color:#ffffff; }.query_log td{vertical-align:middle; border:1px solid #000000; border-width:0px 1px 1px 0px; text-align:left; padding:7px; font-size:10px; font-family:Arial; font-weight:normal; color:#000000; }.query_log tr:last-child td{border-width:0px 1px 0px 0px; }.query_log tr td:last-child{border-width:0px 0px 1px 0px; }.query_log tr:last-child td:last-child{border-width:0px 0px 0px 0px; } .query_log tr:first-child td{background:-o-linear-gradient(bottom, #ff7f00 5%, #bf5f00 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ff7f00), color-stop(1, #bf5f00) ); background:-moz-linear-gradient( center top, #ff7f00 5%, #bf5f00 100% ); filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#ff7f00", endColorstr="#bf5f00");	background: -o-linear-gradient(top,#ff7f00,bf5f00); background-color:#ff7f00; border:0px solid #000000; text-align:center; border-width:0px 0px 1px 1px; font-size:14px; font-family:Arial; font-weight:bold; color:#ffffff; } .query_log tr:first-child:hover td{background:-o-linear-gradient(bottom, #ff7f00 5%, #bf5f00 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ff7f00), color-stop(1, #bf5f00) ); background:-moz-linear-gradient( center top, #ff7f00 5%, #bf5f00 100% ); filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#ff7f00", endColorstr="#bf5f00");	background: -o-linear-gradient(top,#ff7f00,bf5f00); background-color:#ff7f00; } .query_log tr:first-child td:first-child{border-width:0px 0px 1px 0px; } .query_log tr:first-child td:last-child{border-width:0px 0px 1px 1px; }.query_log table tr.error td{background-color:red;color:#fff;font-weight:bold;}</style>';
		echo "<div class='query_log'>
			<table style='table-layout:fixed;'>
				<tr>
					<td>Start</td><td>Query</td><td>Records</td><td>Time Taken</td><td>Connection</td><td>Error</td>
				</tr>";

		echo "<tr><td colspan='4'>Total Queries Executed: " . count($this->queries) . "</td></tr>";
		foreach ((array) $this->queries as $key => $query) {
			$class = "";
			if ($query["error"] || $query["time"] > 1) {
				$class = "error";
			}
			echo "<tr class='$class {$query['connection']}'>
				<td>{$query['start']}</td><td>{$query['query']}</td><td>{$query['records']}</td><td>{$query['time']}</td><td>{$query['connection']}</td><td>{$query['error']}</td>
			</tr>";
		}
		echo "</table>
			</div>";
	}
	/**
	 * escape a parameter so it could be safely passed to mysql
	 * @param  string $unescaped_string
	 */
	public function escape($unescaped_string) {
		if (!$this->master_connection && !$this->slave_connection) {
			$this->new_connection();
		}
		return mysql_real_escape_string($unescaped_string, $this->last_connection_used);
	}
	/**
	 * alias of escape
	 */
	public function real_escape_string($unescaped_string) {
		return $this->escape($unescaped_string);
	}
	/**
	 * unset the result set returned by select and free up the memory
	 * @param  mysql_result resource $result
	 */
	public function free_result($result) {
		return mysql_free_result($result);
	}
	/**
	 * Get number of affected rows in previous MySQL operation
	 * @return int Returns the number of affected rows on success, and -1 if the last query failed.
	 */
	public function affected_rows() {
		return mysql_affected_rows($this->last_connection_used);
	}
	/**
	 * Get the name of the specified field in a result
	 * @param  resource $result       The result resource that is being evaluated. This result comes from a call to mysql_query()
	 * @param  int $field_offset      The numerical field offset. The field_offset starts at 0. If field_offset does not exist, an error of level E_WARNING is also issued.
	 * @return string|boolean         The name of the specified field index on success or FALSE on failure.
	 */
	public function field_name($result, $field_offset) {
		return mysql_field_name($result, $field_offset);
	}
	/**
	 * Get number of fields in result
	 * @param  resource $result The result resource that is being evaluated. This result comes from a call to mysql_query()
	 * @return int|boolean      Returns the number of fields in the result set resource on success or FALSE on failure.
	 */
	public function num_fields($result) {
		return mysql_num_fields($result);
	}
	/**
	 * Checks whether or not the connection to the server is working. If it has gone down, an automatic reconnection is attempted. This function can be used by scripts that remain idle for a long while, to check whether or not the server has closed the connection and reconnect if necessary.
	 * @param  resource     $link The MySQL connection. If the link identifier is not specified, the last link opened by mysql_connect() is assumed. If no such link is found, it will try to create one as if mysql_connect() was called with no arguments. If no connection is found or established, an E_WARNING level error is generated.
	 * @return Boolean      Returns TRUE if the connection to the server MySQL server is working, otherwise FALSE.
	 */
	public function ping($link = NULL) {
		if ($link == NULL) {
			$link = $this->last_connection_used;
		}
		return mysql_ping($link);
	}
	/**
	 * Takes table name and associate array of column names and values and inserts in database
	 * @param  string $table table name to insert data in
	 * @param  array $data  might be one record like:
	 *                      ['es_username' => 'asdfsdafasdf',
	 *                       'es_password' => 'asdfsdfsdf'
	 *                      ]
	 *                      or multiple records like:
	 *                      [
	 *                      	[
	 *                      		'es_username' => 'safsdfsdf',
	 *                      		'es_password' => 'asdf34345'
	 *                      	],
	 *                      	[
	 *                      		'es_username' => 'asdfsdafasdf',
	 *                      		'es_password' => 'asdfsdfsdf'
	 *                      	]
	 *
	 *                      ]
	 * @return boolean  false on failure and true on success
	 */
	public function insert($table, $data) {
		$values = [];
		$table  = trim($table);
		if (empty($data) || !$table) {
			return false;
		}
		/**
		 * if $data is array of arrays, we want to bulk insert values
		 */
		if (isset($data[0]) && is_array($data[0])) {
			$values = $data;
		}
		/**
		 * Otherwise there's only one pair of values to insert
		 */
		else{
			$values[] = $data;
		}
		$columns         = array_keys($values[0]);
		$prepared_values = [];
		foreach ($values as $value) {
			$temp = [];
			foreach ($columns as $column) {
				$input  = '"' . $this->escape($value[$column]) . '"';
				$temp[] = $input;
			}
			$prepared_values[] = implode(",", $temp);
		}
		$query = "INSERT INTO $table
				(" . implode(",", $columns) . ")
				VALUES (" .
		implode("),(", $prepared_values) .
		")";
		return $this->query($query);
	}
	/**
	 * Given an array of arrays it converts second dimension arrays to string that can be used in insert statements values clause
	 * @param  array $data array of arrays for insert values
	 * @return array   single dimension array of strings for use in values clause
	 */
	public function data_to_values($data){
		$insert_values = [];
		foreach ($data as $values) {
			$temp = [];
			foreach ($values as $value) {
				$temp[] = '"' . $this->escape($value) . '"';
			}
			$insert_values[] = "(" . implode(",", $temp) . ")";
		}
		return implode("," , $insert_values);
	}

	public function update($table, $data, $pk){
		$update_values = [];
		foreach ($data as $key => $value) {
			$update_values[] = " `$key` =  '" . $this->escape($value) . "'";
		}
		$update_values = implode(",", $update_values);$where = "";
		if(intval($pk)){
			$where = "es_id = $pk";
		}
		else{
			$where = $pk;
		}
		$query = "UPDATE `$table` SET $update_values WHERE $where";
		return $this->query($query);
	}
	/**
	 * takes table name and primary key as argument and deletes one record
	 * @param  string $table table name
	 * @param  int $pk    primary key
	 * @return bool       true on success false on failure
	 */
	public function delete($table, $pk){
		$where = "";
		if(intval($pk)){
			$where = "es_id = $pk";
		}
		else{
			$where = $pk;
		}
		$query = "DELETE FROM $table where $where";
		return $this->query($query);
	}

	public function find_one($select, $table, $where){
		$query = "SELECT $select FROM $table WHERE $where LIMIT 1";
		$result = $this->query($query);
		if($result){
			return $this->fetch_assoc($result);
		}
		else{
			return false;
		}
	}

	public function count($table, $where = '1 = 1'){
		$result = $this->find_one("count(*) as total", $table, $where);
		return ($result ? $result['total'] : false);
	}
}
/**
 * Aliases are for replacing old mysql_ calls in code. Aliases were necessary
 * because some mysql_ calls in code are inside functions which will require
 * doing a global $tb_db in each function that calls a method. We create these
 * functions for doing global declaration.
 * In future it's recommended that you declare global $tb_db at top of function
 * and call methods directly rather than using the procedural alias function calls.
 */
/**
 * Alias for $tb_db->query()
 */
function tb_db_query($query) {
	global $tb_db;
	return $tb_db->query($query);
}
/**
 * Alias for $tb_db->print_log()
 */
function tb_db_print_log() {
	global $tb_db;
	$tb_db->print_log();
}
/**
 * Alias for $tb_db->last_insert_id()
 */
function tb_db_insert_id() {
	global $tb_db;
	return $tb_db->insert_id();
}

/**
 * Alias for $tb_db->num_rows()
 */
function tb_db_num_rows($result) {
	global $tb_db;
	return $tb_db->num_rows($result);
}
/**
 * Alias for $tb_db->fetch_array()
 */
function tb_db_fetch_array($result) {
	global $tb_db;
	return $tb_db->fetch_array($result);
}
/**
 * Alias for $tb_db->fetch_assoc()
 */
function tb_db_fetch_assoc($result) {
	global $tb_db;
	return $tb_db->fetch_assoc($result);
}
function tb_db_fetch_row($result) {
	global $tb_db;
	return $tb_db->fetch_row($result);
}
function tb_db_fetch_object($result) {
	global $tb_db;
	return $tb_db->fetch_object($result);
}
/**
 * Alias for $tb_db->error()
 */
function tb_db_error() {
	global $tb_db;
	return $tb_db->error();
}
/**
 * Alias for $tb_db->close_*()
 */
function tb_db_close($param = null) {
	global $tb_db, $link;
	$tb_db->close_master();
	$tb_db->close_slave();
	//if any, close it
	if ($link) {
		@mysql_close($link);
	}
}
/**
 * By now it should be obvious that all functions below are aliases
 * to their counterparts in class.. Do I still need to document these?
 */
function tb_db_data_seek($result, $row = 0) {
	global $tb_db;
	return $tb_db->data_seek($result, $row);
}
function tb_db_escape($unescaped_string) {
	global $tb_db;
	return $tb_db->escape($unescaped_string);
}
function tb_db_real_escape_string($unescaped_string) {
	return tb_db_escape($unescaped_string);
}
function tb_db_free_result($result) {
	global $tb_db;
	return $tb_db->free_result($result);
}
function tb_db_affected_rows() {
	global $tb_db;
	return $tb_db->affected_rows();
}
function tb_db_field_name($result, $field_offset) {
	global $tb_db;
	return $tb_db->field_name($result, $field_offset);
}
function tb_db_num_fields($result) {
	global $tb_db;
	return $tb_db->num_fields($result);
}
function tb_db_ping($link = NULL) {
	global $tb_db;
	return $tb_db->ping($link);
}
