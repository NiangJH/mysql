<?php
class DataBase {
    const IP = '';
    const USERNAME = '';
    const PASSWORD = '';
    const DBNAME = '';
    const PORT = 3306;

    protected $mysqli;

    public function __construct() {
        $this->mysqli = new mysqli(self::IP, self::USERNAME, self::PASSWORD, self::DBNAME ,self::PORT);
    }

    private function _getMysqli() {
        return $this->mysqli;
    }
    public function getData($sql, $args, $debug = false) {

        if($debug) echo $sql;

        $stmt = self::_getMysqli()->prepare($sql);

        if(!$stmt) echo 'error';
        if(count($args) > 0) {
            $ref = new ReflectionClass('mysqli_stmt');
            $method = $ref->getMethod('bind_param');
            $method->invokeArgs($stmt,$args);
        }

        $res = array();
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $res[] = $row;
        }
        $result->free();
        $stmt->close();
        
        return $res;
    }
    public function ExecuteData($sql, $args ,$debug = false) {
        
        if($debug) echo $sql;

        $stmt = self::_getMysqli()->prepare($sql);

        if(count($args) > 0) {
            $ref = new ReflectionClass('mysqli_stmt');
            $method = $ref->getMethod('bind_param');
            $method->invokeArgs($stmt,$args);
        }

        if($stmt->execute()) {
            $count = $stmt->affected_rows;
        } else {
            $count = -1;
        }

        $stmt->close();
        return $count;
    }
    public function getLastInsId() {
        return self::_getMysqli()->insert_id;
    }
}
?>