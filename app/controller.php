<?php

require_once 'env.php';
require 'model.php';

class Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new Model();
    }

    public function getUrl()
    {
        $hash =  str_replace('/', '', $_SERVER['REQUEST_URI']);
        if (empty($hash)) {
            return $this->getViewGerador();
        }
        $url = $this->verifyHashAndReturnUrl($hash);
        if (!empty($url)) {
            header("Location: $url");
            die();
        }
        return $this->getViewGerador();
    }

    public function insertUrl()
    {
        $body = json_decode(file_get_contents('php://input'));
        $this->validateRequest($body);
        $hash = $this->makeHash();
        $created =  $this->model->insertUrl($body->url, $hash);
        if (!empty($created)) {
            return $this->responseJson(['url' => getenv('APP_URL')  . '/' . $hash]);
        } else {
            $this->responseError('Não foi possível gerar a URL encurtada', 500);
        }
    }

    private function validateRequest(object $body): void
    {
        $url = $body->url;
        if (empty($url)) {
            $this->responseError('Envie a url que deseja encurtar, exemplo: {"url": "https://google.com.br"}.', 422);
        }
        if (strlen($url) > 255) {
            $this->responseError('A URL deve ter no máximo 255 caracteres', 422);
        }
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $this->responseError('A URL não é valida, exemplo de url válida: https://google.com.br', 422);
        }
    }


    private function getViewGerador()
    {
        return require_once('view.php');
    }

    public function invalidMethods()
    {
        return $this->responseError('Métodos não Habilitados', 405);
    }

    private function makeHash()
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $hash = '';
        for ($i = 0; $i < rand(1, 5); $i++) {
            $indice = mt_rand(0, strlen($caracteres) - 1);
            $hash .= $caracteres[$indice];
        };
        return empty($this->verifyHashAndReturnUrl($hash)) ? $hash : $this->makeHash();
    }

    #verifica se o hash é valido, consulta e retorna a url dele
    function verifyHashAndReturnUrl(string $hash)
    {
        if (preg_match('/^[a-zA-Z0-9]*$/', $hash) && strlen($hash) <= 5) {
            return $this->model->getUrlByHash($hash);
        } else {
            return false;
        }
    }

    private function responseError(string $msg, $statusCode = 500)
    {
        $erro = array('erro' => $msg);
        return $this->responseJson($erro, $statusCode);
    }

    private function responseJson(array $data, $statusCode = 200)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        http_response_code($statusCode);
        die();
    }
}
