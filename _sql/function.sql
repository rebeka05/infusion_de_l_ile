CREATE OR REPLACE FUNCTION get_dates_of_month(p_month INT, p_year INT)
RETURNS TABLE(date DATE) AS $$
BEGIN
    RETURN QUERY
    WITH date_range AS (
        SELECT 
            make_date(p_year, p_month, 1) AS start_date,
            (make_date(p_year, p_month, 1) 
            + INTERVAL '1 month - 1 day')::date AS end_date
    )
    SELECT generate_series(start_date, end_date, INTERVAL '1 day')::date AS date
    FROM date_range;
END;
$$ LANGUAGE plpgsql;
SELECT * FROM get_dates_of_month(2, 2024);


-- SELECT id::INT, designation::VARCHAR, prix::DOUBLE PRECISION, qualite::INT, categorie::VARCHAR
--     FROM detail_produit
--     WHERE to_tsvector(''french'', detail_produit.categorie || '' '') @@ plainto_tsquery(''french'', ''' ||
--             mots_concat || ''')
--     OR to_tsvector(''french'', detail_produit.prix || '' '' || detail_produit.qualite) @@
--         plainto_tsquery(''french'', ''' || mots_concat || ''')
--         OR similarity_dist(detail_produit.categorie, ''' || phrase || ''') =
--             (SELECT MIN(similarity_dist(detail_produit.categorie, ''' || phrase || ''')) FROM detail_produit)
--     OR (' || mots_like || ')
--     ORDER BY ' || colonne_tri || ' ' || operation_tri;