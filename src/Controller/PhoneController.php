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
use OpenApi\Annotations as OA;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;


class PhoneController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

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

    /**
     * @OA\GET(path="/api/v1/phones", @OA\Response(response="200", description="All smartphones"))
     * @Route("/api/v1/phones", name="api_get", methods={"GET"})
     * @param PhoneRepository $PhoneRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param CacheInterface $cache
     * @return Response
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function getPhone(PhoneRepository $PhoneRepository, PaginatorInterface $paginator, Request $request, CacheInterface $cache)
    {
        $phones =$PhoneRepository->findAll();
        $phones = $paginator->paginate($phones, $request->get('page', 1), 3);
        $json = $this->serializer->serialize($phones, 'json', SerializationContext::create()->setGroups(array('Default', 'terms' => array('listPhones'))));
        $res = $cache->get('resultat', function (ItemInterface $item) use ($json, $phones){
            $item->expiresAfter(5);
            return new Response($json, 200, array('Content-Type' => 'application/json'), $phones);
        });
        return $res;
    }


    /**
     * @OA\GET(path="/api/v1/phones/{id}", @OA\Response(response="200", description="Get detail about a specific smartphone"))
     * @Route("/api/v1/phones/{id}", name="api_get_detail", methods={"GET"})
     * @param PhoneRepository $smartphoneRepository
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getPhoneDetail(PhoneRepository $smartphoneRepository, $id)
    {
        return $this->json($smartphoneRepository->findOneBy(array('id'=>$id)), 200,[],[]);
    }
}
