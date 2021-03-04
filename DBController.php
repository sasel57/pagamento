<?php

class DBController
{   public  const STRIPE_PUB_KEY = 'pk_test_51IQttjHD9505Ebk8Kaa7u3JhZbWIzTnPy2KNdcpKPEkDdNhWEarcEqcS3nHLPuHTfCIWvRQty4VxQQtBYqWCjBuy00c8T9qZiK';

    public  const STRIPE_SECRET_KEY = 'sk_test_51IQttjHD9505Ebk8jPY0aP0QoW1Jh2UVBaXuqzLNieFxEQi3fpRh386Z9l6ACKAbd3VqopCIS7XQAzkhc2FH8QMO00YoG5roNs';

    private $host = "tradersmbetadb.mysql.db";

    private $user = "tradersmbetadb";

    private $password = "fGgzDsH4KT2c";

    private $database = "tradersmbetadb";

    private $conn;

    function __construct()
    {
        $this->conn = $this->connectDB();
    }

    function connectDB()
    {
        $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        return $conn;
    }

    function runQuery($query, $param_type, $param_value_array)
    {
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
        $result = $sql->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $resultset[] = $row;
            }
        }
        
        if (! empty($resultset)) {
            return $resultset;
        }
    }

    function bindQueryParams($sql, $param_type, $param_value_array)
    {
        $param_value_reference[] = & $param_type;
        for ($i = 0; $i < count($param_value_array); $i ++) {
            $param_value_reference[] = & $param_value_array[$i];
        }
        call_user_func_array(array(
            $sql,
            'bind_param'
        ), $param_value_reference);
    }

    function insert($query, $param_type, $param_value_array)
    {
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
    }
}
?>