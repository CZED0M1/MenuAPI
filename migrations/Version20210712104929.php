<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210712104929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_9EF68E9CB1E7706E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__meal AS SELECT id, restaurant_id, name, price FROM meal');
        $this->addSql('DROP TABLE meal');
        $this->addSql('CREATE TABLE meal (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, restaurant_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, price INTEGER NOT NULL, CONSTRAINT FK_9EF68E9CB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO meal (id, restaurant_id, name, price) SELECT id, restaurant_id, name, price FROM __temp__meal');
        $this->addSql('DROP TABLE __temp__meal');
        $this->addSql('CREATE INDEX IDX_9EF68E9CB1E7706E ON meal (restaurant_id)');
        $this->addSql('DROP INDEX IDX_7D053A93B1E7706E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__menu AS SELECT id, restaurant_id, date, meals FROM menu');
        $this->addSql('DROP TABLE menu');
        $this->addSql('CREATE TABLE menu (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, restaurant_id INTEGER DEFAULT NULL, meals CLOB NOT NULL COLLATE BINARY --(DC2Type:json_array)
        , date DATE DEFAULT NULL --(DC2Type:date_immutable)
        , CONSTRAINT FK_7D053A93B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO menu (id, restaurant_id, date, meals) SELECT id, restaurant_id, date, meals FROM __temp__menu');
        $this->addSql('DROP TABLE __temp__menu');
        $this->addSql('CREATE INDEX IDX_7D053A93B1E7706E ON menu (restaurant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_9EF68E9CB1E7706E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__meal AS SELECT id, restaurant_id, name, price FROM meal');
        $this->addSql('DROP TABLE meal');
        $this->addSql('CREATE TABLE meal (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, restaurant_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, price INTEGER NOT NULL)');
        $this->addSql('INSERT INTO meal (id, restaurant_id, name, price) SELECT id, restaurant_id, name, price FROM __temp__meal');
        $this->addSql('DROP TABLE __temp__meal');
        $this->addSql('CREATE INDEX IDX_9EF68E9CB1E7706E ON meal (restaurant_id)');
        $this->addSql('DROP INDEX IDX_7D053A93B1E7706E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__menu AS SELECT id, restaurant_id, meals, date FROM menu');
        $this->addSql('DROP TABLE menu');
        $this->addSql('CREATE TABLE menu (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, restaurant_id INTEGER DEFAULT NULL, meals CLOB NOT NULL --(DC2Type:json_array)
        , date DATE DEFAULT NULL)');
        $this->addSql('INSERT INTO menu (id, restaurant_id, meals, date) SELECT id, restaurant_id, meals, date FROM __temp__menu');
        $this->addSql('DROP TABLE __temp__menu');
        $this->addSql('CREATE INDEX IDX_7D053A93B1E7706E ON menu (restaurant_id)');
    }
}
