<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230106144620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {

        $this->addSql('INSERT INTO `user` (`email`,`roles`,`firstname`, `lastname`,`password`) 
            VALUES 
                ("admin@safer.com", "[\"ROLE_ADMIN\"]", "ADMIN", "FIST", "$2y$13$5tP3ZDAiCpFQqct9FKENuOighbxem7x3jGfH9iBYn7y/x2UjMWUzi")');

        $this->addSql('INSERT INTO `category` (`libelle`, `created_at`) 
            VALUES 
                ("Terrain agricole", "2023-01-01 00:00:00"),
                ("Prairies", "2023-01-01 00:00:00"),
                ("Bois", "2023-01-01 00:00:00"),
                ("Batiments", "2023-01-01 00:00:00"),
                ("Exploitations", "2023-01-01 00:00:00")');

        $this->addSql("
        INSERT INTO `property` (`reference`, `title`, `description`, `country`, `surface`, `price`, `type`, `category_id_id`, `image`, `owner`) VALUES
            ('1703017', 'Activites Equestres, Apiculture, Chasse,', 'Propriete Charente-Maritime', '17200', '17Ha', '330000', 'Vente', 4, '34AG10897.jpg', 'John Doe'),
            ('1907118', 'FERME 100% HERBAGERE/ ELEVAGE LAITIER', 'Situee e l\'oree d\'un bourg, e 10 minutes des services et commerces', '35200', '34Ha', '950', 'Location', 4, '34AG10897.jpg', 'John Doe'),
            ('2316104', 'Propriete Creuse', 'Dans un hameau e moins de 10 minutes d\'un bourg avec services et commerces, et d\'un village ayant un interet touristique sur les routes de St-Jacques-de-Compostelle.', '23320', '1Ha55', '860', 'Location', 2, '34AG10897.jpg', 'John Doe'),
            ('30VI9700', 'Propriete Gard', 'Ensemble immobilier proche d\'un plan d\'eau amenage', '34290', '29Ha', '2000', 'Location', 4, '34AG10897.jpg', 'John Doe'),
            ('313453DR', 'Ideal societe de chasse', 'Terrain boise classe ONF', '22700', '35Ha', '120000', 'Vente', 3, '34AG10897.jpg', 'John Doe'),
            ('344334UJ', 'Sapiniere', 'Sapiniere en cours de bail, cherche reprise', '35200', '1,8Ha', '800', 'Location', 3, '34AG10897.jpg', 'John Doe'),
            ('345E7EG', 'Bois sur pied', 'Diverses essences sur place', '29510', '6Ha', '30000', 'Vente', 3, '34AG10897.jpg', 'John Doe'),
            ('34AG10897', 'Tourisme rural-hebergement', 'Au nord de l\'Herault, proche des axes routiers et e 45 minutes de Montpellier', '34070', '1Ha90', '1 490 000', 'Vente', 2, '34AG10897.jpg', 'John Doe'),
            ('34VI6979', 'Propriete viticole et sa cave', 'Au ceur de l\'appellation Saint-Chinian', '34280', '30Ha', '1 500 000', 'Vente', 2, '34AG10897.jpg', 'John Doe'),
            ('38TB22187', 'Vallons du Voironnais', '13 Ha de terrain', '38500', '13Ha', '2000', 'Location', 5, '34AG10897.jpg', 'John Doe'),
            ('43LM220118', 'Prairies en pays glazik', 'Usage petits animaux type caprins', '29510', '1ha22', '15000', 'Vente', 1, '34AG10897.jpg', 'John Doe'),
            ('44 22 AN 08', 'Betiments avicoles e transmettre', 'Site avicole e transmettre sur la commune de Nort-sur-Erdre, au nord de Nantes.', '44220', '2Ha', '200000', 'Vente', 2, '34AG10897.jpg', 'John Doe'),
            ('47.06.098', 'PRET A USAGE sur 95 ha - PLAINE DES VOSGES ', ' A 5 min de Villeneuve-sur-Lot', '47300', '14Ha', '11000', 'Location', 5, '34AG10897.jpg', 'John Doe'),
            ('48EL11345', 'Propriete Lozere', 'Ensemble beti avec environ 1ha55', '48370', '1Ha55', '700', 'Location', 2, '34AG10897.jpg', 'John Doe'),
            ('48RE11201', 'Situe e 15 minutes de Mende', 'ideal pour polyculture sur 14 ha', '30430', '10Ha', '1300', 'Location', 5, '34AG10897.jpg', 'John Doe'),
            ('55VS', 'Propriete Meuse', 'FERME DE COURUPT : Secteur Sainte-Menehould / Clermont-en-Argonne / Revigny', '88340', '59Ha', 'Nous consulter', 'Location', 4, '34AG10897.jpg', 'John Doe'),
            ('5667DB', 'Ancienne ferme equestre en ruine', 'Terrains actuellement loues', '29510', '12Ha', '156000', 'Vente', 5, '34AG10897.jpg', 'John Doe'),
            ('64.02.59', 'Productions vegetales', 'La parcelle se situe dans le Bearn sur la commune de LAGOR.', '64150', '2Ha', '7700', 'Vente', 1, '34AG10897.jpg', 'John Doe'),
            ('64.03.60', 'Propriete situee dans un secteur vallonne', 'Propriete Pyrenees-Atlantiques', '23500', '6Ha', '650', 'Location', 2, '34AG10897.jpg', 'John Doe'),
            ('65.23.876', 'Terrain classe T4', 'cloture et partiellement boise', '56500', '1,2Ha', '500', 'Location', 3, '34AG10897.jpg', 'John Doe'),
            ('7629CA', 'Prairies sur les plateaux', 'Parcelle de terre labourable d\'environ 2 ha', '81090', '76Ha', '400000', 'Vente', 1, '34AG10897.jpg', 'John Doe'),
            ('765DN', 'Prairies orientees nord ouest', 'Lot d\'un seul tenant', '56500', '11Ha', '113000', 'Vente', 1, '34AG10897.jpg', 'John Doe'),
            ('76RZDC', 'Terrain proche cours d\'eau', 'Non accessible par la route, uniquement chemin d\'exploitation', '35200', '5,5Ha', '3000', 'Location', 1, '34AG10897.jpg', 'John Doe'),
            ('81EL11100', 'Secteur du Segala-Viaur', 'les secteurs les plus en pente sont empieres', '12200', '54Ha', '400000', 'Vente', 3, '34AG10897.jpg', 'John Doe'),
            ('88 FB ', 'Vittel Dombrot : Ouest vosgien, secteur de VITTEL', 'Terrains d\'environ 6,5 ha', '88170', '6,5Ha', 'Nous consulter', 'Vente', 5, '34AG10897.jpg', 'John Doe'),
            ('9875RDC', 'Terrain avec abri', 'Pour proprietaire equin', '44110', '1,2Ha', '1200', 'Location', 1, '34AG10897.jpg', 'John Doe'),
            ('AA 72 22 0088 R', 'Exploitation Agricole specialisee en polyculture elevage', 'Exploitation situee dans le Sud Est de La Sarthe, entre la commune d\'Ecommoy (72220) et Sarce (72327)', '72220', '87Ha', 'a', 'Vente', 4, '34AG10897.jpg', 'John Doe'),
            ('MQ14170356 ', 'Propriete Calvados', 'JFD : Noue de Sienne (14)', '14380', '17Ha', '173 440', 'Vente', 4, '34AG10897.jpg', 'John Doe'),
            ('QDSGF56', 'Bois domainial', 'Bois accessible avec sentiers', '44110', '32Ha', '12000', 'Location', 3, '34AG10897.jpg', 'John Doe'),
            ('Z34.345.45', 'Legerement en Pente', 'Ideal paturage moutons', '22700', '3,4Ha', '2400', 'Location', 1, '34AG10897.jpg', 'John Doe');
        ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
