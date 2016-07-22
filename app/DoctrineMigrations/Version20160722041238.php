<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160722041238 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE action ADD comment LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE harvest_product DROP FOREIGN KEY FK_9FBA586BA9043B0');
        $this->addSql('DROP INDEX IDX_9FBA586BA9043B0 ON harvest_product');
        $this->addSql('ALTER TABLE harvest_product DROP unit2_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE action DROP comment');
        $this->addSql('ALTER TABLE harvest_product ADD unit2_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE harvest_product ADD CONSTRAINT FK_9FBA586BA9043B0 FOREIGN KEY (unit2_id) REFERENCES unit (id)');
        $this->addSql('CREATE INDEX IDX_9FBA586BA9043B0 ON harvest_product (unit2_id)');
    }
}
