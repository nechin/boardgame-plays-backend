<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200923191559 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE board_games (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, year INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plays (id INT AUTO_INCREMENT NOT NULL, board_game_id INT NOT NULL, date DATETIME NOT NULL, count SMALLINT NOT NULL, INDEX IDX_5E89DEBAAC91F10A (board_game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE plays ADD CONSTRAINT FK_5E89DEBAAC91F10A FOREIGN KEY (board_game_id) REFERENCES board_games (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plays DROP FOREIGN KEY FK_5E89DEBAAC91F10A');
        $this->addSql('DROP TABLE board_games');
        $this->addSql('DROP TABLE plays');
    }
}
