<?php

namespace Validator;

use InvalidArgumentException;
use Repository\TokensAutorizadosRepository;
use Service\UsuariosService;
use Service\LanceService;
use Service\TransportadorService;
use Service\EmbarcadorService;
use Service\OfertaService;
use Util\ConstantesGenericasUtil;
use Util\JsonUtil;

class RequestValidator
{
    private array $request;
    private array $dadosRequest;
    private object $TokensAutorizadosRepository;

    const GET = 'GET';
    const DELETE = 'DELETE';
    const USUARIOS = 'USUARIOS';
    const LANCE = 'LANCE';
    const OFERTA = 'OFERTA';
    const TRANSPORTADOR = 'TRANSPORTADOR';
    const EMBARCADOR = 'EMBARCADOR';

    /**
     * RequestValidator constructor.
     * @param array $request
     */
    public function __construct($request = [])
    {
        $this->TokensAutorizadosRepository = new TokensAutorizadosRepository();
        $this->request = $request;
    }

    /**
     * @return array|mixed|string|null
     */
    public function processarRequest()
    {
        $retorno = utf8_encode(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);
        if (in_array($this->request['metodo'], ConstantesGenericasUtil::TIPO_REQUEST, true)) {
            $retorno = $this->direcionarRequest();
        }
        return $retorno;
    }

    /**
     * Metodo para direcionar o tipo de Request
     * @return array|mixed|string|null
     */
    private function direcionarRequest()
    {
        if ($this->request['metodo'] !== self::GET && $this->request['metodo'] !== self::DELETE) {
            $this->dadosRequest = JsonUtil::tratarCorpoRequisicaoJson();
        }
        $this->TokensAutorizadosRepository->validarToken(getallheaders()['Authorization']);
        $metodo = $this->request['metodo'];
        return $this->$metodo();
    }

    /**
     * Metodo para tratar os DELETES
     * @return mixed|string
     */
    private function delete()
    {
        $retorno = utf8_encode(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);
        if (in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_DELETE, true)) {
            switch ($this->request['rota']) {
                case self::USUARIOS:
                    $UsuariosService = new UsuariosService($this->request);
                    $retorno = $UsuariosService->validarDelete();
                    break;
                default:
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }
        }
        return $retorno;
    }

    /**
     * Metodo para tratar os GETS
     * @return array|mixed|string
     */
    private function get()
    {
        $retorno = utf8_encode(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);
        if (in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_GET, true)) {
            switch ($this->request['rota']) {
                case self::USUARIOS:
                    $UsuariosService = new UsuariosService($this->request);
                    $retorno = $UsuariosService->validarGet();
                    break;
                case self::LANCE:
                    $LanceService = new LanceService($this->request);
                    $retorno = $LanceService->validarGet();
                    break;
                case self::TRANSPORTADOR:
                    $TransportadorService = new TransportadorService($this->request);
                    $retorno = $TransportadorService->validarGet();
                    break;
                case self::EMBARCADOR:
                    $EmbarcadorService = new EmbarcadorService($this->request);
                    $retorno = $EmbarcadorService->validarGet();
                    break;
                case self::OFERTA:
                    $OfertaService = new OfertaService($this->request);
                    $retorno = $OfertaService->validarGet();
                    break;
                default:
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }
        }
        return $retorno;
    }

    /**
     * Metodo para tratar os POSTS
     * @return array|null|string
     */
    private function post()
    {
        $retorno = null;
        if (in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_POST, true)) {
            switch ($this->request['rota']) {
                case self::USUARIOS:
                    $UsuariosService = new UsuariosService($this->request);
                    $UsuariosService->setDadosCorpoRequest($this->dadosRequest);
                    $retorno = $UsuariosService->validarPost();
                    break;
                case self::LANCE:
                    $LanceService = new LanceService($this->request);
                    $LanceService->setDadosCorpoRequest($this->dadosRequest);
                    $retorno = $LanceService->validarPost();
                    break;
                case self::TRANSPORTADOR:
                    $TransportadorService = new TransportadorService($this->request);
                    $TransportadorService->setDadosCorpoRequest($this->dadosRequest);
                    $retorno = $TransportadorService->validarPost();
                    break;
                case self::EMBARCADOR:
                    $EmbarcadorService = new EmbarcadorService($this->request);
                    $EmbarcadorService->setDadosCorpoRequest($this->dadosRequest);
                    $retorno = $EmbarcadorService->validarPost();
                    break;
                case self::OFERTA:
                    $OfertaService = new OfertaService($this->request);
                    $OfertaService->setDadosCorpoRequest($this->dadosRequest);
                    $retorno = $OfertaService->validarPost();
                    break;
                default:
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);
            }
            return $retorno;
        }
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);
    }

    /**
     * Metodo para tratar os PUTS
     * @return array|null|string
     */
    private function put()
    {
        $retorno = null;
        if (in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_PUT, true)) {
            switch ($this->request['rota']) {
                case self::USUARIOS:
                    $UsuariosService = new UsuariosService($this->request);
                    $UsuariosService->setDadosCorpoRequest($this->dadosRequest);
                    $retorno = $UsuariosService->validarPut();
                    break;
                default:
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);
            }
            return $retorno;
        }
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);
    }
}
