<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210705234304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meal ADD COLUMN restid INTEGER DEFAULT 2');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__meal AS SELECT id, name, restaurant, price FROM meal');
        $this->addSql('DROP TABLE meal');
        $this->addSql('CREATE TABLE meal (id INTEGER PRIMARY KEY AUTOINCREMENT , name VARCHAR(255) , restaurant VARCHAR(255) , price INTEGER )');
        $this->addSql('INSERT INTO meal (id, name, restaurant, price) SELECT id, name, restaurant, price FROM __temp__meal');
        $this->addSql('DROP TABLE __temp__meal');
    }
}
