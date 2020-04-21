<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200420231253 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE country (country_id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL, country VARCHAR(50) NOT NULL, last_update DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(country_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (city_id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL, country_id SMALLINT UNSIGNED DEFAULT NULL, city VARCHAR(50) NOT NULL, last_update DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX idx_fk_country_id (country_id), PRIMARY KEY(city_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE address (address_id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL, city_id SMALLINT UNSIGNED DEFAULT NULL, address VARCHAR(50) NOT NULL, address2 VARCHAR(50) DEFAULT NULL, district VARCHAR(20) NOT NULL, postal_code VARCHAR(10) DEFAULT NULL, phone VARCHAR(20) NOT NULL, last_update DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX idx_fk_city_id (city_id), PRIMARY KEY(address_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234F92F3E70 FOREIGN KEY (country_id) REFERENCES country (country_id)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F818BAC62AF FOREIGN KEY (city_id) REFERENCES city (city_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234F92F3E70');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F818BAC62AF');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE address');
    }
}
