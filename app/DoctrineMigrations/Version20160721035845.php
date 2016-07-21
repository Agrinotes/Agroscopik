<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160721035845 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE harvest_product (id INT AUTO_INCREMENT NOT NULL, unit_id INT DEFAULT NULL, unit2_id INT DEFAULT NULL, price_unit_id INT DEFAULT NULL, qty DOUBLE PRECISION DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, comment LONGTEXT DEFAULT NULL, INDEX IDX_9FBA586F8BD700D (unit_id), INDEX IDX_9FBA586BA9043B0 (unit2_id), INDEX IDX_9FBA586939BB851 (price_unit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE harvest_product ADD CONSTRAINT FK_9FBA586F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE harvest_product ADD CONSTRAINT FK_9FBA586BA9043B0 FOREIGN KEY (unit2_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE harvest_product ADD CONSTRAINT FK_9FBA586939BB851 FOREIGN KEY (price_unit_id) REFERENCES unit (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE harvest_product');
    }
}
