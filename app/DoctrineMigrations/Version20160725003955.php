<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160725003955 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fertilizer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, formula VARCHAR(255) DEFAULT NULL, N DOUBLE PRECISION DEFAULT NULL, P2O5 DOUBLE PRECISION DEFAULT NULL, K2O DOUBLE PRECISION DEFAULT NULL, CaO DOUBLE PRECISION DEFAULT NULL, MgO DOUBLE PRECISION DEFAULT NULL, Fe DOUBLE PRECISION DEFAULT NULL, SO3 DOUBLE PRECISION DEFAULT NULL, Zn DOUBLE PRECISION DEFAULT NULL, B DOUBLE PRECISION DEFAULT NULL, Mn DOUBLE PRECISION DEFAULT NULL, Cu DOUBLE PRECISION DEFAULT NULL, comment LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_1525A45C5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE fertilizer');
    }
}
