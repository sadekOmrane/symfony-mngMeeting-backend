<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220714124400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materiel (id INT AUTO_INCREMENT NOT NULL, salle_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_18D2B091DC304035 (salle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, salle_id INT DEFAULT NULL, date_rec DATETIME NOT NULL, etat TINYINT(1) NOT NULL, description LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_CE606404DC304035 (salle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, responsable_id INT DEFAULT NULL, salle_id INT DEFAULT NULL, date_deb DATETIME NOT NULL, date_fin DATETIME NOT NULL, UNIQUE INDEX UNIQ_42C8495553C59D72 (responsable_id), UNIQUE INDEX UNIQ_42C84955DC304035 (salle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, capacite INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, department_id INT DEFAULT NULL, reservation_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649AE80F5DF (department_id), INDEX IDX_8D93D649B83297E7 (reservation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE materiel ADD CONSTRAINT FK_18D2B091DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495553C59D72 FOREIGN KEY (responsable_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649AE80F5DF');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649B83297E7');
        $this->addSql('ALTER TABLE materiel DROP FOREIGN KEY FK_18D2B091DC304035');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404DC304035');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955DC304035');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495553C59D72');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE materiel');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE `user`');
    }
}
