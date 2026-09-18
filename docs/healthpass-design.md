# HealthPass — direction UI/UX

## Implémentation

HTML rendu par Laravel Blade, Tailwind CSS 4 compilé par Vite, CSS partagé et JavaScript natif pour la navigation des formulaires. Cette solution conserve les routes, les noms de champs, les jetons CSRF, les téléchargements de justificatifs et les formulaires médecin/service du projet. Aucune dépendance React nécessaire.

Les styles publics sont limités à `.hp-public`, pour éviter de modifier les espaces métier. Sources : `resources/css/app.css`, `resources/js/app.js`, `resources/views/welcome.blade.php` et `resources/views/auth/{login,register,register-doctor,register-service}.blade.php`.

HealthPass est déployé en mono-établissement : la table `ETABLISSEMENT` représente la
configuration de l'instance et n'est plus utilisée comme filtre d'accès ou comme
sélecteur de tenant. Les rôles applicatifs sont super-administrateur, administrateur,
médecin, caissier/facturation et patient. Les tables patient, consultation,
prescription et facture partagent ce périmètre unique.

## Système visuel commun

| Usage | Couleur |
| --- | --- |
| Marque, titres, actions principales | Marine `#182E46` |
| Survol des actions | Bleu ardoise `#284661` |
| Fond principal | Ivoire `#FAF9F6` |
| Surface secondaire | Pierre `#F4F3EF` |
| Formulaires et surfaces | Blanc `#FFFFFF` |
| Texte secondaire | Gris ardoise `#586574` |
| Bordures | `#DADDDF` |
| Bordures des champs | `#CBD0D4` |
| Accent sur fond clair | Bronze `#74603D` |
| Accent sur marine | Or pâle `#CFB782` |
| Focus clavier | Or soutenu `#957942` |

Titres en Plus Jakarta Sans, graisse 600, approche légèrement resserrée ; corps en Inter, taille 16 px et interligne 1,65. Titres d'accueil fluides de 40 à 72 px, titres de formulaire 32 px, titres de section 20 px, labels 14 px. Les polices sont chargées depuis Google Fonts avec repli sans-serif.

Grille d'espacement fondée sur 8 px : champs séparés par 24 px, sections par 32 à 48 px, grandes sections par 96 px. Rayon de 8 px pour les champs et actions, 12 à 16 px pour les surfaces. Ombre presque imperceptible sur le panneau d'accueil ; formulaires sans ombre lourde. Iconographie Material Symbols exclusivement outline, graisse 300.

Focus visible de 3 px avec décalage de 4 px ; champs d'au moins 50 px de hauteur. Survol des champs par renforcement de bordure et des boutons par bleu ardoise. Les transitions sont supprimées lorsque l'utilisateur préfère réduire les animations.

## Accueil

Navigation claire sur fond ivoire, séparée du contenu par un filet discret. Hero sur deux colonnes : badge « Réseau médical sécurisé », titre original en grand format, sous-titre conservé et deux actions. Le bouton principal marine met en avant la création de compte ; l'accès à la connexion reste immédiatement visible.

À droite, un panneau blanc présente les trois points forts sous forme de lignes généreusement espacées, séparées par des filets. Les icônes bronze apportent une touche chaleureuse sans multiplier les couleurs. L'intitulé « Le soin commence par le lien » accompagne ce panneau.

La section À propos adopte un fond pierre avec trois cartes de même poids pour l'écosystème connecté, le suivi plus clair et la confiance durable. Les contenus et les coordonnées de contact existants sont conservés. Sur écran étroit, les colonnes s'empilent et le titre s'adapte sans imposer de largeur fixe.

## Connexion

Composition scindée : 47 % de panneau marine à gauche, formulaire sur ivoire à droite. Le panneau présente la marque, une composition géométrique faite de cercles concentriques et d'icônes de soins, puis le message de sécurité. Aucun visuel photographique ni filtre coloré. L'illustration décorative est masquée aux technologies d'assistance.

Le formulaire est posé directement sur la surface, avec titre aligné à gauche, champs email/mot de passe, récupération du mot de passe et action principale pleine largeur. Les erreurs serveur et messages de réussite sont conservés. Un retour à l'accueil et un accès à la création de compte complètent le parcours. Sur mobile, le panneau décoratif disparaît et le formulaire occupe la largeur disponible.

## Inscription

À gauche, panneau marine avec les choix de profil. La sélection est indiquée par une bordure or, un fond éclairci et une coche ; les boutons exposent leur état via `aria-pressed`. Sur mobile, les choix deviennent des boutons compacts au-dessus du formulaire.

À droite, la présentation du parcours précède un sommaire numéroté cliquable, construit à partir des sections réelles de chaque formulaire. Pour les établissements : informations générales, localisation, contact administratif, documents. Chaque lien rejoint sa section. Il s'agit d'un indicateur de structure, pas d'un pourcentage de complétion : tous les champs restent visibles pour permettre la relecture et la validation native du navigateur.

Les champs sont répartis sur deux colonnes quand l'espace le permet, puis sur une colonne sur mobile. Les justificatifs, la confirmation et les actions finales sont conservés. Les variantes médecin et service utilisent le même système visuel, y compris sur leurs pages dédiées.

## Vérification

Compilation Blade et tests Laravel à exécuter avec `php artisan view:cache` et `php artisan test`. Construction des assets avec `npm run build`. Le rendu navigateur, la navigation clavier et les soumissions réelles des trois profils nécessitent une vérification visuelle et fonctionnelle complémentaire ; les tests existants ne couvrent pas ces parcours.
