-- Base : footjersey
USE footjersey;

-- Table categories
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Table users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(255),
    role ENUM('user','admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Table products
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    price DECIMAL(10,2) NOT NULL DEFAULT 0,
    stock INT NOT NULL DEFAULT 0,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table carts
CREATE TABLE carts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table cart_items
CREATE TABLE cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price_at_time DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table orders
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    status ENUM('pending','paid','shipped','cancelled') DEFAULT 'pending',
    delivery_address TEXT,
    tracking_number VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table order_items
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table invoices
CREATE TABLE invoices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL UNIQUE,
    user_id INT NOT NULL,
    invoice_number VARCHAR(255) NOT NULL UNIQUE,
    amount DECIMAL(10,2) NOT NULL,
    invoice_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table settlements
CREATE TABLE settlements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    invoice_id INT,
    amount DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(100),
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending','completed','failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Table user_bonuses
CREATE TABLE user_bonuses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    points INT NOT NULL DEFAULT 0,
    bonus_description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Seed catégories
INSERT INTO categories (name, slug) VALUES
('Maillots officiels','maillots-officiels'),
('Sweats & Hoodies','sweats-hoodies'),
('Shorts & Bas','shorts-bas');

-- Seed users
INSERT INTO users (email, password, fullname, role) VALUES
('test@footjersey.test', '$2y$10$e0NRcJw0x/ExampleHashForDemo1234567890abcdEFGH', 'Test User', 'user'),
('admin@footjersey.test', '$2y$10$AdminExampleHashForDemo1234567890AbCdEfG', 'Admin User', 'admin');

-- Seed produits
INSERT INTO products (category_id, name, slug, description, price, stock, image) VALUES
(1, 'Maillot PSG Domicile 24/25', 'psg-domicile-24-25','Maillot officiel PSG, 100% polyester. Design élégant avec le blason du club et les couleurs traditionnelles bleu marine et rouge.', 89.99, 10, 'Psg-dommicile.jpeg'),
(1, 'Maillot FC Barcelone Extérieur', 'barca-ext-24','Maillot extérieur FC Barcelone. Couleurs vives et design moderne pour les supporters du Barça.', 79.99, 15, 'barca-ext.svg'),
(1, 'Maillot Real Madrid Extérieur', 'real-ext-24','Maillot extérieur Real Madrid. Blanc classique avec finitions premium et confort optimal pour les supporters.', 79.99, 5, 'real-exterieur.jpg'),
(1, 'Maillot Manchester City Domicile', 'man-city-dom-24','Maillot domicile Manchester City. Bleu ciel avec finitions dorées et confort pour les fans.', 85.00, 12, 'man-city-dom.jpg'),
(1, 'Maillot Liverpool Extérieur', 'liverpool-ext-24','Maillot extérieur Liverpool. Rouge et blanc avec design moderne.', 82.50, 8, 'liverpool-ext.jpg'),
(1, 'Maillot Chelsea Domicile', 'chelsea-dom-24','Maillot domicile Chelsea. Bleu royal avec blason historique.', 88.00, 6, 'chelsea-dom.jpg'),
(2, 'Hoodie Football Fan', 'hoodie-fan','Sweat fan club Football. Parfait pour supporter votre équipe préférée avec style et confort.',49.90, 20, 'hoodie_fan.svg'),
(2, 'Sweat PSG Officiel', 'sweat-psg','Sweat officiel PSG avec capuche et logo club.', 65.00, 15, 'sweat-psg.jpg'),
(2, 'Hoodie Barcelone', 'hoodie-barca','Hoodie Barcelone avec design rayé.', 55.00, 10, 'hoodie-barca.jpg'),
(2, 'Sweat Real Madrid', 'sweat-real','Sweat Real Madrid blanc avec blason.', 60.00, 18, 'sweat-real.jpg'),
(3, 'Short PSG Officiel', 'short-psg','Short officiel PSG pour entraînement.', 35.00, 25, 'short-psg.jpg'),
(3, 'Bas de Foot Nike', 'bas-nike','Bas de foot Nike haute qualité.', 20.00, 30, 'bas-nike.jpg'),
(3, 'Short Barcelone', 'short-barca','Short Barcelone avec logo.', 38.00, 12, 'short-barca.jpg'),
(3, 'Bas Adidas', 'bas-adidas','Bas Adidas pour joueurs professionnels.', 22.00, 20, 'bas-adidas.jpg'),
(1, 'Maillot Juventus Domicile', 'juventus-dom-24','Maillot domicile Juventus. Noir et blanc avec rayures.', 80.00, 7, 'juventus-dom.jpg'),
(1, 'Maillot Bayern Munich Domicile', 'bayern-dom-24','Maillot domicile Bayern Munich. Rouge avec blason.', 85.00, 9, 'bayern-dom.jpg'),
(1, 'Maillot Manchester United Domicile', 'man-u-dom-24','Maillot domicile Manchester United. Rouge classique.', 82.00, 11, 'man-u-dom.jpg'),
(1, 'Maillot Arsenal Extérieur', 'arsenal-ext-24','Maillot extérieur Arsenal. Blanc avec détails.', 78.00, 8, 'arsenal-ext.jpg'),
(1, 'Maillot Dortmund Domicile', 'dortmund-dom-24','Maillot domicile Dortmund. Jaune et noir.', 75.00, 6, 'dortmund-dom.jpg'),
(2, 'Sweat Manchester City', 'sweat-city','Sweat officiel Manchester City avec capuche.', 70.00, 14, 'sweat-city.jpg'),
(2, 'Hoodie Real Madrid', 'hoodie-real','Hoodie Real Madrid avec logo.', 65.00, 16, 'hoodie-real.jpg'),
(2, 'Sweat Barcelone', 'sweat-barca','Sweat Barcelone rayé.', 68.00, 13, 'sweat-barca.jpg'),
(2, 'Hoodie Juventus', 'hoodie-juve','Hoodie Juventus noir et blanc.', 62.00, 10, 'hoodie-juve.jpg'),
(3, 'Short Manchester City', 'short-city','Short officiel Manchester City.', 40.00, 22, 'short-city.jpg'),
(3, 'Bas Adidas Pro', 'bas-adidas-pro','Bas Adidas pour professionnels.', 25.00, 28, 'bas-adidas-pro.jpg'),
(3, 'Short Real Madrid', 'short-real','Short Real Madrid blanc.', 42.00, 19, 'short-real.jpg'),
(3, 'Bas Nike Mercurial', 'bas-nike-merc','Bas Nike haute performance.', 28.00, 25, 'bas-nike-merc.jpg'),
(1, 'Maillot Inter Milan Domicile', 'inter-dom-24','Maillot domicile Inter Milan. Bleu et noir.', 83.00, 12, 'inter-dom.jpg'),
(1, 'Maillot AC Milan Extérieur', 'milan-ext-24','Maillot extérieur AC Milan. Rouge et noir.', 81.00, 10, 'milan-ext.jpg'),
(1, 'Maillot Atletico Madrid Domicile', 'atletico-dom-24','Maillot domicile Atlético Madrid. Rouge et blanc rayé.', 84.00, 14, 'atletico-dom.jpg'),
(1, 'Maillot Napoli Domicile', 'napoli-dom-24','Maillot domicile Napoli. Bleu azur avec blason.', 80.00, 11, 'napoli-dom.jpg'),
(1, 'Maillot Tottenham Domicile', 'tottenham-dom-24','Maillot domicile Tottenham. Blanc avec liséré bleu.', 86.00, 9, 'tottenham-dom.jpg'),
(1, 'Maillot Aston Villa Domicile', 'aston-villa-dom-24','Maillot domicile Aston Villa. Bordeaux et bleu.', 79.50, 10, 'aston-villa-dom.jpg'),
(1, 'Maillot Galatasaray Domicile', 'galatasaray-dom-24','Maillot domicile Galatasaray. Rouge et jaune.', 77.00, 8, 'galatasaray-dom.jpg'),
(1, 'Maillot Fenerbahçe Domicile', 'fenerbahce-dom-24','Maillot domicile Fenerbahçe. Jaune et bleu.', 76.00, 7, 'fenerbahce-dom.jpg'),
(1, 'Maillot Lazio Domicile', 'lazio-dom-24','Maillot domicile Lazio. Bleu ciel avec blason.', 81.00, 13, 'lazio-dom.jpg'),
(1, 'Maillot Roma Domicile', 'roma-dom-24','Maillot domicile AS Roma. Rouge et bordeaux.', 82.00, 12, 'roma-dom.jpg'),
(1, 'Maillot Benfica Domicile', 'benfica-dom-24','Maillot domicile SL Benfica. Blanc et rouge.', 78.50, 9, 'benfica-dom.jpg'),
(1, 'Maillot Porto Domicile', 'porto-dom-24','Maillot domicile FC Porto. Bleu et blanc.', 79.00, 10, 'porto-dom.jpg'),
(1, 'Maillot Ajax Amsterdam', 'ajax-dom-24','Maillot domicile Ajax Amsterdam. Blanc et rouge.', 75.00, 11, 'ajax-dom.jpg'),
(1, 'Maillot PSV Eindhoven', 'psv-dom-24','Maillot domicile PSV Eindhoven. Rouge et noir.', 74.50, 8, 'psv-dom.jpg'),
(1, 'Maillot OL Lyon', 'ol-lyon-dom-24','Maillot domicile Olympique Lyonnais. Bleu blanc et rouge.', 73.00, 9, 'ol-lyon-dom.jpg'),
(1, 'Maillot OM Marseille', 'om-marseille-dom-24','Maillot domicile Olympique de Marseille. Blanc et bleu.', 76.00, 12, 'om-marseille-dom.jpg'),
(1, 'Maillot Stade Brest', 'stade-brest-dom-24','Maillot domicile Stade Brest. Blanc et noir.', 68.00, 10, 'stade-brest-dom.jpg'),
(1, 'Maillot LOSC Lille', 'losc-lille-dom-24','Maillot domicile LOSC Lille. Blanc et noir.', 69.00, 11, 'losc-lille-dom.jpg'),
(1, 'Maillot AS Monaco', 'monaco-dom-24','Maillot domicile AS Monaco. Rouge et blanc.', 70.00, 9, 'monaco-dom.jpg'),
(1, 'Maillot Ligue 1 France', 'france-dom-24','Maillot domicile équipe de France. Bleu marine officiel.', 95.00, 20, 'france-dom.jpg'),
(1, 'Maillot Angleterre Domicile', 'england-dom-24','Maillot domicile Angleterre. Blanc officiel.', 92.00, 18, 'england-dom.jpg'),
(1, 'Maillot Allemagne Domicile', 'germany-dom-24','Maillot domicile Allemagne. Noir officiel.', 94.00, 17, 'germany-dom.jpg'),
(1, 'Maillot Espagne Domicile', 'spain-dom-24','Maillot domicile Espagne. Rouge officiel.', 91.00, 15, 'spain-dom.jpg'),
(1, 'Maillot Italie Domicile', 'italy-dom-24','Maillot domicile Italie. Bleu officiel.', 93.00, 16, 'italy-dom.jpg'),
(1, 'Maillot Portugal Domicile', 'portugal-dom-24','Maillot domicile Portugal. Rouge officiel.', 89.00, 14, 'portugal-dom.jpg'),
(2, 'Hoodie Bayern Munich', 'hoodie-bayern','Hoodie Bayern Munich avec logo brodé.', 67.00, 12, 'hoodie-bayern.jpg'),
(2, 'Sweat Liverpool', 'sweat-liverpool','Sweat officiel Liverpool avec capuche.', 66.00, 11, 'sweat-liverpool.jpg'),
(2, 'Hoodie Manchester United', 'hoodie-manu','Hoodie Manchester United rouge.', 64.00, 13, 'hoodie-manu.jpg'),
(2, 'Sweat Arsenal', 'sweat-arsenal','Sweat Arsenal blanc.', 63.00, 10, 'sweat-arsenal.jpg'),
(2, 'Hoodie Dortmund', 'hoodie-dortmund','Hoodie Dortmund jaune et noir.', 61.00, 9, 'hoodie-dortmund.jpg'),
(2, 'Sweat Inter Milan', 'sweat-inter','Sweat Inter Milan bleu et noir.', 69.00, 12, 'sweat-inter.jpg'),
(2, 'Hoodie Juventus Pro', 'hoodie-juve-pro','Hoodie Juventus de performance.', 72.00, 14, 'hoodie-juve-pro.jpg'),
(2, 'Sweat AC Milan', 'sweat-milan','Sweat AC Milan rouge et noir.', 68.00, 11, 'sweat-milan.jpg'),
(3, 'Short Bayern Munich', 'short-bayern','Short de foot Bayern Munich.', 41.00, 20, 'short-bayern.jpg'),
(3, 'Bas Liverpool Pro', 'bas-liverpool-pro','Bas de foot Liverpool haute performance.', 26.00, 24, 'bas-liverpool-pro.jpg'),
(3, 'Short Dortmund', 'short-dortmund','Short officiel Dortmund.', 39.00, 18, 'short-dortmund.jpg'),
(3, 'Bas Inter Milan', 'bas-inter','Bas Inter Milan de qualité.', 23.00, 22, 'bas-inter.jpg'),
(3, 'Short Juventus Pro', 'short-juve-pro','Short Juventus de performance.', 44.00, 19, 'short-juve-pro.jpg'),
(3, 'Bas AC Milan', 'bas-milan','Bas AC Milan premium.', 24.00, 21, 'bas-milan.jpg'),
(3, 'Short Atletico Madrid', 'short-atletico','Short Atlético Madrid.', 40.00, 17, 'short-atletico.jpg'),
(3, 'Bas Adidas Predator', 'bas-adidas-predator','Bas haute performance Adidas.', 29.00, 23, 'bas-adidas-predator.jpg');
