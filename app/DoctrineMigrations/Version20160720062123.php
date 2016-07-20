<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160720062123 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE action (id INT AUTO_INCREMENT NOT NULL, crop_cycle_id INT NOT NULL, intervention_id INT NOT NULL, startDatetime DATETIME NOT NULL, endDatetime DATETIME NOT NULL, INDEX IDX_47CC8C928C7C48B3 (crop_cycle_id), INDEX IDX_47CC8C928EAE3863 (intervention_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE action_tractor (action_id INT NOT NULL, tractor_id INT NOT NULL, INDEX IDX_9B54AE899D32F035 (action_id), INDEX IDX_9B54AE89B7858BE4 (tractor_id), PRIMARY KEY(action_id, tractor_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE action_implement (action_id INT NOT NULL, implement_id INT NOT NULL, INDEX IDX_10EBB7089D32F035 (action_id), INDEX IDX_10EBB708687C4337 (implement_id), PRIMARY KEY(action_id, implement_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE crop (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(7) NOT NULL, UNIQUE INDEX UNIQ_EDC23D9B5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE crop_cycle (id INT AUTO_INCREMENT NOT NULL, plot_id INT NOT NULL, varieties VARCHAR(250) DEFAULT NULL, status VARCHAR(50) NOT NULL, latLngs LONGTEXT DEFAULT NULL, area NUMERIC(10, 2) DEFAULT NULL, startDatetime DATETIME DEFAULT NULL, endDatetime DATETIME DEFAULT NULL, INDEX IDX_69D0C2C6680D0B01 (plot_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE crop_cycle_crop (crop_cycle_id INT NOT NULL, crop_id INT NOT NULL, INDEX IDX_334093A88C7C48B3 (crop_cycle_id), INDEX IDX_334093A8888579EE (crop_id), PRIMARY KEY(crop_cycle_id, crop_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, action_id INT NOT NULL, startDatetime DATETIME NOT NULL, endDatetime DATETIME NOT NULL, INDEX IDX_3BAE0AA79D32F035 (action_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE farm (id INT AUTO_INCREMENT NOT NULL, farmer_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_5816D04513481D2B (farmer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE farm_speciality (id INT AUTO_INCREMENT NOT NULL, farm_id INT NOT NULL, speciality_id INT NOT NULL, INDEX IDX_318BB99A65FCFA0D (farm_id), INDEX IDX_318BB99A3B5A08D7 (speciality_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE farm_speciality_mvt (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, speciality_id INT NOT NULL, unit_id INT DEFAULT NULL, datetime DATETIME NOT NULL, amount DOUBLE PRECISION DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, INDEX IDX_4DF3762B12469DE2 (category_id), INDEX IDX_4DF3762B3B5A08D7 (speciality_id), INDEX IDX_4DF3762BF8BD700D (unit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE farm_speciality_mvt_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A447E13E5E237E06 (name), UNIQUE INDEX UNIQ_A447E13E989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE implement (id INT AUTO_INCREMENT NOT NULL, farm_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_B4EDA41565FCFA0D (farm_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention (id INT AUTO_INCREMENT NOT NULL, intervention_category_id INT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D11814AB5E237E06 (name), INDEX IDX_D11814AB6CB51C25 (intervention_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_3BDF62625E237E06 (name), UNIQUE INDEX UNIQ_3BDF6262989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plot (id INT AUTO_INCREMENT NOT NULL, farm_id INT NOT NULL, name VARCHAR(255) NOT NULL, latLngs LONGTEXT DEFAULT NULL, area NUMERIC(10, 2) DEFAULT NULL, INDEX IDX_BEBB8F8965FCFA0D (farm_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speciality (id INT AUTO_INCREMENT NOT NULL, unit_category_id INT DEFAULT NULL, amm INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F3D7A08E5504700A (amm), UNIQUE INDEX UNIQ_F3D7A08E5E237E06 (name), INDEX IDX_F3D7A08E8921F7C4 (unit_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speciality_usage (id INT AUTO_INCREMENT NOT NULL, speciality_id INT NOT NULL, unit1_id INT DEFAULT NULL, unit2_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, minCropStage INT DEFAULT NULL, maxCropStage INT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, dose DOUBLE PRECISION DEFAULT NULL, amountUnit2 INT DEFAULT NULL, fullUnit VARCHAR(255) DEFAULT NULL, DAR INT DEFAULT NULL, maxActions INT DEFAULT NULL, conditions VARCHAR(255) DEFAULT NULL, ZNTwater INT DEFAULT NULL, ZNTarthropodes INT DEFAULT NULL, ZNTplants INT DEFAULT NULL, INDEX IDX_24F147B3B5A08D7 (speciality_id), INDEX IDX_24F147BA825EC5E (unit1_id), INDEX IDX_24F147BBA9043B0 (unit2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE substance (id INT AUTO_INCREMENT NOT NULL, speciality_id INT NOT NULL, unit1_id INT DEFAULT NULL, unit2_id INT DEFAULT NULL, amount DOUBLE PRECISION DEFAULT NULL, fullUnit VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, CAS VARCHAR(255) DEFAULT NULL, INDEX IDX_E481CB193B5A08D7 (speciality_id), INDEX IDX_E481CB19A825EC5E (unit1_id), INDEX IDX_E481CB19BA9043B0 (unit2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tractor (id INT AUTO_INCREMENT NOT NULL, model_id INT NOT NULL, farm_id INT NOT NULL, startDatetime DATETIME DEFAULT NULL, price INT DEFAULT NULL, INDEX IDX_41F626687975B7E7 (model_id), INDEX IDX_41F6266865FCFA0D (farm_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tractor_model (id INT AUTO_INCREMENT NOT NULL, brand VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, power INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unit (id INT AUTO_INCREMENT NOT NULL, unit_category_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, A DOUBLE PRECISION DEFAULT NULL, B DOUBLE PRECISION DEFAULT NULL, C DOUBLE PRECISION DEFAULT NULL, symbol VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_DCBB0C535E237E06 (name), UNIQUE INDEX UNIQ_DCBB0C53989D9B62 (slug), INDEX IDX_DCBB0C538921F7C4 (unit_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unit_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, symbol VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_7372F3535E237E06 (name), UNIQUE INDEX UNIQ_7372F353989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agronomik_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D527DE3792FC23A8 (username_canonical), UNIQUE INDEX UNIQ_D527DE37A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_classes (id INT UNSIGNED AUTO_INCREMENT NOT NULL, class_type VARCHAR(200) NOT NULL, UNIQUE INDEX UNIQ_69DD750638A36066 (class_type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_security_identities (id INT UNSIGNED AUTO_INCREMENT NOT NULL, identifier VARCHAR(200) NOT NULL, username TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8835EE78772E836AF85E0677 (identifier, username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_object_identities (id INT UNSIGNED AUTO_INCREMENT NOT NULL, parent_object_identity_id INT UNSIGNED DEFAULT NULL, class_id INT UNSIGNED NOT NULL, object_identifier VARCHAR(100) NOT NULL, entries_inheriting TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_9407E5494B12AD6EA000B10 (object_identifier, class_id), INDEX IDX_9407E54977FA751A (parent_object_identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_object_identity_ancestors (object_identity_id INT UNSIGNED NOT NULL, ancestor_id INT UNSIGNED NOT NULL, INDEX IDX_825DE2993D9AB4A6 (object_identity_id), INDEX IDX_825DE299C671CEA1 (ancestor_id), PRIMARY KEY(object_identity_id, ancestor_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_entries (id INT UNSIGNED AUTO_INCREMENT NOT NULL, class_id INT UNSIGNED NOT NULL, object_identity_id INT UNSIGNED DEFAULT NULL, security_identity_id INT UNSIGNED NOT NULL, field_name VARCHAR(50) DEFAULT NULL, ace_order SMALLINT UNSIGNED NOT NULL, mask INT NOT NULL, granting TINYINT(1) NOT NULL, granting_strategy VARCHAR(30) NOT NULL, audit_success TINYINT(1) NOT NULL, audit_failure TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_46C8B806EA000B103D9AB4A64DEF17BCE4289BF4 (class_id, object_identity_id, field_name, ace_order), INDEX IDX_46C8B806EA000B103D9AB4A6DF9183C9 (class_id, object_identity_id, security_identity_id), INDEX IDX_46C8B806EA000B10 (class_id), INDEX IDX_46C8B8063D9AB4A6 (object_identity_id), INDEX IDX_46C8B806DF9183C9 (security_identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C928C7C48B3 FOREIGN KEY (crop_cycle_id) REFERENCES crop_cycle (id)');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C928EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id)');
        $this->addSql('ALTER TABLE action_tractor ADD CONSTRAINT FK_9B54AE899D32F035 FOREIGN KEY (action_id) REFERENCES action (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE action_tractor ADD CONSTRAINT FK_9B54AE89B7858BE4 FOREIGN KEY (tractor_id) REFERENCES tractor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE action_implement ADD CONSTRAINT FK_10EBB7089D32F035 FOREIGN KEY (action_id) REFERENCES action (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE action_implement ADD CONSTRAINT FK_10EBB708687C4337 FOREIGN KEY (implement_id) REFERENCES implement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE crop_cycle ADD CONSTRAINT FK_69D0C2C6680D0B01 FOREIGN KEY (plot_id) REFERENCES plot (id)');
        $this->addSql('ALTER TABLE crop_cycle_crop ADD CONSTRAINT FK_334093A88C7C48B3 FOREIGN KEY (crop_cycle_id) REFERENCES crop_cycle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE crop_cycle_crop ADD CONSTRAINT FK_334093A8888579EE FOREIGN KEY (crop_id) REFERENCES crop (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA79D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('ALTER TABLE farm ADD CONSTRAINT FK_5816D04513481D2B FOREIGN KEY (farmer_id) REFERENCES agronomik_user (id)');
        $this->addSql('ALTER TABLE farm_speciality ADD CONSTRAINT FK_318BB99A65FCFA0D FOREIGN KEY (farm_id) REFERENCES farm (id)');
        $this->addSql('ALTER TABLE farm_speciality ADD CONSTRAINT FK_318BB99A3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id)');
        $this->addSql('ALTER TABLE farm_speciality_mvt ADD CONSTRAINT FK_4DF3762B12469DE2 FOREIGN KEY (category_id) REFERENCES farm_speciality_mvt_category (id)');
        $this->addSql('ALTER TABLE farm_speciality_mvt ADD CONSTRAINT FK_4DF3762B3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES farm_speciality (id)');
        $this->addSql('ALTER TABLE farm_speciality_mvt ADD CONSTRAINT FK_4DF3762BF8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE implement ADD CONSTRAINT FK_B4EDA41565FCFA0D FOREIGN KEY (farm_id) REFERENCES farm (id)');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814AB6CB51C25 FOREIGN KEY (intervention_category_id) REFERENCES intervention_category (id)');
        $this->addSql('ALTER TABLE plot ADD CONSTRAINT FK_BEBB8F8965FCFA0D FOREIGN KEY (farm_id) REFERENCES farm (id)');
        $this->addSql('ALTER TABLE speciality ADD CONSTRAINT FK_F3D7A08E8921F7C4 FOREIGN KEY (unit_category_id) REFERENCES unit_category (id)');
        $this->addSql('ALTER TABLE speciality_usage ADD CONSTRAINT FK_24F147B3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id)');
        $this->addSql('ALTER TABLE speciality_usage ADD CONSTRAINT FK_24F147BA825EC5E FOREIGN KEY (unit1_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE speciality_usage ADD CONSTRAINT FK_24F147BBA9043B0 FOREIGN KEY (unit2_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE substance ADD CONSTRAINT FK_E481CB193B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id)');
        $this->addSql('ALTER TABLE substance ADD CONSTRAINT FK_E481CB19A825EC5E FOREIGN KEY (unit1_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE substance ADD CONSTRAINT FK_E481CB19BA9043B0 FOREIGN KEY (unit2_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE tractor ADD CONSTRAINT FK_41F626687975B7E7 FOREIGN KEY (model_id) REFERENCES tractor_model (id)');
        $this->addSql('ALTER TABLE tractor ADD CONSTRAINT FK_41F6266865FCFA0D FOREIGN KEY (farm_id) REFERENCES farm (id)');
        $this->addSql('ALTER TABLE unit ADD CONSTRAINT FK_DCBB0C538921F7C4 FOREIGN KEY (unit_category_id) REFERENCES unit_category (id)');
        $this->addSql('ALTER TABLE acl_object_identities ADD CONSTRAINT FK_9407E54977FA751A FOREIGN KEY (parent_object_identity_id) REFERENCES acl_object_identities (id)');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors ADD CONSTRAINT FK_825DE2993D9AB4A6 FOREIGN KEY (object_identity_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors ADD CONSTRAINT FK_825DE299C671CEA1 FOREIGN KEY (ancestor_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B806EA000B10 FOREIGN KEY (class_id) REFERENCES acl_classes (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B8063D9AB4A6 FOREIGN KEY (object_identity_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B806DF9183C9 FOREIGN KEY (security_identity_id) REFERENCES acl_security_identities (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE action_tractor DROP FOREIGN KEY FK_9B54AE899D32F035');
        $this->addSql('ALTER TABLE action_implement DROP FOREIGN KEY FK_10EBB7089D32F035');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA79D32F035');
        $this->addSql('ALTER TABLE crop_cycle_crop DROP FOREIGN KEY FK_334093A8888579EE');
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C928C7C48B3');
        $this->addSql('ALTER TABLE crop_cycle_crop DROP FOREIGN KEY FK_334093A88C7C48B3');
        $this->addSql('ALTER TABLE farm_speciality DROP FOREIGN KEY FK_318BB99A65FCFA0D');
        $this->addSql('ALTER TABLE implement DROP FOREIGN KEY FK_B4EDA41565FCFA0D');
        $this->addSql('ALTER TABLE plot DROP FOREIGN KEY FK_BEBB8F8965FCFA0D');
        $this->addSql('ALTER TABLE tractor DROP FOREIGN KEY FK_41F6266865FCFA0D');
        $this->addSql('ALTER TABLE farm_speciality_mvt DROP FOREIGN KEY FK_4DF3762B3B5A08D7');
        $this->addSql('ALTER TABLE farm_speciality_mvt DROP FOREIGN KEY FK_4DF3762B12469DE2');
        $this->addSql('ALTER TABLE action_implement DROP FOREIGN KEY FK_10EBB708687C4337');
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C928EAE3863');
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_D11814AB6CB51C25');
        $this->addSql('ALTER TABLE crop_cycle DROP FOREIGN KEY FK_69D0C2C6680D0B01');
        $this->addSql('ALTER TABLE farm_speciality DROP FOREIGN KEY FK_318BB99A3B5A08D7');
        $this->addSql('ALTER TABLE speciality_usage DROP FOREIGN KEY FK_24F147B3B5A08D7');
        $this->addSql('ALTER TABLE substance DROP FOREIGN KEY FK_E481CB193B5A08D7');
        $this->addSql('ALTER TABLE action_tractor DROP FOREIGN KEY FK_9B54AE89B7858BE4');
        $this->addSql('ALTER TABLE tractor DROP FOREIGN KEY FK_41F626687975B7E7');
        $this->addSql('ALTER TABLE farm_speciality_mvt DROP FOREIGN KEY FK_4DF3762BF8BD700D');
        $this->addSql('ALTER TABLE speciality_usage DROP FOREIGN KEY FK_24F147BA825EC5E');
        $this->addSql('ALTER TABLE speciality_usage DROP FOREIGN KEY FK_24F147BBA9043B0');
        $this->addSql('ALTER TABLE substance DROP FOREIGN KEY FK_E481CB19A825EC5E');
        $this->addSql('ALTER TABLE substance DROP FOREIGN KEY FK_E481CB19BA9043B0');
        $this->addSql('ALTER TABLE speciality DROP FOREIGN KEY FK_F3D7A08E8921F7C4');
        $this->addSql('ALTER TABLE unit DROP FOREIGN KEY FK_DCBB0C538921F7C4');
        $this->addSql('ALTER TABLE farm DROP FOREIGN KEY FK_5816D04513481D2B');
        $this->addSql('ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B806EA000B10');
        $this->addSql('ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B806DF9183C9');
        $this->addSql('ALTER TABLE acl_object_identities DROP FOREIGN KEY FK_9407E54977FA751A');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors DROP FOREIGN KEY FK_825DE2993D9AB4A6');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors DROP FOREIGN KEY FK_825DE299C671CEA1');
        $this->addSql('ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B8063D9AB4A6');
        $this->addSql('DROP TABLE action');
        $this->addSql('DROP TABLE action_tractor');
        $this->addSql('DROP TABLE action_implement');
        $this->addSql('DROP TABLE crop');
        $this->addSql('DROP TABLE crop_cycle');
        $this->addSql('DROP TABLE crop_cycle_crop');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE farm');
        $this->addSql('DROP TABLE farm_speciality');
        $this->addSql('DROP TABLE farm_speciality_mvt');
        $this->addSql('DROP TABLE farm_speciality_mvt_category');
        $this->addSql('DROP TABLE implement');
        $this->addSql('DROP TABLE intervention');
        $this->addSql('DROP TABLE intervention_category');
        $this->addSql('DROP TABLE plot');
        $this->addSql('DROP TABLE speciality');
        $this->addSql('DROP TABLE speciality_usage');
        $this->addSql('DROP TABLE substance');
        $this->addSql('DROP TABLE tractor');
        $this->addSql('DROP TABLE tractor_model');
        $this->addSql('DROP TABLE unit');
        $this->addSql('DROP TABLE unit_category');
        $this->addSql('DROP TABLE agronomik_user');
        $this->addSql('DROP TABLE acl_classes');
        $this->addSql('DROP TABLE acl_security_identities');
        $this->addSql('DROP TABLE acl_object_identities');
        $this->addSql('DROP TABLE acl_object_identity_ancestors');
        $this->addSql('DROP TABLE acl_entries');
    }
}
