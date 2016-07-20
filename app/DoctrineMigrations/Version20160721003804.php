<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160721003804 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE farm_speciality_mvt ADD action_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE farm_speciality_mvt ADD CONSTRAINT FK_4DF3762B9D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('CREATE INDEX IDX_4DF3762B9D32F035 ON farm_speciality_mvt (action_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE farm_speciality_mvt DROP FOREIGN KEY FK_4DF3762B9D32F035');
        $this->addSql('DROP INDEX IDX_4DF3762B9D32F035 ON farm_speciality_mvt');
        $this->addSql('ALTER TABLE farm_speciality_mvt DROP action_id');
    }
}
