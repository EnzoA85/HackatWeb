<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230324102306 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hackathon CHANGE codePostal codePostal VARCHAR(5) DEFAULT NULL, CHANGE dateFin dateFin DATE NOT NULL, CHANGE dateLimite dateLimite DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hackathon CHANGE dateFin dateFin DATE DEFAULT NULL, CHANGE codePostal codePostal CHAR(5) DEFAULT NULL, CHANGE dateLimite dateLimite DATE DEFAULT NULL');
    }
}
