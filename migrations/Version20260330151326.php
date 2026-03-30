<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260330151326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'init db';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE games (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, UNIQUE INDEX unique_game (name), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE loved_games (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, player_id INT NOT NULL, INDEX IDX_B137F096E48FD905 (game_id), INDEX IDX_B137F09699E6F5DF (player_id), UNIQUE INDEX unique_player_game (game_id, player_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE players (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, UNIQUE INDEX unique_player (name), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE loved_games ADD CONSTRAINT FK_B137F096E48FD905 FOREIGN KEY (game_id) REFERENCES games (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE loved_games ADD CONSTRAINT FK_B137F09699E6F5DF FOREIGN KEY (player_id) REFERENCES players (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loved_games DROP FOREIGN KEY FK_B137F096E48FD905');
        $this->addSql('ALTER TABLE loved_games DROP FOREIGN KEY FK_B137F09699E6F5DF');
        $this->addSql('DROP TABLE games');
        $this->addSql('DROP TABLE loved_games');
        $this->addSql('DROP TABLE players');
    }
}
