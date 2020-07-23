<?php

namespace App\Controller;

use App\Entity\Phone;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;


class PhoneController extends AbstractController
{

    /**
     * @Route("/api/add_phones", name="api_post", methods={"POST"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addPhone(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager)
    {
        try {
            $phone = $request->getContent();
            $phone = $serializer->deserialize($phone, Phone::class, 'json', []);
            $manager->persist($phone);
            $manager->flush();
            return $this->json($phone, 201, [], []);
        }
        catch (NotEncodableValueException $e)
        {
            return $this->json(array('status'=>400, 'message'=>$e->getMessage(),400));
        }
    }
}
