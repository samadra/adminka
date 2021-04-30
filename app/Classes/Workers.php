<?php

class Workers
{
    private DB $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function get(): array
    {
        $query = 'SELECT w.*,p.id as pos_id, p.name as pos_name FROM workers w 
                  JOIN positions p on p.id = w.position_id';
        return $this->db->select($query);
    }

    public function getPositions(): array
    {
        $query = 'SELECT * FROM positions';
        return $this->db->select($query);
    }

    public function store($request)
    {
        $password = password_hash($request['password'], PASSWORD_DEFAULT);
        $query = "INSERT INTO workers (name,surname,age,email,password,position_id,salary) VALUES (?,?,?,?,?,?,?)";
        $id = $this->db->insert($query, [
            $request['name'], $request['surname'], $request['age'], $request['email'], $password, $request['position_id'], $request['salary']
        ]);
    }

    public function edit($id): array
    {
        if (!is_numeric($id)) {
            header('Location: /workers');
            exit();
        }
        $query = 'SELECT w.*,p.id as pos_id, p.name as pos_name FROM workers w 
                  JOIN positions p on p.id = w.position_id
                  WHERE w.id = ?';
        return $this->db->first($query, [$id]);
    }

    public function update($request, $id)
    {
        if (!is_numeric($id)) {
            header('Location: /workers');
            exit();
        }

    }
}