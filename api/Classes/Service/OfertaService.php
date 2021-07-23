<?php

namespace Service;

use InvalidArgumentException;
use Repository\OfertaRepository;
use Util\ConstantesGenericasUtil;

class OfertaService
{
    public const TABELA = 'oferta';
    public const RECURSOS_GET = ['listar'];
    public const RECURSOS_POST = ['cadastrar'];
    public const RECURSOS_DELETE = ['deletar'];
    public const RECURSOS_PUT = ['atualizar'];

    private array $dados;
    private array $dadosCorpoRequest;
    /**
     * @var object|OfertaRepository
     */
    private object $OfertaRepository;

    /**
     * OfertaService constructor.
     * @param array $dados
     */
    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->OfertaRepository = new OfertaRepository();
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


    private function listar()
    {
        return $this->OfertaRepository->getMySQL()->getAll(self::TABELA);
    }


    private function getOneByKey()
    {
        return $this->OfertaRepository->getMySQL()->getOneByKey(self::TABELA, $this->dados['id']);
    }


    private function cadastrar()
    {
        [$idCustomer, $from, $to, $initial_value, $amount,$amountType] = [$this->dadosCorpoRequest['id_customer'], $this->dadosCorpoRequest['from'], $this->dadosCorpoRequest['to'], $this->dadosCorpoRequest['initial_value'],$this->dadosCorpoRequest['amount'], $this->dadosCorpoRequest['amount_type']];

        if ($idCustomer && $from && $to && $initial_value && $amount && $amountType) {

            if ($this->OfertaRepository->insertOferta($idCustomer, $from, $to, $initial_value, $amount,$amountType) > 0) {
                $idInserido = $this->OfertaRepository->getMySQL()->getDb()->lastInsertId();
                $this->OfertaRepository->getMySQL()->getDb()->commit();
                return ['id_inserido' => $idInserido, 'id_customer'=>$idCustomer, 'from'=>$from, 'to'=>$to, 'initial_value'=>$initial_value, 'amount'=>$amount, 'amount_type'=>$amountType];
            }

            $this->OfertaRepository->getMySQL()->getDb()->rollBack();

            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
    }

}