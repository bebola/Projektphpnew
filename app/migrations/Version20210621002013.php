<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210621002013 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Photos CHANGE title title VARCHAR(255) NOT NULL, CHANGE filename filename VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE comments ADD photos_id INT NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A301EC62 FOREIGN KEY (photos_id) REFERENCES Photos (id)');
        $this->addSql('CREATE INDEX IDX_5F9E962A301EC62 ON comments (photos_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Photos CHANGE title title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE filename filename VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A301EC62');
        $this->addSql('DROP INDEX IDX_5F9E962A301EC62 ON comments');
        $this->addSql('ALTER TABLE comments DROP photos_id, DROP created_at, DROP updated_at');
    }
}
