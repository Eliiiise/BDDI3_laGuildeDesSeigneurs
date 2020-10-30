<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Character;
use App\Service\CharacterServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class CharacterController extends AbstractController
{
    private $characterService;

    public function __construct(CharacterServiceInterface $characterService)
    {
        $this->characterService = $characterService;
    }


    /**
     * @Route("/character",
     *     name="character_redirect_index",
     *     methods={"GET","HEAD"}
     *     )
     */
    public function redirectIndex()
    {
        return $this->redirectToRoute('character_index');
    }

    /**
     * @Route("/character/index",
     *     name="character_index",
     *     methods={"GET","HEAD"}
     *     )
     */
    public function index(): Response
    {
        $this->denyAccessUnLessGranted('characterIndex', null);

        $characters = $this->characterService->getAll();

        return new JsonResponse($characters);
    }

    /**
     * @Route("/character/display/{identifier}",
     *      name="character_display",
     *      requirements={"identifier": "^[a-z0-9]{40}$"},
     *      methods={"GET","HEAD"}
     * )
     */
    public function display(Character $character) {
        $this->denyAccessUnlessGranted('characterDisplay', $character);

        return new JsonResponse($character->toArray());
    }

    /**
     * @Route("/character/create",
     *      name="character_create",
     *      methods={"POST", "HEAD"})
     */
    public function create() {
        $this->denyAccessUnlessGranted('characterCreate', null);

        $character = $this->characterService->create();
        return new JsonResponse($character->toArray());
    }
}
