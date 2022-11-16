<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221116085439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conférence (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, duree INT DEFAULT NULL, heure TIME DEFAULT NULL, salle VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, theme VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, id_hackathon_id INT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, duree INT DEFAULT NULL, heure TIME DEFAULT NULL, salle VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_B26681EBAACE5BD (id_hackathon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE initiation (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, duree INT DEFAULT NULL, heure TIME DEFAULT NULL, salle VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, nb_place_limite INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EBAACE5BD FOREIGN KEY (id_hackathon_id) REFERENCES hackathon (id)');
        $this->addSql('DROP INDEX UNIQ_1D1C63B35126AC48 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP roles');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EBAACE5BD');
        $this->addSql('DROP TABLE conférence');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE initiation');
        $this->addSql('ALTER TABLE utilisateur ADD roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B35126AC48 ON utilisateur (mail)');
    }
}
