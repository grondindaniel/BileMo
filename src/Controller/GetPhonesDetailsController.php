<?php

namespace App\Controller;

use App\Repository\PhoneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class GetPhonesDetailsController extends AbstractController
{
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
