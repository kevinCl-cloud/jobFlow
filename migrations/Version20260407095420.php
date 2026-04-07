<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260407095420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apply DROP FOREIGN KEY `FK_BD2F8C1F31D987B`');
        $this->addSql('ALTER TABLE apply DROP FOREIGN KEY `FK_BD2F8C1F6970926F`');
        $this->addSql('DROP INDEX IDX_BD2F8C1F6970926F ON apply');
        $this->addSql('DROP INDEX IDX_BD2F8C1F31D987B ON apply');
        $this->addSql('ALTER TABLE apply ADD candidate_profile_id INT NOT NULL, ADD offer_id INT NOT NULL, DROP id_profile_id, DROP id_offer_id');
        $this->addSql('ALTER TABLE apply ADD CONSTRAINT FK_BD2F8C1FFE3D0586 FOREIGN KEY (candidate_profile_id) REFERENCES candidate_profile (id)');
        $this->addSql('ALTER TABLE apply ADD CONSTRAINT FK_BD2F8C1F53C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('CREATE INDEX IDX_BD2F8C1FFE3D0586 ON apply (candidate_profile_id)');
        $this->addSql('CREATE INDEX IDX_BD2F8C1F53C674EE ON apply (offer_id)');
        $this->addSql('ALTER TABLE candidate_profile DROP FOREIGN KEY `FK_E8607AE79F37AE5`');
        $this->addSql('DROP INDEX UNIQ_E8607AE79F37AE5 ON candidate_profile');
        $this->addSql('ALTER TABLE candidate_profile CHANGE id_user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE candidate_profile ADD CONSTRAINT FK_E8607AEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E8607AEA76ED395 ON candidate_profile (user_id)');
        $this->addSql('ALTER TABLE relance DROP FOREIGN KEY `FK_50BBC1261D07274B`');
        $this->addSql('DROP INDEX UNIQ_50BBC1261D07274B ON relance');
        $this->addSql('ALTER TABLE relance ADD apply_id INT NOT NULL, DROP id_apply_id');
        $this->addSql('ALTER TABLE relance ADD CONSTRAINT FK_50BBC1264DDCCBDE FOREIGN KEY (apply_id) REFERENCES apply (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_50BBC1264DDCCBDE ON relance (apply_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apply DROP FOREIGN KEY FK_BD2F8C1FFE3D0586');
        $this->addSql('ALTER TABLE apply DROP FOREIGN KEY FK_BD2F8C1F53C674EE');
        $this->addSql('DROP INDEX IDX_BD2F8C1FFE3D0586 ON apply');
        $this->addSql('DROP INDEX IDX_BD2F8C1F53C674EE ON apply');
        $this->addSql('ALTER TABLE apply ADD id_profile_id INT NOT NULL, ADD id_offer_id INT NOT NULL, DROP candidate_profile_id, DROP offer_id');
        $this->addSql('ALTER TABLE apply ADD CONSTRAINT `FK_BD2F8C1F31D987B` FOREIGN KEY (id_offer_id) REFERENCES offer (id)');
        $this->addSql('ALTER TABLE apply ADD CONSTRAINT `FK_BD2F8C1F6970926F` FOREIGN KEY (id_profile_id) REFERENCES candidate_profile (id)');
        $this->addSql('CREATE INDEX IDX_BD2F8C1F6970926F ON apply (id_profile_id)');
        $this->addSql('CREATE INDEX IDX_BD2F8C1F31D987B ON apply (id_offer_id)');
        $this->addSql('ALTER TABLE candidate_profile DROP FOREIGN KEY FK_E8607AEA76ED395');
        $this->addSql('DROP INDEX UNIQ_E8607AEA76ED395 ON candidate_profile');
        $this->addSql('ALTER TABLE candidate_profile CHANGE user_id id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE candidate_profile ADD CONSTRAINT `FK_E8607AE79F37AE5` FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E8607AE79F37AE5 ON candidate_profile (id_user_id)');
        $this->addSql('ALTER TABLE relance DROP FOREIGN KEY FK_50BBC1264DDCCBDE');
        $this->addSql('DROP INDEX UNIQ_50BBC1264DDCCBDE ON relance');
        $this->addSql('ALTER TABLE relance ADD id_apply_id INT DEFAULT NULL, DROP apply_id');
        $this->addSql('ALTER TABLE relance ADD CONSTRAINT `FK_50BBC1261D07274B` FOREIGN KEY (id_apply_id) REFERENCES apply (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_50BBC1261D07274B ON relance (id_apply_id)');
    }
}
