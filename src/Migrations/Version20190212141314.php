<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190212141314 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE rate_movie_movie');
        $this->addSql('DROP TABLE rate_movie_user');
        $this->addSql('ALTER TABLE rate_movie ADD user_id INT DEFAULT NULL, ADD movie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rate_movie ADD CONSTRAINT FK_8D1EEB4CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rate_movie ADD CONSTRAINT FK_8D1EEB4C8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id)');
        $this->addSql('CREATE INDEX IDX_8D1EEB4CA76ED395 ON rate_movie (user_id)');
        $this->addSql('CREATE INDEX IDX_8D1EEB4C8F93B6FC ON rate_movie (movie_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE rate_movie_movie (rate_movie_id INT NOT NULL, movie_id INT NOT NULL, INDEX IDX_E9D38A555844A65D (rate_movie_id), INDEX IDX_E9D38A558F93B6FC (movie_id), PRIMARY KEY(rate_movie_id, movie_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE rate_movie_user (rate_movie_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D45EBD5F5844A65D (rate_movie_id), INDEX IDX_D45EBD5FA76ED395 (user_id), PRIMARY KEY(rate_movie_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE rate_movie_movie ADD CONSTRAINT FK_E9D38A555844A65D FOREIGN KEY (rate_movie_id) REFERENCES rate_movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rate_movie_movie ADD CONSTRAINT FK_E9D38A558F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rate_movie_user ADD CONSTRAINT FK_D45EBD5F5844A65D FOREIGN KEY (rate_movie_id) REFERENCES rate_movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rate_movie_user ADD CONSTRAINT FK_D45EBD5FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rate_movie DROP FOREIGN KEY FK_8D1EEB4CA76ED395');
        $this->addSql('ALTER TABLE rate_movie DROP FOREIGN KEY FK_8D1EEB4C8F93B6FC');
        $this->addSql('DROP INDEX IDX_8D1EEB4CA76ED395 ON rate_movie');
        $this->addSql('DROP INDEX IDX_8D1EEB4C8F93B6FC ON rate_movie');
        $this->addSql('ALTER TABLE rate_movie DROP user_id, DROP movie_id');
    }
}
