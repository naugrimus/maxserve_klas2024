<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241123173602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds the thumbnail_local to product';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE product ADD thumbnail_local LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE product DROP thumbnail_local');

    }
}
