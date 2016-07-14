<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160714020340 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE farm_speciality ADD speciality_id INT NOT NULL');
        $this->addSql('ALTER TABLE farm_speciality ADD CONSTRAINT FK_318BB99A3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id)');
        $this->addSql('CREATE INDEX IDX_318BB99A3B5A08D7 ON farm_speciality (speciality_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE farm_speciality DROP FOREIGN KEY FK_318BB99A3B5A08D7');
        $this->addSql('DROP INDEX IDX_318BB99A3B5A08D7 ON farm_speciality');
        $this->addSql('ALTER TABLE farm_speciality DROP speciality_id');
    }
}
