<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160719083846 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE speciality_usage ADD unit1_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE speciality_usage ADD CONSTRAINT FK_24F147BA825EC5E FOREIGN KEY (unit1_id) REFERENCES unit (id)');
        $this->addSql('CREATE INDEX IDX_24F147BA825EC5E ON speciality_usage (unit1_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE speciality_usage DROP FOREIGN KEY FK_24F147BA825EC5E');
        $this->addSql('DROP INDEX IDX_24F147BA825EC5E ON speciality_usage');
        $this->addSql('ALTER TABLE speciality_usage DROP unit1_id');
    }
}
