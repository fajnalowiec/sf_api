<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\BaseApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\GameRepository;
use Symfony\Component\HttpFoundation\Response;

class GameController extends BaseApiController
{
    public function getMostLoved(
        Request $request,
        GameRepository $gameRepository
    ): JsonResponse
    {
        //no validation about min/max value
        $limit = $request->query->getInt('limit', 10);
        $games = $gameRepository->getMostLovedGames($limit);
        $result = [];
        foreach ($games as $game) {
            $result[] = ['game' => $game[0], 'lovedBy' => $game['lovesCount']];
        }

        return $this->json($result, Response::HTTP_OK);
    }

    public function getAll(
        Request $request,
        GameRepository $gameRepository
    ): JsonResponse
    {
        //no validation about min/max values
        $offset = $request->query->getInt('offset', 0);
        $limit = $request->query->getInt('limit', 10);

        $games = $gameRepository->getAll($offset, $limit);

        return $this->json($games, Response::HTTP_OK);
    }

}
