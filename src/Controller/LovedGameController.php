<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\BaseApiController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\LovedGame;
use App\Repository\GameRepository;
use App\Repository\PlayerRepository;
use App\Repository\LovedGameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class LovedGameController extends BaseApiController
{

    public function create(
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        GameRepository $gameRepository,
        PlayerRepository $playerRepository
    ): JsonResponse
    {

        //invalid json body in request
        try {
            $data = $serializer->decode($request->getContent(), 'json');
        } catch (NotEncodableValueException $e) {
            return $this->prepareErrorResponse('Invalid json body');
        }

        //no full validation for id values (should be int > 0)
        if (!isset($data['game_id'])) {
            return $this->prepareErrorResponse('Missing field: game_id');
        }

        if (!isset($data['player_id'])) {
            return $this->prepareErrorResponse('Missing field: player_id');
        }

        //take data from db
        $game = $gameRepository->findOneById((int) $data['game_id']);
        if (is_null($game)) {
            return $this->prepareErrorResponse('Game not found');
        }

        $player = $playerRepository->findOneById((int) $data['player_id']);
        if (is_null($player)) {
            return $this->prepareErrorResponse('Player not found');
        }

        $lovedGame = new LovedGame();
        $lovedGame->setGame($game);
        $lovedGame->setPlayer($player);

        //no further validation is needed for this object
        try {
            $em->persist($lovedGame);
            $em->flush();
        } catch (UniqueConstraintViolationException $e) {
            return $this->prepareErrorResponse('This player already has this game set as loved', Response::HTTP_CONFLICT);
        }

        return $this->json(['id' => $lovedGame->getId()], Response::HTTP_CREATED);
    }

    public function delete(
        int $id,
        EntityManagerInterface $em,
        LovedGameRepository $lovedGameRepository
    ): Response
    {

        $lovedGame = $lovedGameRepository->findOneById($id);

        if (is_null($lovedGame)) {
            return $this->prepareErrorResponse('Loved game not found', Response::HTTP_NOT_FOUND);
        }

        $em->remove($lovedGame);
        $em->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

}