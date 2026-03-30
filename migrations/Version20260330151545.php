<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260330151545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'insert sample data';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE players AUTO_INCREMENT = 1;');
        $this->addSql('ALTER TABLE games AUTO_INCREMENT = 1;');
        $this->addSql("
            INSERT INTO players (name)
            VALUES
              ('fajnalowiec'),
              ('mazzi'),
              ('zywoo');
        ");
        $this->addSql("
            INSERT INTO games (name)
            VALUES
              ('Counter Strike'),
              ('Civilization 6'),
              ('Resident Evil Requiem');
        ");
        $this->addSql("
            INSERT INTO loved_games (game_id, player_id)
            VALUES
              (2, 1),
              (2, 2),
              (3, 3);
        ");

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM loved_games');
        $this->addSql('DELETE FROM players');
        $this->addSql('DELETE FROM games');
    }
}
