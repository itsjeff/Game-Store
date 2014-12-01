<?php namespace Jeffs;

class Database
{
	// Instance
	protected $mysqli;	
		
	// Query structure
	protected $table;
	protected $select = '*';
	protected $joins  = array();
	protected $where;
	protected $orderBy;
	protected $limit;

	// Query build
	protected $query;
	protected $bindParams = array();
	
	// Results
	public $num_rows  = 0;
	public $insert_id = 0;	
	
	// Database Details
	protected $hostname;
	protected $username;
	protected $password;
	protected $database;
	

	/**
	 * Construct
	 *
	 */
	function __construct()
	{
		$config_file = BASE_PATH . '/application/config/database.php';
	
		if (file_exists($config_file))
		{
			$db = include($config_file);
			
		
			// For the time being details will be added through config.
					
			$this->hostname = $db['mysqli']['hostname'];
			$this->username = $db['mysqli']['username'];
			$this->password = $db['mysqli']['password'];
			$this->database = $db['mysqli']['database'];
			
			$this->connect();
		}
		else
		{
			die('Could not find database config.php');
		}
	}
	

	/**
	 * Connect
	 *
	 */
	protected function connect()
	{
		$this->mysqli = new \mysqli($this->hostname, $this->username, $this->password, $this->database);
		
		if (mysqli_connect_errno())
		{
			die('Failed to connect to database: ' . mysqli_connect_error());
		}
		
		$this->mysqli->set_charset('utf8');
	}
	

	/**
	 * Table
	 *
	 */	
	public function table($table)
	{
		$this->table = $table;
		
		// todo: implement if table exists
		
		return $this;
	}
	
	
	/**
	 * Create / Insert
	 *
	 */	
	public function insert($insert_data = array())
	{
		$fields = array();
		$values = array();
		$ref    = array();
		
		if (count($insert_data) > 0)
		{
			// Sort data into Fields, Values and References
			foreach($insert_data as $key => $val)
			{
				$fields[] = $key;				
				$values[] = $val;				
				$ref[]    = '?';
			}
			

			// Run Statement
			$this->query = "INSERT INTO {$this->table} (".implode(', ', $fields).") VALUES (".implode(', ', $ref).")";
			
			$stmt = $this->buildQuery($values);

			$stmt->execute();	
			
			// Reset
			$this->reset();
		}
	}
	
	
	/**
	 * Retrieve / Get
	 *
	 */	
	public function get()
	{
		$join_count = count($this->joins);
		
		// Run Statement
		$this->query = "SELECT " . $this->select . " FROM " . $this->table;
		
		// Add joins if any
		if ($join_count > 0)
		{
			foreach($this->joins as $key => $val)
			{
				$this->query .= " " . $val;
			}
		}
		
		$stmt = $this->buildQuery();

		$stmt->execute();	
		
		// Reset
		$this->reset();
		
		// Return
		return $this->buildResults($stmt);
	}
	
	
	/**
	 * Retrieve / First
	 *
	 */	
	public function first()
	{
		// Get the first record
		$this->limit(array(1));
		
		// Run Statement
		$results = $this->get();
		
		return $results[0];
	}
	
	
	/**
	 * Update
	 *
	 */	
	public function update($update_data = array())
	{
		// Sort data into Fields, Values and References
		foreach($update_data as $key => $val)
		{
			$fields[] = $key.' = ?';
			
			$values[] = $val;
		}
		
		// Run Statement
		$this->query = "UPDATE " . $this->table . " SET " . implode(', ', $fields);
		
		$stmt = $this->buildQuery($values);
		
		$stmt->execute();
		
		// Reset
		$this->reset();
	}
	
	
	/**
	 * Delete
	 *
	 */	
	public function delete()
	{
		// Run Statement
		$this->query = "DELETE FROM " . $this->table;
		
		$stmt = $this->buildQuery();
		
		$stmt->execute();
				
		// Reset
		$this->reset();
	}
	
	
	/**
	 * Select
	 *
	 */		 
	public function select()
	{
		// Any amount of arguments can 
		// be called now with this function
		
		$args = func_get_args();
		
		if (count($args) > 0)
		{
			$this->select = trim(implode(', ', $args));
		}
		else
		{
			$this->select = '*';
		}
		
		return $this;
	}
	
	
	/**
	 * Join / left / right
	 *
	 */
	 
	public function leftJoin($table, $field_1, $operator, $field_2)
	{
		$this->buildJoin('LEFT JOIN', $table, $field_1, $operator, $field_2);
		
		return $this;
	}
	
	public function rightJoin($table, $field_1, $operator, $field_2)
	{
		$this->buildJoin('RIGHT JOIN', $table, $field_1, $operator, $field_2);
		
		return $this;
	}
	
	public function join($table, $field_1, $operator, $field_2)
	{
		$this->buildJoin('INNER JOIN', $table, $field_1, $operator, $field_2);
		
		return $this;
	}
	

	/**
	 * Where / orWhere
	 *
	 */	
	public function where($clause, $operator, $param)
	{
		$string = ($operator == 'LIKE') ? "%{$param}%" : $param;
		
		if ($this->where)
		{
			$this->where .= ' AND '.$clause.' '.$operator.' ?';
		}
		else
		{
			$this->where = ' WHERE '.$clause.' '.$operator.'  ?';
		}
		
		$this->bindParams[] = $string;
		
		return $this;
	}
	
	public function orWhere($clause, $operator, $param)
	{
		if ($this->where)
		{
			$this->where .= ' OR '.$clause.' '.$operator.' ?';
		}
		else
		{
			$this->where = ' WHERE '.$clause.' '.$operator.' ?';
		}
		
		$this->bindParams[] = $param;
		
		return $this;
	}
	
	
	/**
	 * Limit
	 *
	 */	
	public function limit($params = array())
	{		
		if (count($params) < 2)
		{
			$this->limit = ' LIMIT '. $params[0];
		}
		else
		{
			$this->limit = ' LIMIT ' . $params[0] . ', ' . $params[1];		
		}
		
		return $this;
	}
	 
	 
	/**
	 * OrderBy
	 *
	 */	
	public function orderBy($key, $order)
	{
		if ($key AND $order)
		{
			$this->orderBy = ' ORDER BY '.$key.' '.$order;
		}
		
		return $this;
	}
	
	
	/**
	 * Reset
	 *
	 */		
	protected function reset()
	{
		$this->table   = '';
		$this->select  = '*';
		$this->joins  = array();
		$this->where   = '';
		$this->orderBy = '';
		$this->limit   = '';		
		$this->query   = '';
		$this->bindParams = array();
	}
	
	
	/**
	 * Determine the value type for prepered query
	 *
	 */	
	protected function determineType($value)
	{
		switch(gettype($value))
		{
			case 'NULL':
			case 'string':
				return 's';				
			break;
				
			case 'boolean':
			case 'integer':
				return 'i';
			break;
				
			case 'blob':
				return 'b';
			break;
				
			case 'double':
				return 'd';
			break;			
		}
		
		return '';
	}
	
	
	/**
	 * Build Join
	 *
	 */		
	protected function buildJoin($type, $table, $field_1, $operator, $field_2)
	{
		$type     = trim($type);
		$table    = trim($table);
		$field_1  = trim($field_1);
		$field_2  = trim($field_2);		
		$operator = trim($operator);
		
		$this->joins[] = $type . ' ' . $table . ' ON ' . $field_1 . ' ' .$operator . ' ' . $field_2;
	}
	
	/**
	 * Build Query
	 *
	 */		
	protected function buildQuery($values = array())
	{
		// Prepare query statement
		$stmt = $this->mysqli->prepare($this->query = $this->query . $this->where . $this->orderBy . $this->limit);
		
		
		// Merge where and values to be prepared for referencing
		$this->bindParams = array_merge($values, $this->bindParams);
		
		
		// If there are any params to bind, then
		// Reference values for us
		if (count($this->bindParams) > 0)
		{
			$reflectionClass = new \ReflectionClass('mysqli_stmt');
		
			$method = $reflectionClass->getMethod('bind_param');
		
			$method->invokeArgs($stmt, $this->referenceValues($this->bindParams));	
		}
		
		
		// return statement to be executed
		return $stmt;
	}
	
	
	/**
	 * Build Where
	 *
	 */		
	protected function buildWhere()
	{
		//
	}
	
	
	/**
	 * Build Results
	 *
	 */		
	protected function buildResults($stmt)
	{
		$parameters = array();
		$results    = array();
		
		$meta = $stmt->result_metadata();
		
		$row = array();
		
        while ($field = $meta->fetch_field()) 
		{
            $row[$field->name] = null;
			
            $parameters[] = & $row[$field->name];
        }
		
		call_user_func_array(array($stmt, 'bind_result'), $parameters);
		
		while ($stmt->fetch()) 
		{
            $x = array();
			
            foreach ($row as $key => $val) 
			{
                $x[$key] = $val;
            }
			
			// count rows
			++$this->num_rows;
			
            array_push($results, (object) $x);
        }

        return $results;
		
		/*while($row = $stmt->fetch())
		{
			$record = array();
			
			foreach($row as $key => $val)
			{
				$record[$key] = $val;
			}
			
			// push each record into $results as an Object
			array_push($results, (object) $record);
			
			// Get number of records
			++$this->num_rows;
		}
		
		return $results; */
	}
	

	/**
	 * Reference Values
	 *
	 */	
	protected function referenceValues($values)
	{
		$prepTypes = '';
		
		$refs  = array();
		
		foreach ($values as $key => $val)
		{
			$prepTypes .= $this->determineType($val);
			
			$refs[$key] = &$values[$key];
		}
		
		$types = array($prepTypes);
		
		return array_merge($types, $refs);
	}
	 
	 
	/**
	 * Close
	 *
	 */	
	function __destruct()
	{
		if ($this->mysqli)
		{
			$this->mysqli->close();
		}
	}
}
?>
