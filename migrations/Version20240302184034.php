<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240302184034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE terrains ADD complexe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE terrains ADD CONSTRAINT FK_A7A03A42CB54E12E FOREIGN KEY (complexe_id) REFERENCES complexes (id)');
        $this->addSql('CREATE INDEX IDX_A7A03A42CB54E12E ON terrains (complexe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE terrains DROP FOREIGN KEY FK_A7A03A42CB54E12E');
        $this->addSql('DROP INDEX IDX_A7A03A42CB54E12E ON terrains');
        $this->addSql('ALTER TABLE terrains DROP complexe_id');
    }
}
