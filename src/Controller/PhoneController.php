<?php

namespace App\Controller;

use App\Entity\Phone;
use App\Repository\PhoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;


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

    /**
     * @OA\GET(path="/api/v1/phones", @OA\Response(response="200", description="All smartphones"))
     * @Route("/api/v1/phones", name="api_get", methods={"GET"})
     */
    public function getPhone(PhoneRepository $PhoneRepository)
    {
        return $this->json($PhoneRepository->findlistPhones(), 200,[],[]);
    }

    /**
     * @OA\GET(path="/api/v1/phones/{id}", @OA\Response(response="200", description="Get detail about a specific smartphone"))
     * @Route("/api/phones/{id}", name="api_get_detail", methods={"GET"})
     */
    public function getPhoneDetail(PhoneRepository $smartphoneRepository, $id)
    {
        return $this->json($smartphoneRepository->findOneBy(array('id'=>$id)), 200,[],[]);
    }
}
