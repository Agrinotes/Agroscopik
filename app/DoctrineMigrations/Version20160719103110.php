<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160719103110 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE substance ADD unit1_id INT DEFAULT NULL, ADD unit2_id INT DEFAULT NULL, DROP unit1, DROP unit2');
        $this->addSql('ALTER TABLE substance ADD CONSTRAINT FK_E481CB19A825EC5E FOREIGN KEY (unit1_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE substance ADD CONSTRAINT FK_E481CB19BA9043B0 FOREIGN KEY (unit2_id) REFERENCES unit (id)');
        $this->addSql('CREATE INDEX IDX_E481CB19A825EC5E ON substance (unit1_id)');
        $this->addSql('CREATE INDEX IDX_E481CB19BA9043B0 ON substance (unit2_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE substance DROP FOREIGN KEY FK_E481CB19A825EC5E');
        $this->addSql('ALTER TABLE substance DROP FOREIGN KEY FK_E481CB19BA9043B0');
        $this->addSql('DROP INDEX IDX_E481CB19A825EC5E ON substance');
        $this->addSql('DROP INDEX IDX_E481CB19BA9043B0 ON substance');
        $this->addSql('ALTER TABLE substance ADD unit1 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD unit2 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP unit1_id, DROP unit2_id');
    }
}
