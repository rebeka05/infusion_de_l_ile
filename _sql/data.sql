INSERT INTO type VALUES 
    (1, 'ICE TEA'), 
    (2, 'PATE PHO'), 
    (3, 'THE EN BOITE');

INSERT INTO unite VALUES 
    (1, 'CL'), 
    (2, 'G');

INSERT INTO produit VALUES 
(1, 1, 'THE GLACE AU CITRON ET GINGEMBRE EN BOUTEILLE'),
(2, 1, 'THE GLACE CANNELLE ET GINGEMBRE EN BOUTEILLE'),
(3, 1, 'THE GLACE DETOX EN BOUTEILLE'),
(4, 1, 'THE GLACE AU MIEL EPICE EN BOUTEILLE'),
(5, 2, 'PHO CONGELE MINSAO AU CREVETTE'),
(6, 2, 'PHO CONGELE PATE SECHE GARNI'),
(7, 2, 'PHO CONGELE MINSAO AU POULET'),
(8, 2, 'PHO CONGELE MINSAO AU TSA SIOU'),
(9, 3, 'THE NOIR EN BOITE');

INSERT INTO infoproduit (idproduit, idunite, qte, pu, etat) VALUES 
    (1, 1, 50, 2200, 1),
    (2, 1, 50, 2200, 1),
    (3, 1, 50, 2200, 1),
    (4, 1, 50, 2200, 1),
    (1, 1, 100, 3800, 1),
    (2, 1, 100, 3800, 1),
    (3, 1, 100, 3800, 1),
    (4, 1, 100, 3800, 1),
    (5, 2, 450, 12500, 1),
    (6, 2, 400, 8000, 1),
    (7, 2, 450, 10000, 1),
    (8, 2, 450, 12500, 1),
    (9, 2, 100, 7000, 1);

INSERT INTO modepaiement (nom) VALUES 
    ('Espece'), 
    ('Cheque'), 
    ('Mobile money'), 
    ('Virement'), 
    ('Autres');

INSERT INTO banque (nom) VALUES
    ('BOA'),
    ('BNI'),
    ('SBM'),
    ('BFV'),
    ('MCB'),
    ('Acces Banque'),
    ('BMOI');

INSERT INTO responsable (nom, contact) VALUES 
    ('Pierre', '0345472148');

update infoproduit set photo='produit/miel-epice.jpg' where idproduit=4;
update infoproduit set photo='produit/detox.jpg' where idproduit=3;
update infoproduit set photo='produit/gingembre-cannelle.jpg' where idproduit=2;
update infoproduit set photo='produit/gingembre-citron.jpg' where idproduit=1;
update infoproduit set photo='produit/misao.jpg' where idproduit>4;
update infoproduit set photo='produit/the-noir.jpg' where idproduit>8;

INSERT INTO quartier (nom) VALUES ('Quartier1'), ('Quartier2'), ('Quartier3'), ('Quartier4'), ('Quartier5');

INSERT INTO lieu (idquartier, nom) VALUES 
    (1, 'Lieu1'),
    (2, 'Lieu2'),
    (3, 'Lieu3'),
    (4, 'Lieu4'),
    (5, 'Lieu5');

update lieu set nom='Ankorondrano' where idlieu=1;
update lieu set nom='Tanjombato' where idlieu=2;
update lieu set nom='By Pass' where idlieu=3;
update lieu set nom='Analakely' where idlieu=4;
update lieu set nom='Ankorondrano' where idlieu=5;

update modepaiement set nom='Espece' where idmodepaiement=1;
update modepaiement set nom='Cheque' where idmodepaiement=2;
update modepaiement set nom='Mobile money' where idmodepaiement=3;
update modepaiement set nom='Virement' where idmodepaiement=4;
update modepaiement set nom='Autres' where idmodepaiement=5;



INSERT INTO client (nom, nif, stat) VALUES 
    ('Jovena', 'NIF1', 'Stat1'),
    ('Shell', 'NIF2', 'Stat2'),
    ('Total', 'NIF3', 'Stat3'),
    ('Ulys', 'NIF4', 'Stat4'),
    ('Jumbo', 'NIF5', 'Stat5');

INSERT INTO infoclient (idclient, idlieu) VALUES 
    (1, 1),
    (2, 2),
    (3, 3),
    (4, 4),
    (5, 5);

INSERT INTO responsable (nom, contact) VALUES 
    ('Pierre', '0345472148');
    (2, 'Responsable2', 'Contact2'),
    (3, 'Responsable3', 'Contact3'),
    (4, 'Responsable4', 'Contact4'),
    (5, 'Responsable5', 'Contact5');