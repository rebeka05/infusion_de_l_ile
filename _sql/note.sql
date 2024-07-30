etat1: 10.000.0000
etat2: 2.000.000
etat3: 1.0000.000
etat4: 4.000.000 (pas: 500.000, 600.000)

echange par année: filtre annee
    ex: janvier: total(montant), fevrier: 120..22,...

infusion-de-l-ile.rf.gd
fkKuSsJxHHY8

-- number_format($vente->total, 2, '.', ' ')

saisie vente
    -- total anle montant rehetra,
    -- vo tsy ampy n quatite na expiration de mamaoka erreur,
    -- idinfoclient,
    -- date expiration a partir an dernier saisie
validation vente:
    -- tout selectionner
    -- modifier -> detailvente de afaka supprimena oatra le ligne ray
paiement: 
    -- reste par defaut ref paiement ray
    vita paiement, mverina eo amle efa filtré
etat non paye: 
    -- eo amn farany ambony asina total anle  
total produit par jour/par mois:
    -- ex: citron CANNELLE 20 (particulier 10, total 10)
saisie sortie livraison:
    -- ex: CANNELLE 50cl 10, ...
    de mapiditra autre (isana degustation)
etat de livraison:
    par rapport anle sortie, firy n reste tsy lafo par prooduit (retour)?
    retour = sum(vente par date) + sum(degustation) : le tsy lafo
    retour: detailler par produit
    mampoitra isan echange

etat de vente payé par mois: 
    -- apoittra daoly ze client nandoh tamn le mois
    -- ex: galana railovy 180.000
    --     total maki 120.000
vente validé: 
    -- voir plus: makan am detail anle vente
-- montant total isakn tableau
-- degustation : mitovy amn echange n saisie
ao amle etat de livraison reste=nombre-(vendu+echange+degustation)
etat d''echange: par date/ par mois:
    -- produit, client (galana railovy), isa
    produit| pu| client (6 max)| montant total


etat non payé:
    (asina dashboard mensuel eo akaikn)
liste des cheques versés et non versés
liste des cheques mbola tsy dispo sy efa (par rapport date de disponibilite)
dashboard echange (par client/ lieu/ mois/ jour/ annee/ produit)
firy pourcent ny echange par rapport amn vente
produit le plus vendu
dashboard etat non paye ()
facture (pdf)
import xl

validation:
- date de reception cheque avy amn client
- asina liste cheque -> de manao oe versé + date de versement
- liste cheque verse -> date de valeur cheque

paiement mbola mila amboarina le cheque
vita paiement, mverina eo amle efa filtré
accueil: liste produit, vo miditra de ao daoly
number format