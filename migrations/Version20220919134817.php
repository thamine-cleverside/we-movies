<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220919134817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add tables Movie and Gender';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE gender_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE movie_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE gender (id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE movie (id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, year DATE NOT NULL, rating JSON NOT NULL, cover VARCHAR(255) NOT NULL, trailer VARCHAR(255) NOT NULL, producer JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE movie_gender (movie_id INT NOT NULL, gender_id INT NOT NULL, PRIMARY KEY(movie_id, gender_id))');
        $this->addSql('CREATE INDEX IDX_3E8097378F93B6FC ON movie_gender (movie_id)');
        $this->addSql('CREATE INDEX IDX_3E809737708A0E0 ON movie_gender (gender_id)');
        $this->addSql('ALTER TABLE movie_gender ADD CONSTRAINT FK_3E8097378F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movie_gender ADD CONSTRAINT FK_3E809737708A0E0 FOREIGN KEY (gender_id) REFERENCES gender (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE gender_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE movie_id_seq CASCADE');
        $this->addSql('ALTER TABLE movie_gender DROP CONSTRAINT FK_3E8097378F93B6FC');
        $this->addSql('ALTER TABLE movie_gender DROP CONSTRAINT FK_3E809737708A0E0');
        $this->addSql('DROP TABLE gender');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE movie_gender');
    }
}
