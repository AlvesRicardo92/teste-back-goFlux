<?php

namespace Service;

use InvalidArgumentException;
use Repository\TransportadorRepository;
use Util\ConstantesGenericasUtil;

class TransportadorService
{
    public const TABELA = 'transportador';
    public const RECURSOS_GET = ['listar'];
    public const RECURSOS_POST = ['cadastrar'];
    public const RECURSOS_DELETE = ['deletar'];
    public const RECURSOS_PUT = ['atualizar'];

    private array $dados;
    private array $dadosCorpoRequest;
    /**
     * @var object|TransportadorRepository
     */
    private object $TransportadorRepository;

    /**
     * TransportadorService constructor.
     * @param array $dados
     */
    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->TransportadorRepository = new TransportadorRepository();
    }

    /**
     * @return mixed
     */
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
        return $this->TransportadorRepository->getMySQL()->getAll(self::TABELA);
    }

    private function getOneByKey()
    {
        return $this->TransportadorRepository->getMySQL()->getOneByKey(self::TABELA, $this->dados['id']);
    }

    private function cadastrar()
    {
        [$nome, $doc, $about, $active, $site] = [$this->dadosCorpoRequest['name'], $this->dadosCorpoRequest['doc'], $this->dadosCorpoRequest['about'], $this->dadosCorpoRequest['active'], $this->dadosCorpoRequest['site']];

        if ($nome && $doc && $about && $active && $site) {

            if ($this->TransportadorRepository->insertTransportador($nome, $doc,$about,$active, $site) > 0) {
                $idInserido = $this->TransportadorRepository->getMySQL()->getDb()->lastInsertId();
                $this->TransportadorRepository->getMySQL()->getDb()->commit();
                return ['id_inserido' => $idInserido, 'name'=>$nome, 'doc'=>$doc, 'about'=>$about, 'active'=>$active, 'site'=>$site];
            }

            $this->TransportadorRepository->getMySQL()->getDb()->rollBack();

            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
    }
}