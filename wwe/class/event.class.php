<?php
class Event {
    private $id;
    private $name;
    private $pdo;

    public static function fetchPaginated($pdo, $limit, $offset) {
        $sql = "SELECT * FROM events ORDER BY id LIMIT :limit OFFSET :offset";
    
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit);
        $stmt->bindValue(':offset', $offset);
        $stmt->execute();
        
        $results = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = new Event($pdo, $row);
        }
        
        return $results;
    }

    public static function countAll($pdo) {
        $sql = "SELECT COUNT(*) FROM events";
        $stmt = $pdo->query($sql);
        return (int)$stmt->fetchColumn();
    }

    public static function findWithPagination($pdo, $criteres, $limit, $offset) {
        // Base de la requête
        $sql = "SELECT * FROM events WHERE ";
        
        $where = [];
        $params = [];

        // Construction des conditions
        if (!empty($criteres)) {
            foreach ($criteres as $critere => $valeur) {
                if ($critere === 'name') {
                    $where[] = "name ILIKE :name";
                    $params[':name'] = '%'.$valeur.'%';
                } else {
                    $where[] = "$critere = :$critere";
                    $params[":$critere"] = $valeur;
                }
            }

            // Ajout des conditions à la requête
            $sql .= implode(' AND ', $where);
        }
        
        // Ajout de la pagination
        $sql .= " ORDER BY id LIMIT :limit OFFSET :offset";
        $params[':limit'] = $limit;
        $params[':offset'] = $offset;

        try {
            $stmt = $pdo->prepare($sql);
            
            // Binding des paramètres
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            $stmt->execute();
            $results = [];
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $results[] = new Event($pdo, $row);
            }
            
            return $results;
        } catch (PDOException $e) {
            throw $e;
        }
    }
    
    public static function countWithFilters($pdo, $criteres) {
        $sql = "SELECT COUNT(*) FROM events";
        
        $params = [];
        $where = [];

        if (!empty($criteres)) {
            $sql .= " WHERE ";

            foreach ($criteres as $critere => $valeur) {
                if ($critere === 'name') {
                    $where[] = "name ILIKE :name";
                    $params[':name'] = '%'.$valeur.'%';
                } else {
                    $where[] = "$critere = :$critere";
                    $params[":$critere"] = $valeur;
                }
            }

            $sql .= implode(' AND ', $where);
        }
        
        $stmt = $pdo->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function __construct($pdo, $data = array()) {
        $this->pdo = $pdo;
        $this->hydrate($data);
    }

    public function __get($property) {
        return property_exists($this, $property) ? $this->$property : null;
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    public function fetch($id) {
        if ($id) {
            $sql = "SELECT * FROM events WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            $event = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($event) {
                $this->hydrate($event);
            } else {
                throw new Exception("Event not found");
            }
        } else {
            throw new Exception("Error: ID is required");
        }
    }

    public function create() {
        try {
            $this->pdo->beginTransaction();

            $sql = "INSERT INTO events (name) VALUES (:name) RETURNING id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":name", $this->name);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $result['id'];

            $this->pdo->commit();
        } catch(PDOException $e) {
            $this->pdo->rollback();
            throw $e;
        }
    }

    public function update() {
        try {
            $this->pdo->beginTransaction();

            $sql = "UPDATE events SET name = :name WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":name", $this->name);
            $stmt->bindValue(":id", $this->id);
            $stmt->execute();

            $this->pdo->commit();
        } catch (PDOException $e) {
            $this->pdo->rollback();
            throw $e;
        }
    }

    public function delete() {
        try {
            $this->pdo->beginTransaction();

            $sql = "DELETE FROM events WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":id", $this->id);
            $stmt->execute();

            $this->pdo->commit();
        } catch (PDOException $e) {
            $this->pdo->rollback();
            throw $e;
        }
    }

    private function hydrate($data) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}