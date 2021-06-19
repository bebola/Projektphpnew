<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210619015111 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Galleries ADD code VARCHAR(64) NOT NULL');
        $this->addSql('ALTER TABLE Photos CHANGE title title VARCHAR(15) NOT NULL, CHANGE text text VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE Photos RENAME INDEX idx_fdae5ef12469de2 TO IDX_FDAE5EF4E7AF8F');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Galleries DROP code');
        $this->addSql('ALTER TABLE Photos CHANGE title title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE text text VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE Photos RENAME INDEX idx_fdae5ef4e7af8f TO IDX_FDAE5EF12469DE2');
    }
}
