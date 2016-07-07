<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160707023611 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tractor_model (id INT AUTO_INCREMENT NOT NULL, brand VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, power INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE tractor_brand');
        $this->addSql('ALTER TABLE tractor ADD model_id INT NOT NULL');
        $this->addSql('ALTER TABLE tractor ADD CONSTRAINT FK_41F626687975B7E7 FOREIGN KEY (model_id) REFERENCES tractor_model (id)');
        $this->addSql('CREATE INDEX IDX_41F626687975B7E7 ON tractor (model_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tractor DROP FOREIGN KEY FK_41F626687975B7E7');
        $this->addSql('CREATE TABLE tractor_brand (id INT AUTO_INCREMENT NOT NULL, brand VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, power INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE tractor_model');
        $this->addSql('DROP INDEX IDX_41F626687975B7E7 ON tractor');
        $this->addSql('ALTER TABLE tractor DROP model_id');
    }
}
