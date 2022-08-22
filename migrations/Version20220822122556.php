<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220822122556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce ADD telephone_id INT NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5FE649A29 FOREIGN KEY (telephone_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_F65593E5FE649A29 ON annonce (telephone_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5FE649A29');
        $this->addSql('DROP INDEX IDX_F65593E5FE649A29 ON annonce');
        $this->addSql('ALTER TABLE annonce DROP telephone_id');
    }
}
