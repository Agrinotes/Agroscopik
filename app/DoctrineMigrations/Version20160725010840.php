<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160725010840 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE farm_fertilizer ADD fertilizer_id INT NOT NULL');
        $this->addSql('ALTER TABLE farm_fertilizer ADD CONSTRAINT FK_D779BD488288BF5B FOREIGN KEY (fertilizer_id) REFERENCES fertilizer (id)');
        $this->addSql('CREATE INDEX IDX_D779BD488288BF5B ON farm_fertilizer (fertilizer_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE farm_fertilizer DROP FOREIGN KEY FK_D779BD488288BF5B');
        $this->addSql('DROP INDEX IDX_D779BD488288BF5B ON farm_fertilizer');
        $this->addSql('ALTER TABLE farm_fertilizer DROP fertilizer_id');
    }
}
