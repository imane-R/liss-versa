<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230131101229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE price_by_hair ADD service_id INT NOT NULL, ADD hair_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE price_by_hair ADD CONSTRAINT FK_C1BEF0F8ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE price_by_hair ADD CONSTRAINT FK_C1BEF0F8E350E30F FOREIGN KEY (hair_type_id) REFERENCES hair_type (id)');
        $this->addSql('CREATE INDEX IDX_C1BEF0F8ED5CA9E6 ON price_by_hair (service_id)');
        $this->addSql('CREATE INDEX IDX_C1BEF0F8E350E30F ON price_by_hair (hair_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE price_by_hair DROP FOREIGN KEY FK_C1BEF0F8ED5CA9E6');
        $this->addSql('ALTER TABLE price_by_hair DROP FOREIGN KEY FK_C1BEF0F8E350E30F');
        $this->addSql('DROP INDEX IDX_C1BEF0F8ED5CA9E6 ON price_by_hair');
        $this->addSql('DROP INDEX IDX_C1BEF0F8E350E30F ON price_by_hair');
        $this->addSql('ALTER TABLE price_by_hair DROP service_id, DROP hair_type_id');
    }
}
