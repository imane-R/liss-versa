<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230317152540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE price_by_hair DROP FOREIGN KEY FK_C1BEF0F8E350E30F');
        $this->addSql('ALTER TABLE price_by_hair DROP FOREIGN KEY FK_C1BEF0F8ED5CA9E6');
        $this->addSql('DROP TABLE hair_type');
        $this->addSql('DROP TABLE price_by_hair');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hair_type (id INT AUTO_INCREMENT NOT NULL, type_hair VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE price_by_hair (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, hair_type_id INT NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_C1BEF0F8ED5CA9E6 (service_id), INDEX IDX_C1BEF0F8E350E30F (hair_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE price_by_hair ADD CONSTRAINT FK_C1BEF0F8E350E30F FOREIGN KEY (hair_type_id) REFERENCES hair_type (id)');
        $this->addSql('ALTER TABLE price_by_hair ADD CONSTRAINT FK_C1BEF0F8ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
    }
}
