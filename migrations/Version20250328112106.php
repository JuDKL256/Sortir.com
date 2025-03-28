<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250328112106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE motif_annulation (id INT AUTO_INCREMENT NOT NULL, sortie_id INT NOT NULL, motif VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_7D6F1BE5CC72D953 (sortie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE motif_annulation ADD CONSTRAINT FK_7D6F1BE5CC72D953 FOREIGN KEY (sortie_id) REFERENCES sortie (id)');
        $this->addSql('ALTER TABLE participant CHANGE actif actif TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE sortie CHANGE lieu_id lieu_id INT DEFAULT NULL, CHANGE site_id site_id INT DEFAULT NULL, CHANGE organisateur_id organisateur_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE motif_annulation DROP FOREIGN KEY FK_7D6F1BE5CC72D953');
        $this->addSql('DROP TABLE motif_annulation');
        $this->addSql('ALTER TABLE participant CHANGE actif actif TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE sortie CHANGE lieu_id lieu_id INT NOT NULL, CHANGE site_id site_id INT NOT NULL, CHANGE organisateur_id organisateur_id INT NOT NULL');
    }
}
