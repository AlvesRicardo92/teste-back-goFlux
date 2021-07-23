<?php

namespace Repository;

use DB\MySQL;

class TransportadorRepository
{
    private object $MySQL;
    const TABELA = 'transportador';

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    public function insertTransportador($nome, $doc, $about, $site)
    {
        $consultaInsert = 'INSERT INTO ' . self::TABELA . ' (name,doc,about,site) VALUES (:nome, :doc, :about, :site)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaInsert);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':doc', $doc);
        $stmt->bindParam(':about', $about);
        $stmt->bindParam(':site', $site);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function getMySQL()
    {
        return $this->MySQL;
    }
}