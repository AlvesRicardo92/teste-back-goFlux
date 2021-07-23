<?php

namespace Service;

use InvalidArgumentException;
use Repository\EmbarcadorRepository;
use Util\ConstantesGenericasUtil;

class EmbarcadorService
{
    public const TABELA = 'embarcador';
    public const RECURSOS_GET = ['listar'];
    public const RECURSOS_POST = ['cadastrar'];
    public const RECURSOS_DELETE = ['deletar'];
    public const RECURSOS_PUT = ['atualizar'];

    private array $dados;
    private array $dadosCorpoRequest;
    /**
     * @var object|EmbarcadorRepository
     */
    private object $EmbarcadorRepository;

    /**
     * EmbarcadorService constructor.
     * @param array $dados
     */
    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->EmbarcadorRepository = new EmbarcadorRepository();
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

    
    /**
     * @param array $dadosCorpoRequest
     */
    public function setDadosCorpoRequest($dadosCorpoRequest)
    {
        $this->dadosCorpoRequest = $dadosCorpoRequest;
    }

    /**
     * @return mixed
     */
    private function listar()
    {
        return $this->EmbarcadorRepository->getMySQL()->getAll(self::TABELA);
    }

    /**
     * @return mixed
     */
    private function getOneByKey()
    {
        return $this->EmbarcadorRepository->getMySQL()->getOneByKey(self::TABELA, $this->dados['id']);
    }

    /**
     * @return array
     */
    private function cadastrar()
    {
        [$nome, $doc, $about, $active, $site] = [$this->dadosCorpoRequest['name'], $this->dadosCorpoRequest['doc'], $this->dadosCorpoRequest['about'], $this->dadosCorpoRequest['active'], $this->dadosCorpoRequest['site']];

        if ($nome && $doc && $about && $active && $site) {
            if ($this->EmbarcadorRepository->insertEmbarcador($nome, $doc,$about, $active, $site) > 0) {
                $idInserido = $this->EmbarcadorRepository->getMySQL()->getDb()->lastInsertId();
                $this->EmbarcadorRepository->getMySQL()->getDb()->commit();
                return ['id_inserido' => $idInserido, 'name'=>$nome, 'doc'=>$doc, 'about'=>$about, 'active'=>$active, 'site'=>$site];
            }

            $this->EmbarcadorRepository->getMySQL()->getDb()->rollBack();

            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
    }
    

}