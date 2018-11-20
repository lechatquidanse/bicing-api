<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180216153134 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE station (station_id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, station_detail_name VARCHAR(255) NOT NULL, station_detail_type VARCHAR(255) CHECK(station_detail_type IN (\'BIKE\',\'ELECTRIC_BIKE\')) NOT NULL, station_external_data_external_station_id VARCHAR(255) NOT NULL, station_external_data_near_by_external_station_ids TEXT NOT NULL, location_address VARCHAR(255) NOT NULL, location_address_number VARCHAR(10) DEFAULT NULL, location_district_code SMALLINT NOT NULL, location_zip_code VARCHAR(5) NOT NULL, location_latitude DOUBLE PRECISION NOT NULL, location_longitude DOUBLE PRECISION NOT NULL, PRIMARY KEY(station_id))');
        $this->addSql('CREATE UNIQUE INDEX unique_station_external_external_station_id ON station (station_external_data_external_station_id)');
        $this->addSql('COMMENT ON COLUMN station.station_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN station.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN station.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN station.station_detail_type IS \'(DC2Type:enum_station_detail_type_type)\'');
        $this->addSql('COMMENT ON COLUMN station.station_external_data_near_by_external_station_ids IS \'(DC2Type:simple_array)\'');
        $this->addSql('CREATE TABLE station_state (stated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, station_assigned_id UUID NOT NULL, available_bike_number SMALLINT NOT NULL, available_slot_number SMALLINT NOT NULL, status VARCHAR(255) CHECK(status IN (\'OPENED\',\'CLOSED\')) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(stated_at, station_assigned_id))');
        $this->addSql('CREATE INDEX IDX_FB15ADCDE26C1F44 ON station_state (station_assigned_id)');
        $this->addSql('COMMENT ON COLUMN station_state.stated_at IS \'(DC2Type:date_time_immutable_stringable)\'');
        $this->addSql('COMMENT ON COLUMN station_state.station_assigned_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN station_state.status IS \'(DC2Type:enum_station_state_status_type)\'');
        $this->addSql('COMMENT ON COLUMN station_state.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE station_state ADD CONSTRAINT FK_FB15ADCDE26C1F44 FOREIGN KEY (station_assigned_id) REFERENCES station (station_id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('CREATE EXTENSION IF NOT EXISTS timescaledb CASCADE;');
        $this->addSql('SELECT create_hypertable(\'station_state\', \'stated_at\')');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE station_state DROP CONSTRAINT FK_FB15ADCDE26C1F44');
        $this->addSql('DROP TABLE station');
        $this->addSql('DROP TABLE station_state');

        $this->addSql('DROP EXTENSION IF  EXISTS timescaledb CASCADE;');
    }
}
