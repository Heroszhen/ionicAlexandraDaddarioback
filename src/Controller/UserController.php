<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

/**
 * Class UserController
 * @package App\Controller
 *
 * @Route("/api")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/login",methods={"POST"})
     */
    public function index(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
        $data=json_decode($request->getContent(),true);
    	$response["status"] = 0;

        $user = $em->getRepository(User::class)->findOneBy([
            "email" => $data["email"],
            "password" => md5($data["password"])
        ]);
        if(!empty((array)$user)){
            $response["status"] = 1;
            $user->setPassword(null);
            $user->setCreated(null);
            $response["user"] = $user;
        }
        return $this->json($response);
    }
}
