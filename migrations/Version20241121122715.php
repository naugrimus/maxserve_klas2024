<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241121122715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, brand_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price NUMERIC(10, 2) NOT NULL, discount_percentage NUMERIC(5, 2) DEFAULT NULL, rating NUMERIC(4, 2) DEFAULT NULL, stock INT NOT NULL, sku VARCHAR(32) NOT NULL, weight INT NOT NULL, width NUMERIC(5, 2) NOT NULL, height NUMERIC(5, 2) NOT NULL, depth NUMERIC(5, 2) NOT NULL, warranty_information VARCHAR(255) NOT NULL, shipping_information VARCHAR(255) NOT NULL, availability_status VARCHAR(255) NOT NULL, return_policy VARCHAR(255) NOT NULL, minimum_order_quantity INT NOT NULL, barcode VARCHAR(255) NOT NULL, qr_code LONGTEXT NOT NULL, thumbnail LONGTEXT NOT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), INDEX IDX_D34A04AD44F5D008 (brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_product_tags (product_id INT NOT NULL, product_tags_id INT NOT NULL, INDEX IDX_6FF094EC4584665A (product_id), INDEX IDX_6FF094EC5CA25404 (product_tags_id), PRIMARY KEY(product_id, product_tags_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_brand (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_category (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_tags (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES product_category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD44F5D008 FOREIGN KEY (brand_id) REFERENCES product_brand (id)');
        $this->addSql('ALTER TABLE product_product_tags ADD CONSTRAINT FK_6FF094EC4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_product_tags ADD CONSTRAINT FK_6FF094EC5CA25404 FOREIGN KEY (product_tags_id) REFERENCES product_tags (id) ON DELETE CASCADE');

        $this->addSql('CREATE UNIQUE INDEX idx_product_title ON product (title)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD44F5D008');
        $this->addSql('ALTER TABLE product_product_tags DROP FOREIGN KEY FK_6FF094EC4584665A');
        $this->addSql('ALTER TABLE product_product_tags DROP FOREIGN KEY FK_6FF094EC5CA25404');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_product_tags');
        $this->addSql('DROP TABLE product_brand');
        $this->addSql('DROP TABLE product_category');
        $this->addSql('DROP TABLE product_tags');
    }
}
