<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241212131516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre_books (genre_id INT NOT NULL, books_id INT NOT NULL, INDEX IDX_F71D35574296D31F (genre_id), INDEX IDX_F71D35577DD8AC20 (books_id), PRIMARY KEY(genre_id, books_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE genre_books ADD CONSTRAINT FK_F71D35574296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE genre_books ADD CONSTRAINT FK_F71D35577DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE genre_books DROP FOREIGN KEY FK_F71D35574296D31F');
        $this->addSql('ALTER TABLE genre_books DROP FOREIGN KEY FK_F71D35577DD8AC20');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE genre_books');
    }
}
