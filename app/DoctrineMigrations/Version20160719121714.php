<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160719121714 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE speciality ADD unit_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE speciality ADD CONSTRAINT FK_F3D7A08E8921F7C4 FOREIGN KEY (unit_category_id) REFERENCES unit_category (id)');
        $this->addSql('CREATE INDEX IDX_F3D7A08E8921F7C4 ON speciality (unit_category_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE speciality DROP FOREIGN KEY FK_F3D7A08E8921F7C4');
        $this->addSql('DROP INDEX IDX_F3D7A08E8921F7C4 ON speciality');
        $this->addSql('ALTER TABLE speciality DROP unit_category_id');
    }
}
