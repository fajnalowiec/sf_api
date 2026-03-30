<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\BaseApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\PlayerRepository;
use App\Repository\LovedGameRepository;
use Symfony\Component\HttpFoundation\Response;

class PlayerController extends BaseApiController
{

    public function getLovedGames(
        int $id,
        PlayerRepository $playerRepository,
        LovedGameRepository $lovedGameRepository
    ): JsonResponse
    {

        $player = $playerRepository->findOneById($id);

        if (is_null($player)) {
            return $this->prepareErrorResponse('Player not found', Response::HTTP_NOT_FOUND);
        }

        $lovedGames = $lovedGameRepository->findByPlayer($player);

        $games = [];
        foreach ($lovedGames as $lovedGame) {
            $games[] = ['loved_game_id' => $lovedGame->getId(), 'game' => $lovedGame->getGame()];
        }

        return $this->json($games, Response::HTTP_OK);
    }

}