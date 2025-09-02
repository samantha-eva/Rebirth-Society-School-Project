<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250902204838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_video (order_id INT NOT NULL, video_id INT NOT NULL, INDEX IDX_FF59AED18D9F6D38 (order_id), INDEX IDX_FF59AED129C1004E (video_id), PRIMARY KEY(order_id, video_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_video ADD CONSTRAINT FK_FF59AED18D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_video ADD CONSTRAINT FK_FF59AED129C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_video DROP FOREIGN KEY FK_FF59AED18D9F6D38');
        $this->addSql('ALTER TABLE order_video DROP FOREIGN KEY FK_FF59AED129C1004E');
        $this->addSql('DROP TABLE order_video');
    }
}
