<?php
namespace portal\modules;
use portal\modules\DataBase;
use portal\modules\Pages;
use portal\modules\Auth;
use portal\modules\Session;

class Router
{
    public static $instance;
    private $roles;
    private $pages;
    private $url;
    private $db;
    private $session;

    function __construct(){
        $this->pages = Pages::getInstance();
        $this->db = DataBase::getInstance();
        $this->roles = Role::getInstance();
        $this->session = Session::getInstance(); 
        $auth = Auth::getInstance();

        if($_GET){
            $this->url = explode('/',str_replace(array('?'),'/',$_SERVER['REQUEST_URI']));
            array_pop($this->url);
            $this->url = implode('/', $this->url);
        }else{
            $this->url = $_SERVER['REQUEST_URI'];
        }

        $this->routeRequest();
    }

    public function routeRequest()
    {
        if($this->pages->get($this->url) == false){
            include $_SERVER['DOCUMENT_ROOT'] . $this->pages->get('/404')['location'];
        }else{
            if($this->pages->get($this->url)['roles'] == null){
                include $_SERVER['DOCUMENT_ROOT'] . $this->pages->get($this->url)['location'];
            }elseif(in_array($this->session->get('role'), json_decode($this->pages->get($this->url)['roles'], true))){
                    include $_SERVER['DOCUMENT_ROOT'] . $this->pages->get($this->url)['location'];   
            }else{
                include $_SERVER['DOCUMENT_ROOT'] . $this->pages->get('/404')['location'];
            }
        }

    }

    public static function getInstance() {
        return 
            self::$instance===null
                ? self::$instance = new self() 
                : self::$instance;
      }
}
