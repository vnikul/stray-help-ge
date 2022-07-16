<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220716081228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pet ADD owner_id UUID not null');
        $this->addSql('COMMENT ON COLUMN pet.owner_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B857E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E4529B857E3C61F9 ON pet (owner_id)');
        $this->addSql('ALTER TABLE pet_pet_category DROP CONSTRAINT fk_pet_id');
        $this->addSql('ALTER TABLE pet_pet_category ADD CONSTRAINT FK_ABB30B5D966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pet DROP CONSTRAINT FK_E4529B857E3C61F9');
        $this->addSql('DROP INDEX IDX_E4529B857E3C61F9');
        $this->addSql('ALTER TABLE pet DROP owner_id');
        $this->addSql('ALTER TABLE pet_pet_category DROP CONSTRAINT FK_ABB30B5D966F7FB6');
        $this->addSql('ALTER TABLE pet_pet_category ADD CONSTRAINT fk_pet_id FOREIGN KEY (pet_id) REFERENCES pet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
