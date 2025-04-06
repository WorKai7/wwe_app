<?php
class WrestlingMatch {
    private $id;
    private $card_id;
    private $winner_id;
    private $win_type;
    private $loser_id;
    private $match_type_id;
    private $duration;
    private $title_id;
    private $title_change;
    private $loser_name;
    private $winner_name;
    private $match_type_name;
    private $pdo;

    public static function getAllTypes($pdo) {
        $stmt = $pdo->query("SELECT id, name FROM match_types ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function fetchPaginated($pdo, $limit, $offset) {
        $sql = "SELECT m.*, w.name as winner_name, w2.name as loser_name, t.name as match_type_name
                FROM matches m
                INNER JOIN wrestlers w ON m.winner_id = w.id
                INNER JOIN wrestlers w2 ON m.loser_id = w2.id
                INNER JOIN match_types t ON m.match_type_id = t.id
                WHERE m.id > :last_id
                ORDER BY m.id LIMIT :limit";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit);
        $stmt->bindValue(':last_id', $offset);
        $stmt->execute();
        
        $results = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = new WrestlingMatch($pdo, $row);
        }
        
        return $results;
    }

    public static function countAll($pdo) {
        $sql = "SELECT COUNT(*) FROM matches";
        $stmt = $pdo->query($sql);
        return (int)$stmt->fetchColumn();
    }

    public static function countWithFilters($pdo, $filters) {
        $sql = "SELECT COUNT(*) FROM matches m";
        
        $whereClauses = [];
        $params = [];
        
        // Traitement des filtres
        if (!empty($filters)) {
            // Filtre par ID
            if (!empty($filters['id'])) {
                $whereClauses[] = "m.id = :id";
                $params[':id'] = $filters['id'];
            }
            
            // Filtre par nom de vainqueur
            if (!empty($filters['winner_name'])) {
                $sql .= " INNER JOIN wrestlers w ON w.id = m.winner_id";
                $whereClauses[] = "w.name ILIKE :winner_name";
                $params[':winner_name'] = '%' . $filters['winner_name'] . '%';
            }
            
            // Filtre par type de match
            if (!empty($filters['match_type_name'])) {
                $sql .= " INNER JOIN match_types mt ON mt.id = m.match_type_id";
                $whereClauses[] = "mt.name ILIKE :match_type_name";
                $params[':match_type_name'] = '%' . $filters['match_type_name'] . '%';
            }
        }
        
        // Construction de la clause WHERE
        if (!empty($whereClauses)) {
            $sql .= " WHERE " . implode(" AND ", $whereClauses);
        }
    
        try {
            $stmt = $pdo->prepare($sql);
            
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            $stmt->execute();
            return (int)$stmt->fetchColumn();
            
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public static function findWithPagination($pdo, $filters, $limit, $offset) {
        $sql = "SELECT m.*, w.name as winner_name, w2.name as loser_name, mt.name as match_type_name 
                FROM matches m
                INNER JOIN wrestlers w ON w.id = m.winner_id
                INNER JOIN wrestlers w2 ON w2.id = m.loser_id
                INNER JOIN match_types mt ON mt.id = m.match_type_id";
        
        $params = [];
        $where = [];
        
        // Filtre par nom de vainqueur
        if (!empty($filters['winner_name'])) {
            $where[] = "w.name ILIKE :winner_name";
            $params[':winner_name'] = '%'.$filters['winner_name'].'%';
        }
        
        // Filtre par nom de perdant
        if (!empty($filters['loser_name'])) {
            $where[] = "w2.name ILIKE :loser_name";
            $params[':loser_name'] = '%'.$filters['loser_name'].'%';
        }
        
        // Filtre par type de match
        if (!empty($filters['match_type_name'])) {
            $where[] = "mt.name ILIKE :match_type_name";
            $params[':match_type_name'] = '%'.$filters['match_type_name'].'%';
        }
        
        // Filtre par ID
        if (!empty($filters['id'])) {
            $where[] = "m.id = :id";
            $params[':id'] = $filters['id'];
        }
        
        // Construction de la clause WHERE
        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= " AND m.id > :last_id ";
        $params[":last_id"] = $offset;
        
        $sql .= " ORDER BY m.id LIMIT :limit ";
        $params[':limit'] = $limit;
        
        try {
            $stmt = $pdo->prepare($sql);
            
            // Bind des paramètres
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            $stmt->execute();
            $matches = [];
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $match = new WrestlingMatch($pdo, $row);
                $matches[] = $match;
            }
            
            return $matches;
            
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public static function findWithPaginationWithOffset($pdo, $filters, $limit, $offset) {
        $sql = "SELECT m.*, w.name as winner_name, w2.name as loser_name, mt.name as match_type_name 
                FROM matches m
                INNER JOIN wrestlers w ON w.id = m.winner_id
                INNER JOIN wrestlers w2 ON w2.id = m.loser_id
                INNER JOIN match_types mt ON mt.id = m.match_type_id";
        
        $params = [];
        $where = [];
        
        // Filtre par nom de vainqueur
        if (!empty($filters['winner_name'])) {
            $where[] = "w.name ILIKE :winner_name";
            $params[':winner_name'] = '%'.$filters['winner_name'].'%';
        }
        
        // Filtre par nom de perdant
        if (!empty($filters['loser_name'])) {
            $where[] = "w2.name ILIKE :loser_name";
            $params[':loser_name'] = '%'.$filters['loser_name'].'%';
        }
        
        // Filtre par type de match
        if (!empty($filters['match_type_name'])) {
            $where[] = "mt.name ILIKE :match_type_name";
            $params[':match_type_name'] = '%'.$filters['match_type_name'].'%';
        }
        
        // Filtre par ID
        if (!empty($filters['id'])) {
            $where[] = "m.id = :id";
            $params[':id'] = $filters['id'];
        }
        
        // Construction de la clause WHERE
        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }
        
        $sql .= " ORDER BY m.id LIMIT :limit OFFSET :offset ";
        $params[':limit'] = $limit;
        $params[":offset"] = $offset;
        
        try {
            $stmt = $pdo->prepare($sql);
            
            // Bind des paramètres
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            $stmt->execute();
            $matches = [];
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $match = new WrestlingMatch($pdo, $row);
                $matches[] = $match;
            }
            
            return $matches;
            
        } catch (PDOException $e) {
            throw $e;
        }
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
        $sql = "SELECT * FROM matches WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $this->hydrate($stmt->fetch(PDO::FETCH_ASSOC));
    }

    public function create() {
        $this->pdo->beginTransaction();
        
        $sql = "INSERT INTO matches (
            card_id, winner_id, win_type, loser_id, 
            match_type_id, duration, title_id, title_change
        ) VALUES (
            :card_id, :winner_id, :win_type, :loser_id, 
            :match_type_id, :duration, :title_id, :title_change
        ) RETURNING id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':card_id' => $this->card_id,
            ':winner_id' => $this->winner_id,
            ':win_type' => $this->win_type,
            ':loser_id' => $this->loser_id,
            ':match_type_id' => $this->match_type_id,
            ':duration' => $this->duration,
            ':title_id' => $this->title_id,
            ':title_change' => $this->title_change
        ]);

        $this->id = $stmt->fetchColumn();
        $this->pdo->commit();
    }

    public function update() {
        $sql = "UPDATE matches SET 
            card_id = :card_id,
            winner_id = :winner_id,
            win_type = :win_type,
            loser_id = :loser_id,
            match_type_id = :match_type_id,
            duration = :duration,
            title_id = :title_id,
            title_change = :title_change
        WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $this->id,
            ':card_id' => $this->card_id,
            ':winner_id' => $this->winner_id,
            ':win_type' => $this->win_type,
            ':loser_id' => $this->loser_id,
            ':match_type_id' => $this->match_type_id,
            ':duration' => $this->duration,
            ':title_id' => $this->title_id,
            ':title_change' => $this->title_change,
        ]);
    }

    public function delete() {
        try {
            $this->pdo->beginTransaction();

            $sql = "DELETE FROM matches WHERE id = :id";
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