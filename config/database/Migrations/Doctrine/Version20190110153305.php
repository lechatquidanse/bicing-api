<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190110153305 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE station ALTER station_external_data_near_by_external_station_ids DROP NOT NULL');
        $this->addSql('ALTER TABLE station ALTER location_district_code DROP NOT NULL');
        $this->addSql('ALTER TABLE station ALTER location_zip_code DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE station ALTER station_external_data_near_by_external_station_ids SET NOT NULL');
        $this->addSql('ALTER TABLE station ALTER location_zip_code SET NOT NULL');
        $this->addSql('ALTER TABLE station ALTER location_district_code SET NOT NULL');
    }
}
