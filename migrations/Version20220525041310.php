<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220525041310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pet_pet_category (pet_id INT NOT NULL, pet_category_id INT NOT NULL, PRIMARY KEY(pet_id, pet_category_id))');
        $this->addSql('CREATE INDEX IDX_ABB30B5D966F7FB6 ON pet_pet_category (pet_id)');
        $this->addSql('CREATE INDEX IDX_ABB30B5D9492C76E ON pet_pet_category (pet_category_id)');
        $this->addSql('ALTER TABLE pet_pet_category ADD CONSTRAINT FK_ABB30B5D966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pet_pet_category ADD CONSTRAINT FK_ABB30B5D9492C76E FOREIGN KEY (pet_category_id) REFERENCES pet_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pet RENAME COLUMN age TO created_at');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE pet_pet_category');
        $this->addSql('ALTER TABLE pet RENAME COLUMN created_at TO age');
    }
}
