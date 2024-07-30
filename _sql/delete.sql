CREATE OR REPLACE FUNCTION reset_tables()
RETURNS void AS $$
BEGIN
    -- Désactiver tous les déclencheurs sur la table
    ALTER TABLE quartier DISABLE TRIGGER ALL;
    ALTER TABLE lieu DISABLE TRIGGER ALL;
    ALTER TABLE client DISABLE TRIGGER ALL;
    ALTER TABLE detailvente DISABLE TRIGGER ALL;
    ALTER TABLE responsable DISABLE TRIGGER ALL;
    ALTER TABLE vente DISABLE TRIGGER ALL;
    ALTER TABLE infoclient DISABLE TRIGGER ALL;
    ALTER TABLE paiement DISABLE TRIGGER ALL;
    ALTER TABLE echange DISABLE TRIGGER ALL;

    -- Supprimer toutes les lignes de la table
    DELETE FROM quartier;
    DELETE FROM lieu;
    DELETE FROM client;
    DELETE FROM detailvente;
    DELETE FROM responsable;
    DELETE FROM vente;
    DELETE FROM infoclient;
    DELETE FROM paiement;
    DELETE FROM echange;

    -- Réinitialiser la séquence à 1
    ALTER SEQUENCE quartier_idquartier_seq RESTART WITH 1;
    ALTER SEQUENCE lieu_idlieu_seq RESTART WITH 1;
    ALTER SEQUENCE client_idclient_seq RESTART WITH 1;
    ALTER SEQUENCE detailvente_iddetailvente_seq RESTART WITH 1;
    ALTER SEQUENCE responsable_idresponsable_seq RESTART WITH 1;
    ALTER SEQUENCE vente_idvente_seq RESTART WITH 1;
    ALTER SEQUENCE infoclient_idinfoclient_seq RESTART WITH 1;
    ALTER SEQUENCE paiement_idpaiement_seq RESTART WITH 1;
    ALTER SEQUENCE echange_idechange_seq RESTART WITH 1;

    -- Réactiver les déclencheurs sur la table
    ALTER TABLE quartier ENABLE TRIGGER ALL;
    ALTER TABLE lieu ENABLE TRIGGER ALL;
    ALTER TABLE client ENABLE TRIGGER ALL;
    ALTER TABLE detailvente ENABLE TRIGGER ALL;
    ALTER TABLE responsable ENABLE TRIGGER ALL;
    ALTER TABLE vente ENABLE TRIGGER ALL;
    ALTER TABLE infoclient ENABLE TRIGGER ALL;
    ALTER TABLE paiement ENABLE TRIGGER ALL;
    ALTER TABLE echange ENABLE TRIGGER ALL;
END;
$$ LANGUAGE plpgsql;

-- select reset_tables();