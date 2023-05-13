<?php
class DBConnector
{
    private $conn;
    private $username = "root";
    private $password = "";
    private $dbname = "atm_db";
    private $host = "localhost";

    /**
     * Opens the connection with the Database.
     *
     * @throws Exception If there was an error opening the connection.
     */
    public function __construct()
    {
        $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->dbname);
        if (!$this->conn) {
            throw new Exception("Failed to connect to database: " . mysqli_connect_error());
        }
    }

    /**
     * Retrieves rows from the specified table and returns them as an array of associative arrays.
     *
     * @param string $table The name of the table to select from.
     * @param string|array $columns The column(s) to select.
     * @param string|null $where The WHERE clause of the query, without the "WHERE" keyword.
     * @param array $params An array of values to bind to the query.
     * @return mixed An array of associative arrays representing the rows selected.
     * @throws Exception If there was an error executing the select query.
     */
    public function select($table, $columns = "*", $where = null, $params = array())
    {
        $query = "SELECT $columns FROM $table";
        if ($where) {
            $query .= " WHERE $where";
        }
        try {
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                $e = new Exception();
            }
            if ($params) {
                $types = str_repeat("s", count($params));
                $stmt->bind_param($types, ...$params);
            }
            if (!$stmt->execute()) {
                $e = new Exception();
            }
        } catch (Exception $e) {
            return false;
        }
        $result = $stmt->get_result();
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * Inserts a new record into the specified table with the given data.
     *
     * @param string $table The name of the table to insert into.
     * @param array $data An array of values to insert into the table.
     * @return int The number of rows affected by the insert operation.
     * @throws Exception If there was an error executing the insert query.
     */
    public function insert($table, $data)
    {
        $columns = implode(",", array_keys($data));
        $values = implode(",", array_fill(0, count($data), "?"));
        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        try {
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                $e = new Exception();
            }

            $values = array_values($data);
            $params = array(str_repeat("s", count($data)));
            foreach ($values as $value) {
                $params[] = $value;
            }


            if (!$stmt->bind_param(...$params))
                $e = new Exception();


            if (!$stmt->execute())
                $e = new Exception();
        } catch (Exception $e) {
            return false;
        }
        return $stmt->affected_rows>0?true:false;
    }

    /**
     * Update rows in the specified table that match the provided condition with the provided data.
     *
     * @param string $table The name of the table to update.
     * @param array $data An Associative Array of data to update, where the keys are column names and the value is the new value of that cell.
     * @param string $where The WHERE clause for the update query without the WHERE Keyword.
     * @param array $params An array of parameters to replace the "?" in the where string.
     * @return int The number of affected rows.
     * @throws Exception If the query fails to prepare, bind parameters, or execute.
     */
    public function update($table, $data, $where, $params = array())
    {
        $set = array();
        foreach ($data as $column => $value) {
            $set[] = "$column=?";
        }
        $set_clause = implode(",", $set);
        $query = "UPDATE $table SET $set_clause WHERE $where";

        try {
            $stmt = $this->conn->prepare($query);

            if (!$stmt)
                $e = new Exception();

            $values = array_values($data);
            if ($params)
                $values = array_merge($values, $params);

            if (!$stmt->bind_param(str_repeat("s", count($values)), ...$values))
                $e = new Exception();

            if (!$stmt->execute())
                $e = new Exception();
        } catch (Exception $e) {
            return false;
        }
        return $stmt->affected_rows>0?true:false;
    }


    /**
     * Deletes rows from the specified table that match the given condition.
     *
     * @param string $table The name of the table to delete from.
     * @param string|null $where The WHERE clause of the query, without the "WHERE" keyword.
     * @param array $params An array of values to bind to the query.
     * @return int The number of rows affected by the delete operation.
     * @throws Exception If there was an error executing the delete query.
     */
    public function delete($table, $where, $params = array()){
        $query = "DELETE FROM $table WHERE $where";
        try {
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                $e = new Exception();
            }
            if ($params) {
                $types = str_repeat("s", count($params));
                $stmt->bind_param($types, ...$params);
            }
            if (!$stmt->execute()) {
                $e = new Exception();
            }
        } catch (Exception $e) {
            return false;
        }
        return $stmt->affected_rows>0?true:false;
    }

    public function join($sqlqry){
        $result = $this->conn->query($sqlqry);
        return $result->fetch_assoc();
        
    }

    /**
     * Closes the Database Connection.
     */
    public function close()
    {
        mysqli_close($this->conn);
    }
}
