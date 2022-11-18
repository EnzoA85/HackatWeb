<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221118132127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conference DROP libelle, DROP date, DROP duree, DROP heure, DROP salle, DROP type, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE conference ADD CONSTRAINT FK_911533C8BF396750 FOREIGN KEY (id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE initiation DROP libelle, DROP date, DROP duree, DROP heure, DROP salle, DROP type, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE initiation ADD CONSTRAINT FK_EDC7AE6EBF396750 FOREIGN KEY (id) REFERENCES evenement (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conference DROP FOREIGN KEY FK_911533C8BF396750');
        $this->addSql('ALTER TABLE conference ADD libelle VARCHAR(255) DEFAULT NULL, ADD date DATE DEFAULT NULL, ADD duree INT DEFAULT NULL, ADD heure TIME DEFAULT NULL, ADD salle VARCHAR(255) DEFAULT NULL, ADD type VARCHAR(255) NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE initiation DROP FOREIGN KEY FK_EDC7AE6EBF396750');
        $this->addSql('ALTER TABLE initiation ADD libelle VARCHAR(255) DEFAULT NULL, ADD date DATE DEFAULT NULL, ADD duree INT DEFAULT NULL, ADD heure TIME DEFAULT NULL, ADD salle VARCHAR(255) DEFAULT NULL, ADD type VARCHAR(255) NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
