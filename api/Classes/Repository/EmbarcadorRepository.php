<?php

namespace Repository;

use DB\MySQL;

class EmbarcadorRepository
{
    private object $MySQL;
    const TABELA = 'embarcador';

    /**
     * EmbarcadorRepository constructor.
     */
    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    /**
     * @param $login
     * @return int
     */
    /*public function getRegistroByLogin($login)
    {
        $consulta = 'SELECT * FROM ' . self::TABELA . ' WHERE login = :login';
        $stmt = $this->MySQL->getDb()->prepare($consulta);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        return $stmt->rowCount();
    }*/

    /**
     * @param $login
     * @param $senha
     * @return int
     */
    public function insertEmbarcador($nome, $doc,$about,$active, $site)
    {
        $consultaInsert = 'INSERT INTO ' . self::TABELA . ' (name, doc, about, active, site) VALUES (:name, :doc, :about, :active, :site)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaInsert);
        $stmt->bindParam(':name', $nome);
        $stmt->bindParam(':doc', $doc);
        $stmt->bindParam(':about', $about);
        $stmt->bindParam(':active', $active);
        $stmt->bindParam(':site', $site);

        $stmt->execute();
        return $stmt->rowCount();
    }

    /**
     * @param $id
     * @param $login
     * @param $senha
     * @return int
     */
    /*public function updateUser($id, $dados)
    {
        $consultaUpdate = 'UPDATE ' . self::TABELA . ' SET login = :login, senha = :senha WHERE id = :id';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaUpdate);
        $stmt->bindParam(':id', $id);
        $stmt->bindValue(':login', $dados['login']);
        $stmt->bindValue(':senha', $dados['senha']);
        $stmt->execute();
        return $stmt->rowCount();
    }*/

    /**
     * @return MySQL|object
     */
    public function getMySQL()
    {
        return $this->MySQL;
    }
}