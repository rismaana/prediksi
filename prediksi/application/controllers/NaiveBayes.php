<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include ("libraries/autoload.php");
include ('libraries/phpspreadsheet/vendor/autoload.php');
use GroceryCrud\Core\GroceryCrud;
class NaiveBayes extends CI_Controller {
    var $footer = [];
    var $menu = [];
	function __construct() {
        parent::__construct();
        if($this->session->userdata('login')==NULL){
          redirect('home');
        }
        $database   = include ('database.php'); //config database Grocery
        $config     = include ('config.php'); //config library Grocery
        $this->crud = new GroceryCrud($config, $database); //initialize Grocery
    		$this->crud->unsetBootstrap();
    		$this->crud->unsetExport();
    		$this->crud->unsetPrint();
     
        $this->menu = array(
                        "navbar"=>array(
                                "menu"=>array(    
                                            array(
                                                "name"=>"Menu",
                                                "link"=>base_url()."naivebayes/process"
                                            ),
                                            array(
                                                "name"=>"Logout",
                                                "link"=>base_url()."auth/logout"
                                            )
                                )
                            )
                        );
	}
    public function index(){
        $var['menu'] = $this->menu;
        $var['module'] = "naivebayes/dashboard";
        $var['var_module'] = array();
        $var['content_title'] = "";
        $var['breadcrumb'] = array(
         "Dashboard"=>"active"
        );
        $this->load->view('main',$var);

    }
	public function process($page="dataset")
	{
    $var['menu'] = $this->menu;
    $var['module'] = "naivebayes/process";
    $var['var_module'] = array("page"=>$page);
    $var['breadcrumb'] = array(
    );
    $this->load->view('main',$var);
	}
  function dataset(){
    $var = array();
    $this->crud->unsetSearchColumns(['tugas', 'uas','uts','ketidakhadiran','ekskul','class']);
    $this->crud->setTable('dataset_risma');
		$this->crud->setSubject('Dataset');
    $output = $this->crud->render();
    if ($output->isJSONResponse) {
        header('Content-Type: application/json; charset=utf-8');
        echo $output->output;
        exit;
    }
    $var['menu'] = $this->menu;
    $var['footer'] = $this->footer;
    $var['module'] = "naivebayes/gc-dataset";
    $var['var_module'] = array();
		$var['gcrud'] = 1;
		$var['content_title'] = "Dataset";
		$var['breadcrumb'] = array(
			"Data History"=>""
		);
    $var['css_files']       = $output->css_files;
    $var['js_files']        = $output->js_files;
    $var['output']          = $output->output;
    $this->load->view('main', $var);
  }
}
  
