<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class UserController extends AbstractController
{
    /**
     * @Route ("/api/register", name = "api_register", methods = {"POST"})
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Request $request
     * @param EntityManagerInterface $om
     * @param SerializerInterface $serializer
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function register(UserPasswordEncoderInterface $passwordEncoder, Request $request, EntityManagerInterface $om, SerializerInterface $serializer)
    {
        try {
            $client = $request->getContent();
            $client = $serializer->deserialize($client, User::class, 'json');
            $om->persist($client);
            $om->flush();
            return $this->json(['result' => 'User register with success']);
        }catch (NotEncodableValueException $e)
        {
            return $this->json(array('status'=>400, 'message'=>$e->getMessage()),400);
        }
    }


    /**
     * @OA\Post(path="/login", @OA\Response(response="200", description="Successful authentication", @OA\JsonContent(type="string")))
     * @Route("/login", name="api_login", methods={"POST"})
     */
    public function login()
    {
        return $this->json(['result' => 'ok']);
    }
}
