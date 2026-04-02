<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260402103037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apply (id INT AUTO_INCREMENT NOT NULL, mail_subject VARCHAR(255) NOT NULL, mail_body LONGTEXT NOT NULL, cover_letter LONGTEXT NOT NULL, status VARCHAR(255) NOT NULL, id_profile_id INT NOT NULL, id_offer_id INT NOT NULL, INDEX IDX_BD2F8C1F6970926F (id_profile_id), INDEX IDX_BD2F8C1F31D987B (id_offer_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE candidate_profile (id INT AUTO_INCREMENT NOT NULL, cv_path VARCHAR(100) DEFAULT NULL, description LONGTEXT DEFAULT NULL, pro_title VARCHAR(50) DEFAULT NULL, id_user_id INT NOT NULL, UNIQUE INDEX UNIQ_E8607AE79F37AE5 (id_user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, company_name VARCHAR(100) NOT NULL, location VARCHAR(100) NOT NULL, source VARCHAR(100) NOT NULL, source_url VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, create_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE relance (id INT AUTO_INCREMENT NOT NULL, mail_subject VARCHAR(255) NOT NULL, mail_body LONGTEXT NOT NULL, scheduled_at DATETIME NOT NULL, sent_at DATETIME DEFAULT NULL, create_at DATETIME NOT NULL, status VARCHAR(255) NOT NULL, id_apply_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_50BBC1261D07274B (id_apply_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE apply ADD CONSTRAINT FK_BD2F8C1F6970926F FOREIGN KEY (id_profile_id) REFERENCES candidate_profile (id)');
        $this->addSql('ALTER TABLE apply ADD CONSTRAINT FK_BD2F8C1F31D987B FOREIGN KEY (id_offer_id) REFERENCES offer (id)');
        $this->addSql('ALTER TABLE candidate_profile ADD CONSTRAINT FK_E8607AE79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE relance ADD CONSTRAINT FK_50BBC1261D07274B FOREIGN KEY (id_apply_id) REFERENCES apply (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apply DROP FOREIGN KEY FK_BD2F8C1F6970926F');
        $this->addSql('ALTER TABLE apply DROP FOREIGN KEY FK_BD2F8C1F31D987B');
        $this->addSql('ALTER TABLE candidate_profile DROP FOREIGN KEY FK_E8607AE79F37AE5');
        $this->addSql('ALTER TABLE relance DROP FOREIGN KEY FK_50BBC1261D07274B');
        $this->addSql('DROP TABLE apply');
        $this->addSql('DROP TABLE candidate_profile');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE relance');
    }
}
