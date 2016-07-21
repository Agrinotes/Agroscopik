<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160721040816 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE harvest_product ADD action_id INT NOT NULL');
        $this->addSql('ALTER TABLE harvest_product ADD CONSTRAINT FK_9FBA5869D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('CREATE INDEX IDX_9FBA5869D32F035 ON harvest_product (action_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE harvest_product DROP FOREIGN KEY FK_9FBA5869D32F035');
        $this->addSql('DROP INDEX IDX_9FBA5869D32F035 ON harvest_product');
        $this->addSql('ALTER TABLE harvest_product DROP action_id');
    }
}
