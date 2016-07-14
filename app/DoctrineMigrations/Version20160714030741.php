<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160714030741 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE farm_speciality_mvt (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, speciality_id INT NOT NULL, datetime DATETIME NOT NULL, amount DOUBLE PRECISION DEFAULT NULL, unit VARCHAR(255) DEFAULT NULL, pricePerUnit DOUBLE PRECISION DEFAULT NULL, INDEX IDX_4DF3762B12469DE2 (category_id), INDEX IDX_4DF3762B3B5A08D7 (speciality_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE farm_speciality_mvt_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A447E13E5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE farm_speciality_mvt ADD CONSTRAINT FK_4DF3762B12469DE2 FOREIGN KEY (category_id) REFERENCES farm_speciality_mvt_category (id)');
        $this->addSql('ALTER TABLE farm_speciality_mvt ADD CONSTRAINT FK_4DF3762B3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES farm_speciality (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE farm_speciality_mvt DROP FOREIGN KEY FK_4DF3762B12469DE2');
        $this->addSql('DROP TABLE farm_speciality_mvt');
        $this->addSql('DROP TABLE farm_speciality_mvt_category');
    }
}
