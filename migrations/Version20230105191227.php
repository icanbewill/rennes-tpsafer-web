<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230105191227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favourite ADD is_sent TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE property ADD reference VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE searched_property DROP yes');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favourite DROP is_sent');
        $this->addSql('ALTER TABLE property DROP reference');
        $this->addSql('ALTER TABLE searched_property ADD yes VARCHAR(255) DEFAULT NULL');
    }
}
