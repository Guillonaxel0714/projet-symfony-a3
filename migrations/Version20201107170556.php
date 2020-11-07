<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201107170556 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE semaine ADD categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE semaine ADD CONSTRAINT FK_7B4D8BEABCF5E72D FOREIGN KEY (categorie_id) REFERENCES module (id)');
        $this->addSql('CREATE INDEX IDX_7B4D8BEABCF5E72D ON semaine (categorie_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE semaine DROP FOREIGN KEY FK_7B4D8BEABCF5E72D');
        $this->addSql('DROP INDEX IDX_7B4D8BEABCF5E72D ON semaine');
        $this->addSql('ALTER TABLE semaine DROP categorie_id');
    }
}
