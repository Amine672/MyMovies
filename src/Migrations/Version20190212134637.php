<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190212134637 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE movie ADD rate_movie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26F5844A65D FOREIGN KEY (rate_movie_id) REFERENCES rate_movie (id)');
        $this->addSql('CREATE INDEX IDX_1D5EF26F5844A65D ON movie (rate_movie_id)');
        $this->addSql('ALTER TABLE rate_movie DROP FOREIGN KEY FK_8D1EEB4C8F93B6FC');
        $this->addSql('DROP INDEX IDX_8D1EEB4C8F93B6FC ON rate_movie');
        $this->addSql('ALTER TABLE rate_movie CHANGE movie_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rate_movie ADD CONSTRAINT FK_8D1EEB4CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8D1EEB4CA76ED395 ON rate_movie (user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495844A65D');
        $this->addSql('DROP INDEX IDX_8D93D6495844A65D ON user');
        $this->addSql('ALTER TABLE user DROP rate_movie_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26F5844A65D');
        $this->addSql('DROP INDEX IDX_1D5EF26F5844A65D ON movie');
        $this->addSql('ALTER TABLE movie DROP rate_movie_id');
        $this->addSql('ALTER TABLE rate_movie DROP FOREIGN KEY FK_8D1EEB4CA76ED395');
        $this->addSql('DROP INDEX IDX_8D1EEB4CA76ED395 ON rate_movie');
        $this->addSql('ALTER TABLE rate_movie CHANGE user_id movie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rate_movie ADD CONSTRAINT FK_8D1EEB4C8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id)');
        $this->addSql('CREATE INDEX IDX_8D1EEB4C8F93B6FC ON rate_movie (movie_id)');
        $this->addSql('ALTER TABLE user ADD rate_movie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495844A65D FOREIGN KEY (rate_movie_id) REFERENCES rate_movie (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6495844A65D ON user (rate_movie_id)');
    }
}
