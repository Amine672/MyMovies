<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190212132610 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE actor (id INT AUTO_INCREMENT NOT NULL, name_actor VARCHAR(30) NOT NULL, lastname_actor VARCHAR(30) NOT NULL, birthdate_actor DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE actor_movie (actor_id INT NOT NULL, movie_id INT NOT NULL, INDEX IDX_39DA19FB10DAF24A (actor_id), INDEX IDX_39DA19FB8F93B6FC (movie_id), PRIMARY KEY(actor_id, movie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE director (id INT AUTO_INCREMENT NOT NULL, name_director VARCHAR(30) NOT NULL, lastname_director VARCHAR(30) NOT NULL, birthdate_director DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, name_genre VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre_movie (genre_id INT NOT NULL, movie_id INT NOT NULL, INDEX IDX_A058EDAA4296D31F (genre_id), INDEX IDX_A058EDAA8F93B6FC (movie_id), PRIMARY KEY(genre_id, movie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie (id INT AUTO_INCREMENT NOT NULL, director_id INT NOT NULL, title VARCHAR(50) NOT NULL, duration INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_1D5EF26F899FB366 (director_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rate (id INT AUTO_INCREMENT NOT NULL, top_id INT DEFAULT NULL, rate INT NOT NULL, INDEX IDX_DFEC3F39C82CB256 (top_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE top (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, name_top VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_1ED91FCA67B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE top_movie (top_id INT NOT NULL, movie_id INT NOT NULL, INDEX IDX_88415B1BC82CB256 (top_id), INDEX IDX_88415B1B8F93B6FC (movie_id), PRIMARY KEY(top_id, movie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, rate_id INT DEFAULT NULL, name_user VARCHAR(30) NOT NULL, lastname_user VARCHAR(30) NOT NULL, email VARCHAR(60) NOT NULL, password VARCHAR(60) NOT NULL, INDEX IDX_8D93D649BC999F9F (rate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actor_movie ADD CONSTRAINT FK_39DA19FB10DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE actor_movie ADD CONSTRAINT FK_39DA19FB8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE genre_movie ADD CONSTRAINT FK_A058EDAA4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE genre_movie ADD CONSTRAINT FK_A058EDAA8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26F899FB366 FOREIGN KEY (director_id) REFERENCES director (id)');
        $this->addSql('ALTER TABLE rate ADD CONSTRAINT FK_DFEC3F39C82CB256 FOREIGN KEY (top_id) REFERENCES top (id)');
        $this->addSql('ALTER TABLE top ADD CONSTRAINT FK_1ED91FCA67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE top_movie ADD CONSTRAINT FK_88415B1BC82CB256 FOREIGN KEY (top_id) REFERENCES top (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE top_movie ADD CONSTRAINT FK_88415B1B8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BC999F9F FOREIGN KEY (rate_id) REFERENCES rate (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actor_movie DROP FOREIGN KEY FK_39DA19FB10DAF24A');
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26F899FB366');
        $this->addSql('ALTER TABLE genre_movie DROP FOREIGN KEY FK_A058EDAA4296D31F');
        $this->addSql('ALTER TABLE actor_movie DROP FOREIGN KEY FK_39DA19FB8F93B6FC');
        $this->addSql('ALTER TABLE genre_movie DROP FOREIGN KEY FK_A058EDAA8F93B6FC');
        $this->addSql('ALTER TABLE top_movie DROP FOREIGN KEY FK_88415B1B8F93B6FC');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BC999F9F');
        $this->addSql('ALTER TABLE rate DROP FOREIGN KEY FK_DFEC3F39C82CB256');
        $this->addSql('ALTER TABLE top_movie DROP FOREIGN KEY FK_88415B1BC82CB256');
        $this->addSql('ALTER TABLE top DROP FOREIGN KEY FK_1ED91FCA67B3B43D');
        $this->addSql('DROP TABLE actor');
        $this->addSql('DROP TABLE actor_movie');
        $this->addSql('DROP TABLE director');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE genre_movie');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE rate');
        $this->addSql('DROP TABLE top');
        $this->addSql('DROP TABLE top_movie');
        $this->addSql('DROP TABLE user');
    }
}
