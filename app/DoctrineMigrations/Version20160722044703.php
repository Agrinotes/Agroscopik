<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160722044703 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE action ADD density_unit_id INT DEFAULT NULL, ADD density DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C92D1C2F101 FOREIGN KEY (density_unit_id) REFERENCES unit (id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92D1C2F101 ON action (density_unit_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C92D1C2F101');
        $this->addSql('DROP INDEX IDX_47CC8C92D1C2F101 ON action');
        $this->addSql('ALTER TABLE action DROP density_unit_id, DROP density');
    }
}
