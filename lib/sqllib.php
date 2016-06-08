<?php
session_start();

class sqllib {
    private $appdir; 
    public function __construct() {
        $this->appdir = $_SESSION['appdir'];
        #echo $this->appdir;
        $this->db = new SQLite3($this->appdir . '/db/config.db') or die("Unable to open DB");
    }
    
    public function createUserTable() {
        $this->db->exec('DROP TABLE IF EXISTS users');
$usersql = <<<EOD
CREATE TABLE IF NOT EXISTS users (
ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
USERID TEXT NOT NULL,
PASSWORD TEXT NOT NULL,
ROLE TEXT NOT NULL)
EOD;

        $ret = $this->db->exec($usersql) or die("table create failed") ;
        return $ret;

    }
    
    public function createGwTable($gwhost, $gwport, $gwadmin, $gwpass) {
        
        $this->db->exec('DROP TABLE IF EXISTS gw');
$gwsql = <<<EOD
CREATE TABLE IF NOT EXISTS gw (
GWHOST TEXT NOT NULL,
GWPORT INT NOT NULL,
GWADMIN TEXT NOT NULL,
GWPASS TEXT NOT NULL)
EOD;

    $ret = $this->db->exec($gwsql) or die("table create failed");
    $sql3 = "INSERT INTO gw (GWHOST, GWPORT, GWADMIN, GWPASS)
        VALUES('$gwhost', '$gwport', '$gwadmin', '$gwpass')";
        $this->db->exec($sql3);
        $result = $this->db->query('SELECT * FROM gw');
        While ($row = $result->fetchArray())
        {
            if ("{$row['GWHOST']}" == $gwhost){
                return 0;
            }
            else{
                return 1;
            }
        }
    }
    
    public function createadmin($admin, $adminpass, $role) {
        $sql = "INSERT INTO users (USERID, PASSWORD, ROLE)
                VALUES('$admin', '$adminpass', '$role')";
        $this->db->exec($sql);
        $query = 'Select * FROM users WHERE USERID="' . $admin . '"';
        $result = $this->db->query($query);
        While ($row = $result->fetchArray())
        {
            echo "{$row['USERID']}";
            if ("{$row['USERID']}" == $admin){
                return 0;
            }
            else {
                return 1;
            }
        }
    }
    
    public function deladmin($admin) {
        $sql = 'DELETE FROM users WHERE USERID="' . $admin . '"';
        #echo $sql;
        $this->db->exec($sql)or die("Delete Amdin Failed");
    }
 
    public function dbquery($querystring) {
        $results = $this->db->query($querystring);
        return $results;
    }
    
    public function gettabels(){
        
        $tablesquery = $this->db->query("SELECT name FROM sqlite_master WHERE type='table';");

            while ($table = $tablesquery->fetchArray(SQLITE3_ASSOC)) {
                echo $table['name'];
            }
    }
    
    public function execute($sql) {
        
        $results = $this->db->exec($sql);
        return $results;
        
    }

    public function changepwd($user, $pwd){
        $sql = "UPDATE users SET PASSWORD='$pwd' WHERE USERID='$user'";
        $result = $this->db->query($sql);
        #var_dump($result);
        return $result;
    }
        
        
    
    
}
