<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160719024249 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE farm_speciality_mvt ADD unit_id INT DEFAULT NULL, DROP unit');
        $this->addSql('ALTER TABLE farm_speciality_mvt ADD CONSTRAINT FK_4DF3762BF8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('CREATE INDEX IDX_4DF3762BF8BD700D ON farm_speciality_mvt (unit_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE farm_speciality_mvt DROP FOREIGN KEY FK_4DF3762BF8BD700D');
        $this->addSql('DROP INDEX IDX_4DF3762BF8BD700D ON farm_speciality_mvt');
        $this->addSql('ALTER TABLE farm_speciality_mvt ADD unit VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP unit_id');
    }
}
