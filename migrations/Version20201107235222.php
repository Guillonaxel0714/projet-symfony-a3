<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201107235222 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE semaine DROP FOREIGN KEY FK_7B4D8BEAC43E5A2D');
        $this->addSql('DROP INDEX UNIQ_7B4D8BEAC43E5A2D ON semaine');
        $this->addSql('ALTER TABLE semaine DROP notations_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE semaine ADD notations_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE semaine ADD CONSTRAINT FK_7B4D8BEAC43E5A2D FOREIGN KEY (notations_id) REFERENCES notation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7B4D8BEAC43E5A2D ON semaine (notations_id)');
    }
}
