<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250326141658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE books (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, cover VARCHAR(255) NOT NULL, page_number INT NOT NULL, published_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_4A1B2A92F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE books_genre (books_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_28A287017DD8AC20 (books_id), INDEX IDX_28A287014296D31F (genre_id), PRIMARY KEY(books_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE books ADD CONSTRAINT FK_4A1B2A92F675F31B FOREIGN KEY (author_id) REFERENCES author (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE books_genre ADD CONSTRAINT FK_28A287017DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE books_genre ADD CONSTRAINT FK_28A287014296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE books DROP FOREIGN KEY FK_4A1B2A92F675F31B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE books_genre DROP FOREIGN KEY FK_28A287017DD8AC20
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE books_genre DROP FOREIGN KEY FK_28A287014296D31F
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE books
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE books_genre
        SQL);
    }
}
