<?php

namespace App\Controller;

use App\Entity\District;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as FOSRest;

/**
 * District controller.
 *
 * @Route("/districts")
 */
class DistrictController extends Controller
{
    /**
     * Lists all Districts.
     * @FOSRest\Get
     *
     *
     * @return JsonResponse
     */
    public function getAll()
    {
        $repository = $this->getDoctrine()->getRepository(District::class);
        $districts = $repository->findAll();

        return $this->json($districts,Response::HTTP_OK);
    }

    /**
     * Filter Districts.
     * @FOSRest\Get("/filter")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getFiltered(Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(District::class);
        $districts = $repository->findByFilter($request->query->all());

        return $this->json($districts,Response::HTTP_OK);
    }

    /**
     * Sort Districts.
     * @FOSRest\Get("/sort")
     *
     * @FOSRest\QueryParam("type")
     * @FOSRest\QueryParam("direction")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getSorted(Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(District::class);
        $districts = $repository->sortByColumn(
            $request->query->get("type"),
            $request->query->get("direction")
        );

        return $this->json($districts,Response::HTTP_OK);
    }

    /**
     * Delete District.
     * @FOSRest\Get("/{id}")
     *
     * @param $id
     * @return JsonResponse
     */

    public function getOne($id)
    {
        $em = $this->getDoctrine()->getManager();
        $district = $em->getRepository(District::class)->find($id);

        return $this->json($district,Response::HTTP_OK);
    }

    /**
     * Create District.
     * @FOSRest\Post
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function post(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $district = new District();
        $district->setMiasto($request->get('miasto'));
        $district->setDzielnica($request->get('dzielnica'));
        $district->setLudnosc($request->get('ludnosc'));
        $district->setPowierzchnia($request->get('powierzchnia'));

        $em->persist($district);
        $em->flush();

        return $this->json($district,Response::HTTP_CREATED);

    }

    /**
     * Delete District.
     * @FOSRest\Delete("/{id}")
     *
     * @param $id
     * @return JsonResponse
     */

    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $district = $em->getRepository(District::class)->find($id);

        $em->remove($district);
        $em->flush();

        return new JsonResponse(null,Response::HTTP_NO_CONTENT);
    }

    /**
     * Update District.
     * @FOSRest\Put("/{id}")
     *
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */

    public function update($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $district = $em->getRepository(District::class)->find($id);

        $district->setMiasto($request->get('miasto'));
        $district->setDzielnica($request->get('dzielnica'));
        $district->setLudnosc($request->get('ludnosc'));
        $district->setPowierzchnia($request->get('powierzchnia'));

        $em->flush();

        return new JsonResponse($district,Response::HTTP_OK);
    }
}