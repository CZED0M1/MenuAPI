<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210712085716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, restaurant VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, meals CLOB DEFAULT NULL --(DC2Type:object)
        )');
        $this->addSql('DROP TABLE meal_dg_tmp');
        $this->addSql('DROP INDEX IDX_9EF68E9CB1E7706E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__meal AS SELECT id, restaurant_id, name, price FROM meal');
        $this->addSql('DROP TABLE meal');
        $this->addSql('CREATE TABLE meal (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, restaurant_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, price INTEGER NOT NULL, CONSTRAINT FK_9EF68E9CB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO meal (id, restaurant_id, name, price) SELECT id, restaurant_id, name, price FROM __temp__meal');
        $this->addSql('DROP TABLE __temp__meal');
        $this->addSql('CREATE INDEX IDX_9EF68E9CB1E7706E ON meal (restaurant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE meal_dg_tmp (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, price INTEGER NOT NULL, restaurant VARCHAR(255) NOT NULL COLLATE BINARY, restaurant_id INTEGER DEFAULT NULL)');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP INDEX IDX_9EF68E9CB1E7706E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__meal AS SELECT id, restaurant_id, name, price FROM meal');
        $this->addSql('DROP TABLE meal');
        $this->addSql('CREATE TABLE meal (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, restaurant_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, price INTEGER NOT NULL)');
        $this->addSql('INSERT INTO meal (id, restaurant_id, name, price) SELECT id, restaurant_id, name, price FROM __temp__meal');
        $this->addSql('DROP TABLE __temp__meal');
        $this->addSql('CREATE INDEX IDX_9EF68E9CB1E7706E ON meal (restaurant_id)');
    }
}
