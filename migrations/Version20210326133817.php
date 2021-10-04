<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210326133817 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(40) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fiche (id INT AUTO_INCREMENT NOT NULL, visiteur_id INT NOT NULL, etat_id INT NOT NULL, mois DATE NOT NULL, INDEX IDX_4C13CC787F72333D (visiteur_id), INDEX IDX_4C13CC78D5E86FF (etat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forfait (id INT AUTO_INCREMENT NOT NULL, fiche_id INT NOT NULL, type_id INT NOT NULL, qte INT NOT NULL, INDEX IDX_BBB5C482DF522508 (fiche_id), INDEX IDX_BBB5C482C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hors_forfait (id INT AUTO_INCREMENT NOT NULL, fiche_id INT NOT NULL, libelle VARCHAR(40) DEFAULT NULL, montant DOUBLE PRECISION DEFAULT NULL, date DATE NOT NULL, est_valide TINYINT(1) DEFAULT NULL, INDEX IDX_7EAEE44DF522508 (fiche_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_frais (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(40) DEFAULT NULL, montant VARCHAR(40) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visiteur (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(40) DEFAULT NULL, prenom VARCHAR(40) DEFAULT NULL, adresse VARCHAR(40) DEFAULT NULL, cp VARCHAR(40) NOT NULL, ville VARCHAR(40) DEFAULT NULL, UNIQUE INDEX UNIQ_4EA587B8F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fiche ADD CONSTRAINT FK_4C13CC787F72333D FOREIGN KEY (visiteur_id) REFERENCES visiteur (id)');
        $this->addSql('ALTER TABLE fiche ADD CONSTRAINT FK_4C13CC78D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE forfait ADD CONSTRAINT FK_BBB5C482DF522508 FOREIGN KEY (fiche_id) REFERENCES fiche (id)');
        $this->addSql('ALTER TABLE forfait ADD CONSTRAINT FK_BBB5C482C54C8C93 FOREIGN KEY (type_id) REFERENCES type_frais (id)');
        $this->addSql('ALTER TABLE hors_forfait ADD CONSTRAINT FK_7EAEE44DF522508 FOREIGN KEY (fiche_id) REFERENCES fiche (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fiche DROP FOREIGN KEY FK_4C13CC78D5E86FF');
        $this->addSql('ALTER TABLE forfait DROP FOREIGN KEY FK_BBB5C482DF522508');
        $this->addSql('ALTER TABLE hors_forfait DROP FOREIGN KEY FK_7EAEE44DF522508');
        $this->addSql('ALTER TABLE forfait DROP FOREIGN KEY FK_BBB5C482C54C8C93');
        $this->addSql('ALTER TABLE fiche DROP FOREIGN KEY FK_4C13CC787F72333D');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE fiche');
        $this->addSql('DROP TABLE forfait');
        $this->addSql('DROP TABLE hors_forfait');
        $this->addSql('DROP TABLE type_frais');
        $this->addSql('DROP TABLE visiteur');
    }
}
