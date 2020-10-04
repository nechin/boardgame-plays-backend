<?php

namespace App\Service;

use App\Entity\BoardGame;
use DateTime;

class BoardGameService
{
    const GAME_PLAY_STATUS_LESS_HALF_YEAR = 0;
    const GAME_PLAY_STATUS_MORE_HALF_YEAR = 1;
    const GAME_PLAY_STATUS_MORE_THEN_YEAR = 2;

    private string $dateFormat = 'Y-m-d H:i:s';

    /**
     * @param BoardGame $game
     * @return string
     */
    private function getLastPlayDate(BoardGame $game): string
    {
        $lastPlayDate = '';

        $plays = $game->getPlays();
        if ($plays) {
            foreach ($plays as $play) {
                if (!$lastPlayDate || $lastPlayDate < $play->getDate()->getTimestamp()) {
                    $lastPlayDate = $play->getDate()->getTimestamp();
                }
            }
        }

        return $lastPlayDate ? date($this->dateFormat, $lastPlayDate) : '';
    }

    /**
     * @param string $lastPlayDate
     * @return int
     */
    private function getStatus(string $lastPlayDate): int
    {
        $time = $lastPlayDate ? DateTime::createFromFormat($this->dateFormat, $lastPlayDate)->getTimestamp() : 0;

        if (time() - 60 * 60 * 24 * 365 > $time) { // More then year
            return self::GAME_PLAY_STATUS_MORE_THEN_YEAR;
        } elseif (time() - 60 * 60 * 24 * 133 > $time) { // More then half year
            return self::GAME_PLAY_STATUS_MORE_HALF_YEAR;
        }

        return self::GAME_PLAY_STATUS_LESS_HALF_YEAR;
    }

    /**
     * @param BoardGame $game
     * @return array
     */
    public function getGameData(BoardGame $game): array
    {
        $lastPlayDate = $this->getLastPlayDate($game);

        return [
            'id' => $game->getId(),
            'title' => $game->getTitle(),
            'year' => $game->getYear(),
            'date' => $lastPlayDate,
            'status' => $this->getStatus($lastPlayDate)
        ];
    }
}
