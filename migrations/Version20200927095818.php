<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200927095818 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE board_games ADD title VARCHAR(255) NOT NULL, ADD description LONGTEXT DEFAULT NULL, ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE plays RENAME INDEX idx_5e89debaac91f10a TO IDX_30E41C47AC91F10A');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE board_games DROP title, DROP description, DROP created_at');
        $this->addSql('ALTER TABLE plays RENAME INDEX idx_30e41c47ac91f10a TO IDX_5E89DEBAAC91F10A');
    }
}
