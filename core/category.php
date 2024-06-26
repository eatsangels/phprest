<?php


class Category{
    //db stuff

    private $conn;
    private $table = 'categories';


    //category properties
    public $id;
    public $name;
    public $created_at;
    
    //constructor with db
    public function __construct($db){
        
        $this->conn = $db;
    }
    //getting posts from database
    public function read(){
        //create query
        $query = 'SELECT 
        *
        FROM 
        ' . $this->table;

        //prepare statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute();

        return $stmt;
    }
    public function read_single(){
        $query = 'SELECT 
        c.name as category_name, 
        p.id, 
        p.category_id, 
        p.tittle, 
        p.body, 
        p.author, 
        p.created_at
        FROM 
        ' . $this->table . ' p
        LEFT JOIN
        categories c ON p.category_id = c.id
        WHERE
        p.id = ?
        LIMIT 1';

             //prepare statement
            $stmt = $this->conn->prepare($query);

             //binding param
            $stmt->bindParam(1, $this->id);

             //execute query
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->tittle = $row['tittle'];
            $this->body = $row['body'];
            $this->author = $row['author'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];
    }

    public function create(){

        //create query
        $query = "INSERT INTO " . $this->table . " SET tittle = :tittle, body = :body, author = :author, category_id = :category_id";

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->tittle = htmlspecialchars(strip_tags($this->tittle));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        
        //binding of parameters

        $stmt->bindParam(':tittle', $this->tittle);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        
        //execute query
        if($stmt->execute()){
            return true;
        }
        printf("Error: %s.\n", $stmt->error);
        return false;
        

        
    }


    //update post function
    public function update(){

        //create query
        $query = "UPDATE " . $this->table . " SET tittle = :tittle, body = :body, author = :author, category_id = :category_id" . " WHERE id = :id";

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->tittle = htmlspecialchars(strip_tags($this->tittle));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        
        //binding of parameters

        $stmt->bindParam(':tittle', $this->tittle);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        
        //execute query
        if($stmt->execute()){
            return true;
        }
        printf("Error: %s.\n", $stmt->error);
        return false;
        

        
    }

    //delete post function
    public function delete(){

        //create query
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";

        //prepare statement
        $stmt = $this->conn->prepare($query);
        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        //binding of parameters
        $stmt->bindParam(':id', $this->id);

        //execute query
        if($stmt->execute()){
            return true;
        }
        //print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;


    }
}

?>