<?php

namespace Repository;

use DB\MySQL;

class OfertaRepository
{
    private object $MySQL;
    const TABELA = 'oferta';

    /**
     * OfertaRepository constructor.
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
    public function insertOferta($id_customer, $from,$to,$initial_value,$amount,$amount_type)
    {
        $consultaInsert = 'INSERT INTO ' . self::TABELA . ' (id_customer, _from,_to,initial_value,amount,amount_type) VALUES (:idCustomer, :from,:to,:initialValue,:amount,:amountType)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaInsert);
        $stmt->bindParam(':idCustomer', $id_customer);
        $stmt->bindParam(':from', $from);
        $stmt->bindParam(':to', $to);
        $stmt->bindParam(':initialValue', $initial_value);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':amountType', $amount_type);
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