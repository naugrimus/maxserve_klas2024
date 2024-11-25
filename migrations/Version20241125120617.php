<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241125120617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'rebuilds product tags';
    }

    public function up(Schema $schema): void
    {

        $this->addSql('ALTER TABLE product_product_tags DROP FOREIGN KEY FK_6FF094EC4584665A');
        $this->addSql('ALTER TABLE product_product_tags DROP FOREIGN KEY FK_6FF094EC5CA25404');
        $this->addSql('DROP TABLE product_product_tags');
        $this->addSql('ALTER TABLE product_tags ADD product_id INT DEFAULT NULL, ADD tag VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product_tags ADD CONSTRAINT FK_E254B6874584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_E254B6874584665A ON product_tags (product_id)');
    }

    public function down(Schema $schema): void
    {

        $this->addSql('CREATE TABLE product_product_tags (product_id INT NOT NULL, product_tags_id INT NOT NULL, INDEX IDX_6FF094EC4584665A (product_id), INDEX IDX_6FF094EC5CA25404 (product_tags_id), PRIMARY KEY(product_id, product_tags_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product_product_tags ADD CONSTRAINT FK_6FF094EC4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_product_tags ADD CONSTRAINT FK_6FF094EC5CA25404 FOREIGN KEY (product_tags_id) REFERENCES product_tags (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_tags DROP FOREIGN KEY FK_E254B6874584665A');
        $this->addSql('DROP INDEX IDX_E254B6874584665A ON product_tags');
        $this->addSql('ALTER TABLE product_tags DROP product_id, DROP tag');
    }
}
