<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221114102138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6996D90CF');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6FB88E14F');
        $this->addSql('DROP INDEX IDX_5E90F6D6996D90CF ON inscription');
        $this->addSql('DROP INDEX IDX_5E90F6D6FB88E14F ON inscription');
        $this->addSql('ALTER TABLE inscription ADD idHackathon INT NOT NULL, ADD idUtilisateur INT NOT NULL, DROP utilisateur_id, DROP hackathon_id');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D677D0DD19 FOREIGN KEY (idHackathon) REFERENCES hackathon (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D65D419CCB FOREIGN KEY (idUtilisateur) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D677D0DD19 ON inscription (idHackathon)');
        $this->addSql('CREATE INDEX IDX_5E90F6D65D419CCB ON inscription (idUtilisateur)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D677D0DD19');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D65D419CCB');
        $this->addSql('DROP INDEX IDX_5E90F6D677D0DD19 ON inscription');
        $this->addSql('DROP INDEX IDX_5E90F6D65D419CCB ON inscription');
        $this->addSql('ALTER TABLE inscription ADD utilisateur_id INT NOT NULL, ADD hackathon_id INT NOT NULL, DROP idHackathon, DROP idUtilisateur');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6996D90CF FOREIGN KEY (hackathon_id) REFERENCES hackathon (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D6996D90CF ON inscription (hackathon_id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D6FB88E14F ON inscription (utilisateur_id)');
    }
}
