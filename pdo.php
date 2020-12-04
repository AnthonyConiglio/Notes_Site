<?php

class Connection{
	public $pdo = null;
    public function __construct()
	{
        try {
            $this->pdo = new PDO('mysql:server=localhost; dbname=user_logins', 'root', '');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "ERROR: " . $exception->getMessage();
        }

    }
	
	
public function getNotes(){
	    $statement = $this->pdo->prepare("SELECT * FROM notes ORDER BY create_date DESC");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
	

	
    public function addNote($note){
	
		$statement = $this->pdo->prepare("INSERT INTO notes (title, description, create_date,categories)
                                    VALUES (:title, :description, :date, :categories)");
        $statement->bindValue('title', $note['title']);
        $statement->bindValue('description', $note['description']);
        $statement->bindValue('date', date('Y-m-d H:i:s'));
		$statement->bindValue('categories', $note['categories']);
        return $statement->execute();
    }

    public function updateNote($id, $note)
    {
		 $statement = $this->pdo->prepare("UPDATE notes SET title = :title, description = :description, categories = :categories WHERE id = :id");
        $statement->bindValue('id', $id);
        $statement->bindValue('title', $note['title']);
        $statement->bindValue('description', $note['description']);
		$statement->bindValue('categories', $note['categories']);
        return $statement->execute();
		
    }

    public function removeNote($id)
    {
       $statement = $this->pdo->prepare("DELETE FROM notes WHERE id = :id");
        $statement->bindValue('id', $id);
        return $statement->execute();
    }

    public function getNoteById($id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM notes WHERE id = :id");
        $statement->bindValue('id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}

return new Connection();