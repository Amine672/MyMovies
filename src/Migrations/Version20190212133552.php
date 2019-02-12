<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190212133552 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE rate_movie (id INT AUTO_INCREMENT NOT NULL, movie_id INT DEFAULT NULL, rate INT NOT NULL, INDEX IDX_8D1EEB4C8F93B6FC (movie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rate_movie ADD CONSTRAINT FK_8D1EEB4C8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id)');
        $this->addSql('ALTER TABLE user ADD rate_movie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495844A65D FOREIGN KEY (rate_movie_id) REFERENCES rate_movie (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6495844A65D ON user (rate_movie_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495844A65D');
        $this->addSql('DROP TABLE rate_movie');
        $this->addSql('DROP INDEX IDX_8D93D6495844A65D ON user');
        $this->addSql('ALTER TABLE user DROP rate_movie_id');
    }
}
