<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241116161158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE event_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE room_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE slot_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE event (id INT NOT NULL, name VARCHAR(255) NOT NULL, host_name VARCHAR(255) NOT NULL, orga_mail VARCHAR(255) NOT NULL, orga_tel VARCHAR(255) NOT NULL, orga_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE room (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE slot (id INT NOT NULL, room_id INT DEFAULT NULL, event_id INT DEFAULT NULL, date DATE NOT NULL, attendees SMALLINT NOT NULL, start_hour VARCHAR(255) NOT NULL, end_hour VARCHAR(255) NOT NULL, room_configuration VARCHAR(255) NOT NULL, configuration_size SMALLINT NOT NULL, configuration_quantity SMALLINT NOT NULL, room_configuration_precision VARCHAR(255) NOT NULL, host_table BOOLEAN NOT NULL, paperboard SMALLINT NOT NULL, chair_sup SMALLINT NOT NULL, table_sup SMALLINT NOT NULL, pen BOOLEAN NOT NULL, paper BOOLEAN NOT NULL, scissors BOOLEAN NOT NULL, scotch BOOLEAN NOT NULL, post_it_xl SMALLINT NOT NULL, paper_a1 BOOLEAN NOT NULL, bloc_note BOOLEAN NOT NULL, gomette BOOLEAN NOT NULL, post_it BOOLEAN NOT NULL, pause_am SMALLINT NOT NULL, pause_pm SMALLINT NOT NULL, pause_amcontent VARCHAR(255) NOT NULL, pause_pmcontent VARCHAR(255) NOT NULL, meal SMALLINT NOT NULL, morning_coffee SMALLINT NOT NULL, afternoon_coffee SMALLINT NOT NULL, coktail SMALLINT NOT NULL, vegetarian SMALLINT NOT NULL, gluten_free SMALLINT NOT NULL, meal_precision VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AC0E206754177093 ON slot (room_id)');
        $this->addSql('CREATE INDEX IDX_AC0E206771F7E88B ON slot (event_id)');
        $this->addSql('ALTER TABLE slot ADD CONSTRAINT FK_AC0E206754177093 FOREIGN KEY (room_id) REFERENCES room (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE slot ADD CONSTRAINT FK_AC0E206771F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE event_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE room_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE slot_id_seq CASCADE');
        $this->addSql('ALTER TABLE slot DROP CONSTRAINT FK_AC0E206754177093');
        $this->addSql('ALTER TABLE slot DROP CONSTRAINT FK_AC0E206771F7E88B');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE slot');
    }
}
