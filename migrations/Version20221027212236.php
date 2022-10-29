<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221027212236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE readed_notification (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, notification_id INT DEFAULT NULL, state TINYINT(1) NOT NULL, read_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C2C333E9A76ED395 (user_id), INDEX IDX_C2C333E9EF1A9D84 (notification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE readed_notification ADD CONSTRAINT FK_C2C333E9A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE readed_notification ADD CONSTRAINT FK_C2C333E9EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE readed_notification');
    }
}
