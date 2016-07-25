<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160725020953 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE farm_fertilizer_mvt (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, fertilizer_id INT NOT NULL, action_id INT DEFAULT NULL, unit_id INT DEFAULT NULL, datetime DATETIME NOT NULL, amount DOUBLE PRECISION DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, INDEX IDX_A9446B9712469DE2 (category_id), INDEX IDX_A9446B978288BF5B (fertilizer_id), INDEX IDX_A9446B979D32F035 (action_id), INDEX IDX_A9446B97F8BD700D (unit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE farm_fertilizer_mvt_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_85AEDEF75E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE farm_fertilizer_mvt ADD CONSTRAINT FK_A9446B9712469DE2 FOREIGN KEY (category_id) REFERENCES farm_fertilizer_mvt_category (id)');
        $this->addSql('ALTER TABLE farm_fertilizer_mvt ADD CONSTRAINT FK_A9446B978288BF5B FOREIGN KEY (fertilizer_id) REFERENCES farm_fertilizer (id)');
        $this->addSql('ALTER TABLE farm_fertilizer_mvt ADD CONSTRAINT FK_A9446B979D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('ALTER TABLE farm_fertilizer_mvt ADD CONSTRAINT FK_A9446B97F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE farm_fertilizer_mvt DROP FOREIGN KEY FK_A9446B9712469DE2');
        $this->addSql('DROP TABLE farm_fertilizer_mvt');
        $this->addSql('DROP TABLE farm_fertilizer_mvt_category');
    }
}
