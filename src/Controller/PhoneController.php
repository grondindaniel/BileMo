<?php

namespace App\Controller;

use App\Entity\Phone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class PhoneController extends AbstractController
{
    /**
     * @Route("/api/add_phones", name="api_post", methods={"POST"})
     */
    public function addPhone(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager)
    {
        $phone = $request->getContent();
        $phone = $serializer->deserialize($phone, Phone::class, 'json', []);

        $manager->persist($phone);
        $manager->flush();

        return $this->json($phone, 201, [], []);

    }
}
