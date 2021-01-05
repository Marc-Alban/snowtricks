<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210105081504 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP user_id, DROP trick_id');
        $this->addSql('ALTER TABLE images DROP trick_id');
        $this->addSql('ALTER TABLE tricks DROP user_id, DROP category_id, DROP main_image_id');
        $this->addSql('ALTER TABLE videos DROP trick_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments ADD user_id INT NOT NULL, ADD trick_id INT NOT NULL');
        $this->addSql('ALTER TABLE images ADD trick_id INT NOT NULL');
        $this->addSql('ALTER TABLE tricks ADD user_id INT NOT NULL, ADD category_id INT NOT NULL, ADD main_image_id INT NOT NULL');
        $this->addSql('ALTER TABLE videos ADD trick_id INT NOT NULL');
    }
}
