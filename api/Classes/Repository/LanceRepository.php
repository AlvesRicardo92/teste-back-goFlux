<?php

namespace Repository;

use DB\MySQL;

class LanceRepository
{
    private object $MySQL;
    const TABELA = 'lance';

    /**
     * LanceRepository constructor.
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
    public function insertLance($id_provider, $id_offer,$value,$amount)
    {
        $consultaInsert = 'INSERT INTO ' . self::TABELA . ' (id_provider, id_offer,value,amount) VALUES (:idProvider, :idOffer,:value,:amount)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaInsert);
        $stmt->bindParam(':idProvider', $id_provider);
        $stmt->bindParam(':idOffer', $id_offer);
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':amount', $amount);
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