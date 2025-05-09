<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240819072623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, terrain_id INT NOT NULL, user_id INT NOT NULL, creneau VARCHAR(255) NOT NULL, date DATE NOT NULL, INDEX IDX_4DA2398A2D8B41 (terrain_id), INDEX IDX_4DA239A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA2398A2D8B41 FOREIGN KEY (terrain_id) REFERENCES terrains (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE avis CHANGE enable enable TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE complexes ADD proprietaire_id INT NOT NULL, CHANGE enable enable TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE complexes ADD CONSTRAINT FK_B03120CD76C50E4A FOREIGN KEY (proprietaire_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_B03120CD76C50E4A ON complexes (proprietaire_id)');
        $this->addSql('ALTER TABLE terrains CHANGE enable enable TINYINT(1) DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA2398A2D8B41');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239A76ED395');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('ALTER TABLE avis CHANGE enable enable TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE complexes DROP FOREIGN KEY FK_B03120CD76C50E4A');
        $this->addSql('DROP INDEX IDX_B03120CD76C50E4A ON complexes');
        $this->addSql('ALTER TABLE complexes DROP proprietaire_id, CHANGE enable enable TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE terrains CHANGE enable enable TINYINT(1) NOT NULL');
    }
}
