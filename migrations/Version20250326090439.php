<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250326090439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sortie ADD inscription_ouverte TINYINT(1) NOT NULL, CHANGE lieu_id lieu_id INT DEFAULT NULL, CHANGE site_id site_id INT DEFAULT NULL, CHANGE organisateur_id organisateur_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sortie DROP inscription_ouverte, CHANGE lieu_id lieu_id INT NOT NULL, CHANGE site_id site_id INT NOT NULL, CHANGE organisateur_id organisateur_id INT NOT NULL');
    }
}
