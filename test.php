<?php
ini_set('display_errors',1);  error_reporting(E_ALL);

class Page
{
	public $title, $style, $scripts, $header, $content, $footer, $html;
	private $tagline;

	public function __construct($title)
                {
                    $this->title = $title;
                }
    public function build_top()
    {
    	$this->tagline = "<h1>" . $this->title . "</h1>";
    	$this->html = "<html><head><title>". $this->title ."</title><link rel='stylesheet' href='$this->title.css'></head><body>" . $this->tagline;
    	echo $this->html;
    }

    public function build_bottom()
    {
        $this->tagline = "<h1>" . $this->title . "</h1>";
        $this->html = "</body></html>";
        echo $this->html;
    }

}


class Database
{
    private $conn, $db, $credentials, $table, $row, $collumn, $sql;

    function __construct($db)
    {
        $this->db = $db;
    }

    function connect($credentials)
    {
        $this->credentials = $credentials;
        $this->conn = new PDO('mysql:host=localhost; dbname='.$this->db, $this->credentials[0], $this->credentials[1]);
    }
/*
    function query($sql)
    {
        $this->sql = $sql;
        "SELECT money FROM users WHERE username = :username";
        $psql=$conn->prepare($sql);
        $psql->execute(array(":username"=>$_SESSION['username']));
        $row= $psql->fetch();
    }
*/

}

include("connect.php")
$data = new Database("test");
$user = ["root", "sseagran"];
$data->connect($user);
$sql = "SELECT * FROM college";
$psql=$conn->prepare($sql);
$psql->execute(array(":college"=>"colorado_colleges"));
$row= $psql->fetch();
var_dump($row);

$home = new Page("Insource Colorado");
$home->build();
//do a query



?>

