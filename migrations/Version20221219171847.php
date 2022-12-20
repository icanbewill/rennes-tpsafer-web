<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221219171847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, category_id_id INT NOT NULL, added_by_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, surface DOUBLE PRECISION DEFAULT NULL, price DOUBLE PRECISION NOT NULL, description LONGTEXT DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(5) DEFAULT NULL, string VARCHAR(255) DEFAULT NULL, type VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8BF21CDE9777D11E (category_id_id), INDEX IDX_8BF21CDE55B127A4 (added_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE9777D11E FOREIGN KEY (category_id_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE55B127A4 FOREIGN KEY (added_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE category CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE9777D11E');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE55B127A4');
        $this->addSql('DROP TABLE property');
        $this->addSql('ALTER TABLE category CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
