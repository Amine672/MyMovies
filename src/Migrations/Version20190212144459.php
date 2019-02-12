<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190212144459 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BC999F9F');
        $this->addSql('CREATE TABLE rate_top (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, top_id INT DEFAULT NULL, rate INT NOT NULL, INDEX IDX_15016013A76ED395 (user_id), INDEX IDX_15016013C82CB256 (top_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rate_top ADD CONSTRAINT FK_15016013A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rate_top ADD CONSTRAINT FK_15016013C82CB256 FOREIGN KEY (top_id) REFERENCES top (id)');
        $this->addSql('DROP TABLE rate');
        $this->addSql('DROP INDEX IDX_8D93D649BC999F9F ON user');
        $this->addSql('ALTER TABLE user DROP rate_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE rate (id INT AUTO_INCREMENT NOT NULL, top_id INT DEFAULT NULL, rate INT NOT NULL, INDEX IDX_DFEC3F39C82CB256 (top_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE rate ADD CONSTRAINT FK_DFEC3F39C82CB256 FOREIGN KEY (top_id) REFERENCES top (id)');
        $this->addSql('DROP TABLE rate_top');
        $this->addSql('ALTER TABLE user ADD rate_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BC999F9F FOREIGN KEY (rate_id) REFERENCES rate (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649BC999F9F ON user (rate_id)');
    }
}
