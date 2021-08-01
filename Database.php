<?php 

    class Database {
        public function __construct() {
            $this->db = new PDO("mysql:host=".DB_HOST."; dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
        }

        public function query($sql){
        	$query = $this->db->prepare($sql);
        	$query->execute();

        }

        public function selectOne($sql){
            $query = $this->db->prepare($sql);
            $query->execute();
            return $query->fetch();          
        }

        public function selectAll($sql){
            $query = $this->db->prepare($sql);
            $query->execute();     
            return $query->fetchAll();       
        }

        public function update($table, $data, $where){
            $set_data = '';
            $where_data = '';
            foreach($data as $key => $value) {
                $set_data .= ", {$key} = '{$value}'";
            }
            foreach($where as $key => $value) {
                $where_data .= "AND {$key} = '{$value}'";
            }
            $set_data = ltrim($set_data,',');
            $where_data = ltrim($where_data,'AND') ;
            
            $this->db->query("UPDATE $table SET {$set_data} WHERE {$where_data}");
            return true;
        }

        public function insert($table, $where){
            $set = '';
            $i = 0;
            foreach($where as $key => $value) {
                if($i == 0){
                    $set .= "SET {$key} = '{$value}'";
                }else{
                    $set .= ", {$key} = '{$value}'";
                }
                $i++;
            }
            $set = ltrim($set,',');
            
            $this->db->query("INSERT INTO $table {$set}");
            $id = $this->db->lastInsertId();
            return $id;
        }

        public function delete($table, $data){
            foreach($data as $key => $value) {
                $set_data .= ", {$key} = '{$value}'";
            }

            $set_data = ltrim($set_data,',');

            $this->db->query("DELETE FROM $table WHERE {$set_data}");

        }

    }	
?>