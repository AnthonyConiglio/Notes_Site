<?php

class Connection{
	
	public $pdo = null;
	
    public function __construct(){
		
        try {
            $this->pdo = new PDO('mysql:server=localhost; dbname=user_logins', 'root', '');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }   
		
		catch (PDOException $exception) {
            echo "ERROR: " . $exception->getMessage();
      	}

   	}
	
	
public function getNotes(){
	
	    $stmt = $this->pdo->prepare("SELECT * FROM notes ORDER BY create_date DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
	

	
    public function addNote($note){
	
		$stmt = $this->pdo->prepare("INSERT INTO notes (title, description, create_date,categories)
                                    VALUES (:title, :description, :date, :categories)");
        $stmt->bindValue('title', $note['title']);
        $stmt->bindValue('description', $note['description']);
        $stmt->bindValue('date', date('Y-m-d H:i:s'));
		$stmt->bindValue('categories', $note['categories']);
        return $stmt->execute();
    }

    public function updateNote($id, $note){
		$stmt = $this->pdo->prepare("UPDATE notes SET title = :title, description = :description, categories = :categories WHERE id = :id");
        $stmt->bindValue('id', $id);
        $stmt->bindValue('title', $note['title']);
        $stmt->bindValue('description', $note['description']);
		$stmt->bindValue('categories', $note['categories']);
        return $stmt->execute();
		
    }

    public function removeNote($id){
       $stmt = $this->pdo->prepare("DELETE FROM notes WHERE id = :id");
        $stmt->bindValue('id', $id);
        return $stmt->execute();
    }

    public function getNoteById($id){
        $stmt = $this->pdo->prepare("SELECT * FROM notes WHERE id = :id");
        $stmt->bindValue('id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
	
}

return new Connection();