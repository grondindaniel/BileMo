<?php

namespace App\Controller;

use App\Repository\PhoneRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use OpenApi\Annotations as OA;

class GetPhonesController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
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
}
