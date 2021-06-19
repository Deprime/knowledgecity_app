<?php

namespace App\Core;

class Db {
  private static $db = null;

  protected $datetime_format  = "Y-m-d H:i:s";

  private $sth = null;
  private $dbh = null;

  protected $table  = null;
  protected $attributes = [];

  private $data     = null;
  private $params   = [];
  private $select   = null;
  private $join     = [];
  private $rowCount = null;
  private $offset   = null;


  /**
   * Private condtructor
   */
  private function __construct()
  {
  }


  /**
   * Get instance (singleton)
   */
  public static function getInstance()
  {
    if (self::$db == null)
      self::$db = new Db();
    return self::$db;
  }

  public function getDateFormat() {
    return $this->datetime_format;

  }


  /**
   * Set connection
   *
   * @param array $connection
   * @return self
   */
  public function connection(array $connection)
  {
    try {
      $this->dbh = new \PDO('mysql:host='.$connection['host'].';dbname='.$connection['database'], $connection['username'], $connection['password']);
    } catch (\PDOException $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
    }

    $this->dbh->query("SET NAMES 'utf8'");
    return $this;
  }


  /**
   * Set table
   *
   * @param string $value
   * @return self
   */
  public function table(string $value)
  {
    $this->table = $value;
    return $this;
  }

  /**
   * Set select string
   *
   * @param string $value
   * @return self
   */
  public function select(string $value = null)
  {
    $this->select = $value;
    return $this;
  }


  /**
   * Method description
   *
   * @return array
   */
  public function get()
  {
    if (!$this->fire($this->buildSelect())) {
      return false;
    }

    return $this->sth->fetchAll(\PDO::FETCH_ASSOC);
  }

  /**
   * Method description
   *
   * @return
   */
  protected function fire(string $statement)
  {
    $this->sth = $this->dbh->prepare($statement);

    if (!$this->sth)
      return false;

    if (!$this->sth->execute($this->params))
      return false;

    return true;
  }


  /**
   * Method description
   *
   * @param
   * @return string
   */
  protected function buildJoin()
  {
    $tmp = [];
    foreach ($this->join as $item) {
      $tmp[] = sprintf("%s JOIN %s ON %s", $item['type'], $item['table'], $item['conditions']);
    }
    return join("\n", $tmp);
  }


  /**
   * Method description
   *
   * @param
   * @return DB
   */
  public function join(string $table, string $conditions)
  {
    $this->join[] = [
      'type'       => 'INNER',
      'table'      => $table,
      'conditions' => $conditions,
    ];
    return $this;
  }


  /**
   * Method description
   *
   * @param
   * @return DB
   */
  public function leftJoin(string $table, string $conditions)
  {
    $this->join[] = [
      'type'       => 'LEFT',
      'table'      => $table,
      'conditions' => $conditions,
    ];
    return $this;
  }


  /**
   * Method description
   *
   * @param
   * @return DB
   */
  public function rightJoin(string $table, string $conditions)
  {
    $this->join[] = [
      'type'       => 'RIGHT',
      'table'      => $table,
      'conditions' => $conditions,
    ];
    return $this;
  }


  /**
   * Method description
   *
   * @param
   * @return
   */
  protected function buildSelect()
  {
    $statement = "SELECT " . ($this->select ? $this->select : '*');
    $statement .= "\nFROM " . $this->table;

    if ($this->join) {
      $statement .= "\n" . $this->buildJoin();
    }

    if ($this->where) {
      $statement .= "\nWHERE " . $this->buildWhere();
    }

    if (is_numeric($this->rowCount)) {
      if (is_numeric($this->offset)) {
        $statement .= sprintf("\nLIMIT %u, %u", $this->offset, $this->rowCount);
      }
      else {
        $statement .= sprintf("\nLIMIT %u", $this->rowCount);
      }
    }

    $statement .= ";";
    return $statement;
  }


  /**
   * Method description
   *
   * @param
   * @return
   */
  protected function buildWhere()
  {
    $tmp = [];
    $i = 0;
    foreach ($this->where as $item) {
      if ($item['column'] && $item['operator']) {
        $tmp[] = sprintf("%s %s %s", $item['column'], $item['operator'], ":where_$i");
        $this->param(":where_$i", $item['value']);
      }
      else
        $tmp[] = $item['value'];
      $i += 1;
    }
    return join(' AND ', $tmp);
  }


  /**
   * Method description
   *
   * @param
   * @return
   */
  public function where()
  {
    switch (func_num_args()) {
        case 1:
            $column = null;
            $operator = null;
            $value = func_get_arg(0);
            break;
        case 2:
            $column = func_get_arg(0);
            $operator = '=';
            $value = func_get_arg(1);
            break;
        case 3:
            $column = func_get_arg(0);
            $operator = func_get_arg(1);
            $value = func_get_arg(2);
            break;
        default:
            $column = null;
            $operator = null;
            $value = null;
    }

    $this->where[] = [
      'column'   => $column,
      'operator' => $operator,
      'value'    => $value,
    ];
    return $this;
  }


  /**
   * Method description
   *
   * @param
   * @return
   */
  public function param(string $key, $value)
  {
    $this->params[$key] = $value;
    return $this;
  }


  /**
   * Method description
   *
   * @param
   * @return
   */
  public function count()
  {
    $statement = "SELECT COUNT(*) AS cnt";
    $statement .= " FROM " . $this->table;

    if ($this->join)
      $statement .= "JOIN " . $this->join;

    if ($this->where)
      $statement .= " WHERE " . $this->buildWhere();

    $statement .= " LIMIT 1;";

    if (!$this->fire($statement))
      return false;

    return $this->sth->fetchColumn();
  }


  /**
   * Method description
   *
   * @param
   * @return
   */
  public function first()
  {
    if (!$this->fire($this->buildSelect()))
      return false;
    return $this->sth->fetch(\PDO::FETCH_ASSOC) ?: NULL;
  }


  /**
   * Method description
   *
   * @param
   * @return
   */
  public function limit(int $rowCount = null, int $offset = null)
  {
    $this->rowCount = $rowCount;
    $this->offset = $offset;
    return $this;
  }


  /**
   * Method description
   *
   * @param
   * @return
   */
  public function reset()
  {
    $this->data     = null;
    $this->join     = [];
    $this->offset   = null;
    $this->params   = [];
    $this->rowCount = null;
    $this->select   = null;
    $this->sth      = null;
    $this->where    = [];
    return $this;
  }

  /**
   * Just raw sql query
   */
  public function raw($query) {
    return (!$this->fire($this->fire($query))) ? false : true;
  }

}
