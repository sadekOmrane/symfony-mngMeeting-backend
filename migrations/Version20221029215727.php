<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221029215727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification ADD reunion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA4E9B7368 FOREIGN KEY (reunion_id) REFERENCES reservation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BF5476CA4E9B7368 ON notification (reunion_id)');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955EF1A9D84');
        $this->addSql('DROP INDEX UNIQ_42C84955EF1A9D84 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP notification_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA4E9B7368');
        $this->addSql('DROP INDEX UNIQ_BF5476CA4E9B7368 ON notification');
        $this->addSql('ALTER TABLE notification DROP reunion_id');
        $this->addSql('ALTER TABLE reservation ADD notification_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42C84955EF1A9D84 ON reservation (notification_id)');
    }
}
