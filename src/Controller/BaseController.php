<?php
/**
 * Created by PhpStorm.
 * User: thoma
 * Date: 29/04/2018
 * Time: 9:58 PM
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends Controller
{
    protected $navs, $imgs;

    /**
     * Initialize protected variables shared by all controllers.
     */
    protected function start()
    {
        //navigation options in the nav bar
        $this->navs = ["Home", "Register", "Sign In", "Log Out", "NASA Images"];
        // array of images (links) to be fetched from the database.
//        $this->imgs= array("https://ia.media-imdb.com/images/M/MV5BMjMxNjY2MDU1OV5BMl5BanBnXkFtZTgwNzY1MTUwNTM@._V1_SY1000_CR0,0,674,1000_AL_.jpg");

    }

    /**
     * @Route("/admin")
     * @return Response
     */
    public function admin()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }

}