<?php namespace App\Controllers;

use CodeIgniter\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class EvalFormController extends BaseController
{
    public function __construct()
 {
     
     helper('url'); 
     $this->session = session();
 }

 /**
 * Controller method for displaying the landing page (base url)
 * 
 * @return View The view displaying the landing page
 */
    public function index()
    {
        return view('landingPage');
    }

}