<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160715020450 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE substance (id INT AUTO_INCREMENT NOT NULL, speciality_id INT NOT NULL, amount DOUBLE PRECISION DEFAULT NULL, fullUnit VARCHAR(255) DEFAULT NULL, unit1 VARCHAR(255) DEFAULT NULL, unit2 VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, CAS VARCHAR(255) DEFAULT NULL, INDEX IDX_E481CB193B5A08D7 (speciality_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE substance ADD CONSTRAINT FK_E481CB193B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE substance');
    }
}
