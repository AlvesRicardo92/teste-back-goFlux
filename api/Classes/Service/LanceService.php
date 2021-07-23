<?php

namespace Service;

use InvalidArgumentException;
use Repository\LanceRepository;
use Util\ConstantesGenericasUtil;

class LanceService
{
    public const TABELA = 'lance';
    public const RECURSOS_GET = ['listar'];
    public const RECURSOS_POST = ['cadastrar'];
    public const RECURSOS_DELETE = ['deletar'];
    public const RECURSOS_PUT = ['atualizar'];

    private array $dados;
    private array $dadosCorpoRequest;
    /**
     * @var object|LanceRepository
     */
    private object $LanceRepository;

    /**
     * LanceService constructor.
     * @param array $dados
     */
    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->LanceRepository = new LanceRepository();
    }

    public function validarGet()
    {
        $retorno = null;
        $recurso = $this->dados['recurso'];
        if (in_array($recurso, self::RECURSOS_GET, true)) {
            $retorno = $this->dados['id'] > 0 ? $this->getOneByKey() : $this->$recurso();
        } else {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }

        if ($retorno === null) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        return $retorno;
    }

    public function validarPost()
    {
        $retorno = null;
        $recurso = $this->dados['recurso'];
        if (in_array($recurso, self::RECURSOS_POST, true)) {
            $retorno = $this->$recurso();
        } else {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }

        if ($retorno === null) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        return $retorno;
    }

    
    public function setDadosCorpoRequest($dadosCorpoRequest)
    {
        $this->dadosCorpoRequest = $dadosCorpoRequest;
    }

    /**
     * @return mixed
     */
    private function listar()
    {
        return $this->LanceRepository->getMySQL()->getAll(self::TABELA);
    }

    /**
     * @return mixed
     */
    private function getOneByKey()
    {
        return $this->LanceRepository->getMySQL()->getOneByKey(self::TABELA, $this->dados['id']);
    }

    /**
     * @return array
     */
    private function cadastrar()
    {
        [$idProvider, $idOffer, $value, $amount] = [$this->dadosCorpoRequest['id_provider'], $this->dadosCorpoRequest['id_offer'],$this->dadosCorpoRequest['value'], $this->dadosCorpoRequest['amount']];

        if ($idProvider && $idOffer && $value && $amount) {
            if ($this->LanceRepository->insertLance($idProvider, $idOffer, $value, $amount) > 0) {
                /*$idInserido = $this->LanceRepository->getMySQL()->getDb()->lastInsertId();*/
                $this->LanceRepository->getMySQL()->getDb()->commit();
                return ['id_provider'=>$idProvider, 'id_offer'=>$idOffer, 'value'=>$value, 'amount'=>$amount];
            }

            $this->LanceRepository->getMySQL()->getDb()->rollBack();

            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
    }

    /**
     * @return string
     */
    private function deletar()
    {
        return $this->LanceRepository->getMySQL()->delete(self::TABELA, $this->dados['id']);
    }

    /**
     * @return string
     */
    private function atualizar()
    {
        if ($this->LanceRepository->updateUser($this->dados['id'], $this->dadosCorpoRequest) > 0) {
            $this->LanceRepository->getMySQL()->getDb()->commit();
            return ConstantesGenericasUtil::MSG_ATUALIZADO_SUCESSO;
        }
        $this->LanceRepository->getMySQL()->getDb()->rollBack();
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_NAO_AFETADO);
    }

}