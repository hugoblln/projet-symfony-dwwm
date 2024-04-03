<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240318162643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE terrains_image DROP FOREIGN KEY FK_7758B1637294869C');
        $this->addSql('DROP INDEX IDX_7758B1637294869C ON terrains_image');
        $this->addSql('ALTER TABLE terrains_image CHANGE article_id terrain_id INT NOT NULL');
        $this->addSql('ALTER TABLE terrains_image ADD CONSTRAINT FK_7758B1638A2D8B41 FOREIGN KEY (terrain_id) REFERENCES terrains (id)');
        $this->addSql('CREATE INDEX IDX_7758B1638A2D8B41 ON terrains_image (terrain_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE terrains_image DROP FOREIGN KEY FK_7758B1638A2D8B41');
        $this->addSql('DROP INDEX IDX_7758B1638A2D8B41 ON terrains_image');
        $this->addSql('ALTER TABLE terrains_image CHANGE terrain_id article_id INT NOT NULL');
        $this->addSql('ALTER TABLE terrains_image ADD CONSTRAINT FK_7758B1637294869C FOREIGN KEY (article_id) REFERENCES terrains (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_7758B1637294869C ON terrains_image (article_id)');
    }
}
