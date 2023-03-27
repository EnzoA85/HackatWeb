<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230313103518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur_hackathon (utilisateur_id INT NOT NULL, hackathon_id INT NOT NULL, INDEX IDX_EB940363FB88E14F (utilisateur_id), INDEX IDX_EB940363996D90CF (hackathon_id), PRIMARY KEY(utilisateur_id, hackathon_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur_hackathon ADD CONSTRAINT FK_EB940363FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_hackathon ADD CONSTRAINT FK_EB940363996D90CF FOREIGN KEY (hackathon_id) REFERENCES hackathon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervenant DROP mail');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur_hackathon DROP FOREIGN KEY FK_EB940363FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_hackathon DROP FOREIGN KEY FK_EB940363996D90CF');
        $this->addSql('DROP TABLE utilisateur_hackathon');
        $this->addSql('ALTER TABLE intervenant ADD mail VARCHAR(128) DEFAULT NULL');
    }
}
