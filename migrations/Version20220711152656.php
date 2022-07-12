<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220711152656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE albumes_admin (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE albumes_admin_albumes (albumes_admin_id INT NOT NULL, albumes_id INT NOT NULL, INDEX IDX_1DDBE10A90D3858E (albumes_admin_id), INDEX IDX_1DDBE10A4E54DA2B (albumes_id), PRIMARY KEY(albumes_admin_id, albumes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE albumes_admin_user (albumes_admin_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_DC2C926690D3858E (albumes_admin_id), INDEX IDX_DC2C9266A76ED395 (user_id), PRIMARY KEY(albumes_admin_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE albumes_admin_albumes ADD CONSTRAINT FK_1DDBE10A90D3858E FOREIGN KEY (albumes_admin_id) REFERENCES albumes_admin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE albumes_admin_albumes ADD CONSTRAINT FK_1DDBE10A4E54DA2B FOREIGN KEY (albumes_id) REFERENCES albumes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE albumes_admin_user ADD CONSTRAINT FK_DC2C926690D3858E FOREIGN KEY (albumes_admin_id) REFERENCES albumes_admin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE albumes_admin_user ADD CONSTRAINT FK_DC2C9266A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE albumes_admin_albumes DROP FOREIGN KEY FK_1DDBE10A90D3858E');
        $this->addSql('ALTER TABLE albumes_admin_user DROP FOREIGN KEY FK_DC2C926690D3858E');
        $this->addSql('DROP TABLE albumes_admin');
        $this->addSql('DROP TABLE albumes_admin_albumes');
        $this->addSql('DROP TABLE albumes_admin_user');
    }
}
