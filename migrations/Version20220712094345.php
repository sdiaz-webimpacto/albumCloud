<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220712094345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE photos (id INT AUTO_INCREMENT NOT NULL, photo_owner_id INT NOT NULL, photo_album_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, photo_path VARCHAR(255) NOT NULL, date_add DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_876E0D9ED007E73 (photo_owner_id), INDEX IDX_876E0D9820BB445 (photo_album_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D9ED007E73 FOREIGN KEY (photo_owner_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D9820BB445 FOREIGN KEY (photo_album_id) REFERENCES albumes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE photos');
    }
}
