<?php

namespace App\Controller;

use App\Entity\Phone;
use App\Repository\PhoneRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
//use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;



class PhoneController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/api/add_phones", name="api_post", methods={"POST"})
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

    /**
     * @OA\GET(path="/api/v1/phones", @OA\Response(response="200", description="All smartphones"))
     * @Route("/api/v1/phones", name="api_get", methods={"GET"})
     */
    public function getPhone(PhoneRepository $PhoneRepository, PaginatorInterface $paginator)
    {
        $phones =$PhoneRepository->findAll();
        $json = $this->serializer->serialize($phones, 'json', SerializationContext::create()->setGroups(array('Default', 'items' => array('list'))));

        return new Response($json, 200, array('Content-Type' => 'application/json'));

    }

    /**
     * @OA\GET(path="/api/v1/phones/{id}", @OA\Response(response="200", description="Get detail about a specific smartphone"))
     * @Route("/api/v1/phones/{id}", name="api_get_detail", methods={"GET"})
     */
    public function getPhoneDetail(PhoneRepository $smartphoneRepository, $id)
    {
        return $this->json($smartphoneRepository->findOneBy(array('id'=>$id)), 200,[],[]);
    }
}
