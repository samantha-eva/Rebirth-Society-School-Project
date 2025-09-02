<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250902203332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_pack (video_id INT NOT NULL, pack_id INT NOT NULL, INDEX IDX_904903FF29C1004E (video_id), INDEX IDX_904903FF1919B217 (pack_id), PRIMARY KEY(video_id, pack_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE video_pack ADD CONSTRAINT FK_904903FF29C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_pack ADD CONSTRAINT FK_904903FF1919B217 FOREIGN KEY (pack_id) REFERENCES pack (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE video_pack DROP FOREIGN KEY FK_904903FF29C1004E');
        $this->addSql('ALTER TABLE video_pack DROP FOREIGN KEY FK_904903FF1919B217');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE video_pack');
    }
}
