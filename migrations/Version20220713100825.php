<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220713100825 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE pet_id_seq CASCADE');
	    $this->addSql('ALTER TABLE pet_pet_category DROP CONSTRAINT FK_ABB30B5D966F7FB6;');
	    $this->addSql('ALTER TABLE pet ADD anthelmintic_given_at DATE DEFAULT NULL');
	    $this->addSql('ALTER TABLE pet ADD anti_flea_given_at DATE DEFAULT NULL');
	    $this->addSql('ALTER TABLE pet ALTER COLUMN id SET DATA TYPE UUID USING (gen_random_uuid());');
	    $this->addSql('ALTER TABLE pet_pet_category ALTER COLUMN pet_id SET DATA TYPE  UUID USING(gen_random_uuid());');
	    $this->addSql('ALTER TABLE pet_pet_category ADD CONSTRAINT FK_PET_ID FOREIGN KEY (pet_id) REFERENCES pet (id);');
	    $this->addSql('ALTER TABLE pet ALTER id DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN pet.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE pet_pet_category ALTER pet_id TYPE UUID');
        $this->addSql('ALTER TABLE pet_pet_category ALTER pet_id DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN pet_pet_category.pet_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE refresh_token ALTER user_id SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE pet_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE pet DROP anthelmintic_given_at');
        $this->addSql('ALTER TABLE pet DROP anti_flea_given_at');
        $this->addSql('ALTER TABLE pet ALTER id TYPE INT');
        $this->addSql('ALTER TABLE pet ALTER id DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN pet.id IS NULL');
        $this->addSql('ALTER TABLE pet_pet_category ALTER pet_id TYPE INT');
        $this->addSql('ALTER TABLE pet_pet_category ALTER pet_id DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN pet_pet_category.pet_id IS NULL');
        $this->addSql('ALTER TABLE refresh_token ALTER user_id DROP NOT NULL');
    }
}
