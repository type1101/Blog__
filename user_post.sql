/* ========================================================= */
/*  UTILISATEURS DE TEST (mot de passe : test123)            */
/* ========================================================= */

INSERT INTO users (username, email, password, role) VALUES
(
    'admin',
    'admin@blog.fr',
    '$2y$10$jAF5gKVlhw8sATfFeN.YqODEyZWbSTc49XLQIqWxcF8ava1NTWHhu',
    'admin'
),
(
    'alice',
    'alice@blog.fr',
    '$2y$10$jAF5gKVlhw8sATfFeN.YqODEyZWbSTc49XLQIqWxcF8ava1NTWHhu',
    'user'
),
(
    'bob',
    'bob@blog.fr',
    '$2y$10$jAF5gKVlhw8sATfFeN.YqODEyZWbSTc49XLQIqWxcF8ava1NTWHhu',
    'user'
);

/* ========================================================= */
/*  POSTS DE TEST                                            */
/* ========================================================= */

INSERT INTO posts (user_id, title, content, image_path) VALUES

(
    1,
    'Fortnite : toujours aussi populaire',
    'Fortnite est un jeu vidéo de type battle royale qui continue de rassembler des millions de joueurs à travers le monde. Grâce à ses mises à jour régulières, ses événements en direct et ses collaborations avec des licences célèbres, le jeu reste constamment renouvelé. Que ce soit pour la compétition ou pour le fun, Fortnite offre une expérience accessible et dynamique qui plaît autant aux débutants qu’aux joueurs confirmés.',
    NULL
),

(
    2,
    'Les mangas : un phénomène mondial',
    'Les mangas ne sont plus seulement un produit culturel japonais, ils sont devenus un véritable phénomène mondial. Des séries comme One Piece, Naruto ou Attack on Titan ont marqué plusieurs générations de lecteurs. Les mangas abordent des thèmes variés allant de l’action à la philosophie, ce qui explique leur popularité croissante dans de nombreux pays.',
    NULL
),

(
    3,
    'Les intelligences artificielles en pleine expansion',
    'Les intelligences artificielles occupent aujourd’hui une place centrale dans le monde numérique. Elles sont utilisées dans de nombreux domaines comme la médecine, les jeux vidéo, ou encore la création de contenu. Les modèles récents permettent de générer du texte, des images et même du code, ouvrant ainsi de nouvelles perspectives mais soulevant aussi des questions éthiques importantes.',
    NULL
);