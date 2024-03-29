<?php

namespace App\Db;

use \PDO;
use \PDOException;
use PDOStatement;

class Database{

    /**
     * Host de conexão com o banco de dados
     * @var string
     */
    private static string $host;

    /**
     * Nome do banco de dados
     * @var string
     */
    private static string $name;

    /**
     * Usuário do banco
     * @var string
     */
    private static string $user;

    /**
     * Senha de acesso ao banco de dados
     * @var string
     */
    private static string $pass;

    /**
     * Porta de acesso ao banco
     * @var integer
     */
    private static int $port;

    /**
     * Nome do banco a ser manipulada
     * @var string
     */
    private string $db;

    /**
     * Nome da tabela a ser manipulada
     * @var string
     */
    private string $table;

    /**
     * Instancia de conexão com o banco de dados
     * @var PDO
     */
    private PDO $connection;

    /**
     * Método responsável por configurar a classe
     * @param string $host
     * @param string $name
     * @param string $user
     * @param string $pass
     * @param integer $port
     */
    public static function config(string $host, string $name, string $user, string $pass, int $port = 3306){
        self::$host = $host;
        self::$name = $name;
        self::$user = $user;
        self::$pass = $pass;
        self::$port = $port;
    }

  /**
   * Define a tabela e instancia e conexão
   * @param string|null $db
   * @param string|null $table
   */
  public function __construct(string $db = null, string $table = null){
      //RECEBE NOME DO BANCO E TABELA
      $this->db = $db;
      $this->table = $table;
      $this->setConnection();
  }

  /**
   * Método responsável por criar uma conexão com o banco de dados
   */
  private function setConnection(){
    try{
      $this->connection = new PDO('mysql:host='.self::$host.';dbname='.self::$name.';port='.self::$port,self::$user,self::$pass);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
      die('ERROR: '.$e->getMessage());
    }
  }

  /**
   * Método responsável por executar queries dentro do banco de dados
   * @param string $query
   * @param array $params
   * @return PDOStatement
   */
  public function execute(string $query, array $params = []): PDOStatement
  {
    try{
      $statement = $this->connection->prepare($query);
      $statement->execute($params);
      return $statement;
    }catch(PDOException $e){
      die('ERROR: '.$e->getMessage());
    }
  }

  /**
   * Método responsável por inserir dados no banco
   * @param array $values [ field => value ]
   * @return integer ID inserido
   */
  public function insert(array $values): int
  {
    //DADOS DA QUERY
    $fields = array_keys($values);
    $binds  = array_pad([],count($fields),'?');

    //MONTA A QUERY
    $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';

    //EXECUTA O INSERT
    $this->execute($query,array_values($values));

    //RETORNA O ID INSERIDO
    return $this->connection->lastInsertId();
  }

  /**
   * Método responsável por executar uma consulta no banco
   * @param string|null $where
   * @param string|null $order
   * @param string|null $group
   * @param string|null $limit
   * @param string|null $fields
   * @param string|null $join
   * @return PDOStatement
   */
  public function select(string $fields = null, string $join = null, string $where = null, string $order = null, string $group = null, string $limit = null): PDOStatement
  {

      //DADOS DA QUERY
      $join  = strlen($join) ? 'INNER JOIN '.$join : '';
      $where = strlen($where) ? 'WHERE '.$where : '';
      $order = strlen($order) ? 'ORDER BY '.$order : '';
      $group = strlen($group) ? 'GROUP BY '.$group : '';
      $limit = strlen($limit) ? 'LIMIT '.$limit : '';

      //MONTA A QUERY
      //$this->setQuery('SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit);
      $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$join.' '.$where.' '.$order.' '.$group.' '.$limit;

    //EXECUTA A QUERY
    return $this->execute($query);
  }

  /**
   * Método responsável por executar atualizações no banco de dados
   * @param  string $where
   * @param  array $values [ field => value ]
   * @return boolean
   */
  public function update($where,$values){
    //DADOS DA QUERY
    $fields = array_keys($values);

    //MONTA A QUERY
    $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;

    //EXECUTAR A QUERY
    $this->execute($query,array_values($values));

    //RETORNA SUCESSO
    return true;
  }

  /**
   * Método responsável por excluir dados do banco
   * @param  string $where
   * @return boolean
   */
  public function delete($where){
    //MONTA A QUERY
    $query = 'DELETE FROM '.$this->table.' WHERE '.$where;

    //EXECUTA A QUERY
    $this->execute($query);

    //RETORNA SUCESSO
    return true;
  }

}