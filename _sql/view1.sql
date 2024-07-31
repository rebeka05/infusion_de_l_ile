create or replace view v_produit as
    select idinfoproduit, i.idproduit, p.idtype, p.nom, qte, u.nom as unite, pu, i.photo, t.nom as type 
    from infoproduit i
    join produit p on p.idproduit=i.idproduit
    join unite u on u.idunite=i.idunite
    join type t on t.idtype=p.idtype
    where i.etat=1
    order by idinfoproduit;

create or replace view v_lieuclient as
    select i.*, l.nom
    from infoclient i
    join lieu l on l.idlieu=i.idlieu
    order by idclient;

create or replace view v_montant_vente as
    select v.idvente, v.idinfoclient, v.idclient, v.idlieu, v.datevente, v.ref, v.nbdc, v.responsable, v.contact, sum(nombre*pu) as total
    from vente v
    join detailvente dv on dv.idvente=v.idvente
    where v.etat=1
    group by v.idvente, v.idinfoclient, v.idclient, v.idlieu, v.datevente, v.ref, v.nbdc, v.responsable, v.contact;

create or replace view v_paiement as
    select v.idvente, v.idinfoclient, i.entite, v.idclient, c.nom as client, v.idlieu, l.nom as lieu, v.datevente, v.ref, v.nbdc, v.responsable, v.contact, v.total, coalesce(sum(montant), 0) as paye, v.total-coalesce(sum(montant), 0) as reste
    from v_montant_vente v
    left join paiement p on p.idvente=v.idvente
    join client c on c.idclient=v.idclient
    join lieu l on l.idlieu=v.idlieu
    join infoclient i on i.idlieu=l.idlieu and i.idclient=c.idclient
    group by v.idvente, v.idinfoclient, i.entite, v.idclient, c.nom, v.idlieu, l.nom, v.datevente, v.ref, v.nbdc, v.responsable, v.contact, v.total;

create or replace view v_echange_non_valide as
    select e.*, c.nom as client, l.nom as lieu, i.entite, v.nom as produit, v.qte, v.unite, v.pu , v.type
    from echange e
    join client c on e.idclient=c.idclient
    join lieu l on e.idlieu=l.idlieu
    join infoclient i on i.idlieu=l.idlieu and i.idclient=c.idclient
    join v_produit v on e.idinfoproduit=v.idinfoproduit
    where e.etat=0
    order by dateechange;

create or replace view v_vente_non_valide as
    select v.idvente, v.idinfoclient, i.entite, v.idclient, c.nom as client, v.idlieu, l.nom as lieu, extract (month from v.datevente) as idmois, extract (year from v.datevente) as annee, v.datevente, v.ref, v.nbdc, v.responsable, v.contact, sum(nombre*pu) as total
    from vente v
    join detailvente dv on dv.idvente=v.idvente
    join client c on c.idclient=v.idclient
    join lieu l on l.idlieu=v.idlieu
    join infoclient i on i.idinfoclient=v.idinfoclient
    where v.etat=0
    group by v.idvente, v.idinfoclient, i.entite, v.idclient, c.nom, v.idlieu, l.nom, extract (month from v.datevente), extract (year from v.datevente), v.datevente, v.ref, v.nbdc, v.responsable, v.contact
    order by v.datevente desc;

create or replace view v_vente_valide as
    select v.idvente, v.idinfoclient, i.entite, v.idclient, c.nom as client, v.idlieu, l.nom as lieu, extract (month from v.datevente) as idmois, extract (year from v.datevente) as annee, v.datevente, v.ref, v.nbdc, v.responsable, v.contact, sum(nombre*pu) as total
    from vente v
    join detailvente dv on dv.idvente=v.idvente
    join client c on c.idclient=v.idclient
    join lieu l on l.idlieu=v.idlieu
    join infoclient i on i.idinfoclient=v.idinfoclient
    where v.etat=1
    group by v.idvente, v.idinfoclient, i.entite, v.idclient, c.nom, v.idlieu, l.nom, extract (month from v.datevente), extract (year from v.datevente), v.datevente, v.ref, v.nbdc, v.responsable, v.contact
    order by v.datevente desc;

create or replace view v_detailvente as
    select d.*, v.nom, v.qte, v.unite 
    from detailvente d 
    join v_produit v on v.idinfoproduit=d.idinfoproduit;

create or replace view v_liste_paiement as
    select p.idpaiement, v.idvente, v.ref, v.nbdc, c.idclient, c.nom as client, l.idlieu, l.nom as lieu, i.entite, p.idmodepaiement, m.nom as modepaiement, p.montant, extract (month from p.datepaiement) as idmois, extract (year from p.datepaiement) as annee, p.datepaiement
    from paiement p
    join vente v on v.idvente=p.idvente
    join client c on c.idclient=v.idclient
    join lieu l on l.idlieu=v.idlieu
    join infoclient i on i.idlieu=l.idlieu and i.idclient=c.idclient
    join modepaiement m on m.idmodepaiement=p.idmodepaiement
    order by v.idvente asc, p.datepaiement desc;

create or replace view v_etat_vente as
    select idmois, annee, idinfoclient, entite, idclient, client, idlieu, lieu, responsable, contact, datevente, coalesce(sum(total), 0) as total
    from v_vente_valide
    group by idmois, annee, idinfoclient, entite, idclient, client, idlieu, lieu, responsable, contact, datevente
    order by idmois;

create or replace view v_etat_vente_produit as
    select v.idvente, idinfoproduit, pu*nombre as total, idmois, annee
    from v_vente_valide v
    join detailvente dv on dv.idvente=v.idvente;

create or replace view v_etat_vente_mensuel_entite as
    select idmois, annee, datevente, idinfoclient, idclient, idlieu, total
    from v_vente_valide;

create or replace view v_etatentite_annuel as
    SELECT  
        c.idclient, c.nom,  m.idmois,  m.mois,  a.annee, COALESCE(SUM(v.total), 0) AS total
    FROM  client c 
    CROSS JOIN  mois m
    CROSS JOIN  (SELECT DISTINCT EXTRACT(YEAR FROM datevente) AS annee FROM vente) a
    LEFT JOIN  v_vente_valide v 
        ON  v.idclient = c.idclient  
        AND m.idmois = EXTRACT(MONTH FROM v.datevente) 
        AND a.annee = EXTRACT(YEAR FROM v.datevente)
    GROUP BY  c.idclient, c.nom,  m.idmois,  m.mois,  a.annee
    ORDER BY   a.annee,  m.idmois,  c.idclient;

create or replace view v_etatproduit_annuel as
    SELECT  
        c.idinfoproduit, c.nom, c.qte, c.unite, c.pu,  m.idmois,  m.mois,  a.annee, COALESCE(SUM(dv.pu*dv.nombre), 0) AS total
    FROM  v_produit c 
    CROSS JOIN  mois m
    CROSS JOIN  (SELECT DISTINCT EXTRACT(YEAR FROM datevente) AS annee FROM vente) a
    LEFT JOIN  v_vente_valide v 
        ON m.idmois = EXTRACT(MONTH FROM v.datevente) 
        AND a.annee = EXTRACT(YEAR FROM v.datevente)
    left join detailvente dv on v.idvente=dv.idvente and c.idinfoproduit=dv.idinfoproduit
    GROUP BY  c.idinfoproduit, c.nom, c.qte, c.unite, c.pu,  m.idmois,  m.mois,  a.annee
    ORDER BY   a.annee,  m.idmois,  c.idinfoproduit;

create or replace view v_vente_client_mensuel as
    SELECT m.idmois,  m.mois,  a.annee, c.idclient, c.idinfoclient, c.entite, c.idlieu, p.idinfoproduit, p.nom, p.qte, p.unite, p.pu, COALESCE(SUM(dv.nombre), 0) as nombre, COALESCE(SUM(dv.pu * dv.nombre), 0) AS total
    FROM v_lieuclient c
    CROSS JOIN  mois m
    CROSS JOIN  (SELECT DISTINCT EXTRACT(YEAR FROM datevente) AS annee FROM vente) a
    CROSS JOIN v_produit p
    LEFT JOIN  v_vente_valide v 
        ON m.idmois = EXTRACT(MONTH FROM v.datevente) 
        AND a.annee = EXTRACT(YEAR FROM v.datevente)
        AND v.idclient = c.idclient
        AND v.idlieu = c.idlieu
    LEFT JOIN detailvente dv ON v.idvente = dv.idvente AND p.idinfoproduit = dv.idinfoproduit
    GROUP BY m.idmois,  m.mois,  a.annee, c.idclient, c.idinfoclient, c.entite, c.idlieu, p.idinfoproduit, p.nom, p.qte, p.unite, p.pu
    ORDER BY   a.annee,  m.idmois, c.idclient, c.idlieu,  p.idinfoproduit;

create or replace view v_total_produit_mensuel as
    SELECT  
        c.idinfoproduit, c.nom, c.qte, c.unite, c.pu,  m.idmois, a.annee, l.idclient, l.nom as client, COALESCE(SUM(dv.nombre), 0) AS nombre, COALESCE(SUM(dv.pu*dv.nombre), 0) AS total
    FROM  v_produit c 
    CROSS JOIN  mois m
    CROSS JOIN  (SELECT DISTINCT EXTRACT(YEAR FROM datevente) AS annee FROM vente) a
    cross join client l
    LEFT JOIN  v_vente_valide v 
        ON m.idmois = EXTRACT(MONTH FROM v.datevente) 
        AND a.annee = EXTRACT(YEAR FROM v.datevente)
        and l.idclient = v.idclient
    left join detailvente dv on v.idvente=dv.idvente and c.idinfoproduit=dv.idinfoproduit
    GROUP BY  c.idinfoproduit, c.nom, c.qte, c.unite, c.pu,  m.idmois, a.annee, l.idclient,  l.nom
    ORDER BY   a.annee,  m.idmois,  c.idinfoproduit, l.idclient;

create or replace view v_etat_vente_paye as
    select v.idclient, v.idlieu, lieu, entite, extract(month from datepaiement) as idmois, extract(year from datepaiement) as annee, sum(montant) as total
    from paiement 
    join v_vente_valide v on paiement.idvente=v.idvente
    group by v.idclient, v.idlieu, lieu, entite, extract(month from datepaiement), extract(year from datepaiement);

create or replace view v_etatLivraison as
    select s.datesortie, s.idinfoproduit, vp.nom, vp.qte, vp.unite, s.nombre, coalesce(sum(d.nombre), 0) as vendu, coalesce(e.nombre, 0) as echange, coalesce(dg.nombre, 0) as degustation, s.nombre - (coalesce(sum(d.nombre), 0) + coalesce(e.nombre, 0) + coalesce(dg.nombre, 0)) as reste
    from sortie s
    join v_produit vp on vp.idinfoproduit=s.idinfoproduit
    left join v_vente_valide v on v.datevente=s.datesortie
    left join detailvente d on d.idvente=v.idvente and d.idinfoproduit=s.idinfoproduit
    left join (
        SELECT idinfoproduit, dateechange, SUM(nombre) AS nombre
        FROM echange
        GROUP BY idinfoproduit, dateechange
    ) e on s.datesortie=e.dateechange and s.idinfoproduit=e.idinfoproduit
    left join (
        sELECT idinfoproduit, datedegustation, SUM(nombre) AS nombre
        FROM degustation
        GROUP BY idinfoproduit, datedegustation
    ) dg on s.datesortie=dg.datedegustation and s.idinfoproduit=dg.idinfoproduit
    group by s.datesortie, s.idinfoproduit, vp.nom, vp.qte, vp.unite, s.nombre, e.nombre, dg.nombre;

create or replace view v_etatechange as
    select extract(month from dateechange) as idmois, extract(year from dateechange) as annee, e.idinfoproduit, e.idinfoclient, i.entite, i.nom as lieu, v.nom as produit, v.qte, v.unite, v.pu, sum(nombre) as nombre, v.pu * sum(nombre) as total
    from echange e
    join v_lieuclient i on i.idinfoclient=e.idinfoclient
    join v_produit v on v.idinfoproduit=e.idinfoproduit
    group by extract(month from dateechange), extract(year from dateechange), e.idinfoproduit, e.idinfoclient, i.entite, i.nom, v.nom, v.qte, v.unite, v.pu;

