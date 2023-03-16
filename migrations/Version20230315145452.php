<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230315145452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE commune_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE hopital_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE medecin_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE specialite_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE commune (id INT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE hopital (id INT NOT NULL, commune_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, latitude VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8718F2C131A4F72 ON hopital (commune_id)');
        $this->addSql('CREATE TABLE hopital_specialite (hopital_id INT NOT NULL, specialite_id INT NOT NULL, PRIMARY KEY(hopital_id, specialite_id))');
        $this->addSql('CREATE INDEX IDX_2B288F06CC0FBF92 ON hopital_specialite (hopital_id)');
        $this->addSql('CREATE INDEX IDX_2B288F062195E0F0 ON hopital_specialite (specialite_id)');
        $this->addSql('CREATE TABLE medecin (id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE medecin_specialite (medecin_id INT NOT NULL, specialite_id INT NOT NULL, PRIMARY KEY(medecin_id, specialite_id))');
        $this->addSql('CREATE INDEX IDX_3F5A311B4F31A84 ON medecin_specialite (medecin_id)');
        $this->addSql('CREATE INDEX IDX_3F5A311B2195E0F0 ON medecin_specialite (specialite_id)');
        $this->addSql('CREATE TABLE specialite (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE utilisateur (id UUID NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3F85E0677 ON utilisateur (username)');
        $this->addSql('COMMENT ON COLUMN utilisateur.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE hopital ADD CONSTRAINT FK_8718F2C131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hopital_specialite ADD CONSTRAINT FK_2B288F06CC0FBF92 FOREIGN KEY (hopital_id) REFERENCES hopital (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hopital_specialite ADD CONSTRAINT FK_2B288F062195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE medecin_specialite ADD CONSTRAINT FK_3F5A311B4F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE medecin_specialite ADD CONSTRAINT FK_3F5A311B2195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE commune_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE hopital_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE medecin_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE specialite_id_seq CASCADE');
        $this->addSql('ALTER TABLE hopital DROP CONSTRAINT FK_8718F2C131A4F72');
        $this->addSql('ALTER TABLE hopital_specialite DROP CONSTRAINT FK_2B288F06CC0FBF92');
        $this->addSql('ALTER TABLE hopital_specialite DROP CONSTRAINT FK_2B288F062195E0F0');
        $this->addSql('ALTER TABLE medecin_specialite DROP CONSTRAINT FK_3F5A311B4F31A84');
        $this->addSql('ALTER TABLE medecin_specialite DROP CONSTRAINT FK_3F5A311B2195E0F0');
        $this->addSql('DROP TABLE commune');
        $this->addSql('DROP TABLE hopital');
        $this->addSql('DROP TABLE hopital_specialite');
        $this->addSql('DROP TABLE medecin');
        $this->addSql('DROP TABLE medecin_specialite');
        $this->addSql('DROP TABLE specialite');
        $this->addSql('DROP TABLE utilisateur');
    }
}
