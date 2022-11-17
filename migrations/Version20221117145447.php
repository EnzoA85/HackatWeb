<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221117145447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EBAACE5BD');
        $this->addSql('DROP INDEX IDX_B26681EBAACE5BD ON evenement');
        $this->addSql('ALTER TABLE evenement CHANGE id_hackathon_id hackathon_id INT NOT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E996D90CF FOREIGN KEY (hackathon_id) REFERENCES hackathon (id)');
        $this->addSql('CREATE INDEX IDX_B26681E996D90CF ON evenement (hackathon_id)');
        $this->addSql('ALTER TABLE utilisateur ADD roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B35126AC48 ON utilisateur (mail)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E996D90CF');
        $this->addSql('DROP INDEX IDX_B26681E996D90CF ON evenement');
        $this->addSql('ALTER TABLE evenement CHANGE hackathon_id id_hackathon_id INT NOT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EBAACE5BD FOREIGN KEY (id_hackathon_id) REFERENCES hackathon (id)');
        $this->addSql('CREATE INDEX IDX_B26681EBAACE5BD ON evenement (id_hackathon_id)');
        $this->addSql('DROP INDEX UNIQ_1D1C63B35126AC48 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP roles');
    }
}
