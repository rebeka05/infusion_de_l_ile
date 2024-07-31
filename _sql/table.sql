create table personnel(
    idpersonnel serial primary key,
    login varchar,
    password varchar,
    role integer
);
-- role: 1 saisie, 2 validation, 3 admin
insert into personnel (login, password, role) values ('ice.tea.naturel@gmail.com', '0000', 3);
-- insert into personnel (login, password, role) values ('etu1892@gmail.com', '1234', 1);
-- insert into personnel (login, password, role) values ('validation@gmail.com', '1234', 2);
-- insert into personnel (login, password, role) values ('admin@gmail.com', '1234', 3);

create table type(
    idtype serial primary key,
    nom varchar
);

create table unite(
    idunite serial primary key,
    nom varchar
);

create table produit(
    idproduit serial primary key,
    idtype integer references type (idtype),
    nom varchar
);

create table infoproduit(
    idinfoproduit serial primary key,
    idproduit integer references produit (idproduit),
    idunite integer references unite (idunite),
    qte numeric(10,2),
    pu numeric(18,2),
    photo varchar,
    etat integer
);
-- alter table infoproduit add column photo varchar;

create table lieu(
    idlieu serial primary key,
    nom varchar
);

create table modepaiement(
    idmodepaiement serial primary key,
    nom varchar
);

create table client(
    idclient serial primary key,
    nom varchar,
    nif varchar,
    stat varchar
);

create table infoclient(
    idinfoclient serial primary key,
    idclient integer references client (idclient),
    idlieu integer references lieu (idlieu),
    entite varchar
);

create table responsable(
    idresponsable serial primary key,
    nom varchar,
    contact varchar
);

create table vente(
    idvente serial primary key,
    idinfoclient integer references infoclient (idinfoclient),
    idclient integer references client (idclient),
    idlieu integer references lieu (idlieu),
    datevente date,
    ref varchar,
    nbdc varchar,
    responsable varchar,
    contact varchar,
    etat integer,
    datesaisie date
);

create table detailvente(
    iddetailvente serial primary key,
    idvente integer references vente (idvente),
    idinfoproduit integer references infoproduit (idinfoproduit),
    expiration date,
    nombre integer,
    pu numeric(18, 2)
);

create table banque(
    idbanque serial primary key,
    nom varchar
);

create table paiement(
    idpaiement serial primary key,
    idvente integer references vente (idvente),
    idmodepaiement integer references modepaiement (idmodepaiement),
    datepaiement date,
    montant numeric(18, 2),
    idbanque integer references banque (idbanque),
    nom varchar,
    numero varchar,
    datecreation date,
    datesaisie date
);

create table echange(
    idechange serial primary key,
    idinfoclient integer references infoclient (idinfoclient),
    idclient integer references client (idclient),
    idlieu integer references lieu (idlieu),
    idinfoproduit integer references infoproduit (idinfoproduit),
    nombre integer,
    dateechange date,
    expiration date,
    etat integer,
    datesaisie date
);

create table mois (idmois serial primary key, mois varchar);
insert into mois (mois) values 
    ('Janvier'),
    ('Fevrier'),
    ('Mars'),
    ('Avril'),
    ('Mai'),
    ('Juin'),
    ('Juillet'),
    ('Aout'),
    ('Septembre'),
    ('Octobre'),
    ('Novembre'),
    ('Decembre');

create table typesortie(
    idtypesortie serial primary key,
    nomsortie varchar
);

create table sortie(
    idsortie serial primary key,
    idinfoproduit integer references infoproduit (idinfoproduit),
    nombre integer,
    datesortie date,
    datesaisie date
);

create table degustation(
    iddegustation serial primary key,
    idinfoclient integer references infoclient (idinfoclient),
    idclient integer references client (idclient),
    idlieu integer references lieu (idlieu),
    idinfoproduit integer references infoproduit (idinfoproduit),
    nombre integer,
    datedegustation date,
    expiration date,
    -- etat => $etat,
    datesaisie date
);
