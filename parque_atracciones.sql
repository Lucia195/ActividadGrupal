-- ========================================================
-- Crear base de datos y usarla
-- ========================================================
CREATE DATABASE IF NOT EXISTS parque_atracciones
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE parque_atracciones;

-- ========================================================
-- Tabla: usuarios
-- ========================================================
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(150) NOT NULL,
    edad INT CHECK (edad >= 0),
    email VARCHAR(150) UNIQUE NOT NULL,
    contraseña VARCHAR(200) NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ========================================================
-- Tabla: parque_atracciones
-- ========================================================
CREATE TABLE parque_atracciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    parque_imagen VARCHAR(255)
) ENGINE=InnoDB;

-- ========================================================
-- Tabla: zonas_publicas
-- ========================================================
CREATE TABLE zonas_publicas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    parque_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    zona_publica_imagen VARCHAR(255),
    FOREIGN KEY (parque_id) REFERENCES parque_atracciones(id)
) ENGINE=InnoDB;

-- ========================================================
-- Tabla: atracciones
-- ========================================================
CREATE TABLE atracciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    parque_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    edad_minima INT,
    atraccion_imagen VARCHAR(255),
    FOREIGN KEY (parque_id) REFERENCES parque_atracciones(id)
) ENGINE=InnoDB;

-- ========================================================
-- Tabla: restaurantes
-- ========================================================
CREATE TABLE restaurantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    parque_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    tipo_cocina VARCHAR(100),
    descripcion TEXT,
    restaurante_imagen VARCHAR(255),
    FOREIGN KEY (parque_id) REFERENCES parque_atracciones(id)
) ENGINE=InnoDB;

-- ========================================================
-- Tabla: valoraciones (polimórfica)
-- ========================================================
CREATE TABLE valoraciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    valorable_id INT NOT NULL,
    valorable_tipo ENUM('parque', 'zona_publica', 'atraccion', 'restaurante') NOT NULL,
    puntuacion INT NOT NULL CHECK (puntuacion BETWEEN 1 AND 5),
    comentario TEXT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB;

-- ========================================================
-- INSERTS
-- ========================================================

-- Parques
INSERT INTO parque_atracciones (nombre, descripcion, parque_imagen) VALUES
('Warner Madrid', 'Parque temático basado en personajes de Warner Bros.', 'warner_madrid.jpg'),
('Parque de Atracciones de Madrid', 'Parque de atracciones general con diversas temáticas.', 'parque_atracciones_madrid.jpg'),
('PortAventura', 'Gran parque temático en Salou, España, con diversas zonas temáticas.', 'portaventura.jpg');

-- Zonas públicas Warner Madrid (id parque = 1)
INSERT INTO zonas_publicas (parque_id, nombre, descripcion, zona_publica_imagen) VALUES
(1, 'Main Street', 'Entrada principal con tiendas y restaurantes.', 'main_street_warner.jpg'),
(1, 'Superheros Area', 'Zona dedicada a los superhéroes de DC Comics.', 'superheroes_area_warner.jpg'),
(1, 'Looney Tunes Land', 'Área de Looney Tunes para toda la familia.', 'looney_tunes_land_warner.jpg'),
(1, 'Cartoon Village', 'Zona temática con personajes de dibujos animados.', 'cartoon_village_warner.jpg');

-- Atracciones Warner Madrid
INSERT INTO atracciones (parque_id, nombre, descripcion, edad_minima, atraccion_imagen) VALUES
(1, 'Superman: La Atracción de Acero', 'Montaña rusa de alta velocidad basada en Superman.', 12, 'superman_ride.jpg'),
(1, 'Batman: Arkham Asylum', 'Montaña rusa invertida inspirada en Batman.', 10, 'batman_ride.jpg'),
(1, 'La Venganza del Enigma', 'Montaña rusa de giros y caídas extremas.', 12, 'venganza_enigma.jpg'),
(1, 'Correcaminos Bip-Bip', 'Montaña rusa familiar para niños pequeños.', 6, 'correcaminos_ride.jpg');

-- Restaurantes Warner Madrid
INSERT INTO restaurantes (parque_id, nombre, tipo_cocina, descripcion, restaurante_imagen) VALUES
(1, 'Restaurante Superman', 'Comida rápida', 'Restaurante inspirado en Superman con hamburguesas y snacks.', 'restaurante_superman.jpg'),
(1, 'Restaurante Batcave', 'Comida rápida', 'Restaurante de temática Batman con pizzas y ensaladas.', 'restaurante_batcave.jpg'),
(1, 'Restaurante Looney Tunes', 'Comida rápida', 'Restaurante para niños con menús especiales y temática Looney Tunes.', 'restaurante_looney_tunes.jpg'),
(1, 'Restaurante Cartoon', 'Comida rápida', 'Comida rápida con temática de personajes de dibujos animados.', 'restaurante_cartoon.jpg');

-- Zonas públicas Parque de Atracciones de Madrid (id parque = 2)
INSERT INTO zonas_publicas (parque_id, nombre, descripcion, zona_publica_imagen) VALUES
(2, 'Entrada', 'Zona de acceso con tiendas y atracciones iniciales.', 'entrada_parque_atracciones.jpg'),
(2, 'Zona Infantil', 'Zona para niños con juegos y atracciones suaves.', 'zona_infantil_parque_atracciones.jpg'),
(2, 'Río Bravo', 'Zona temática del Oeste con agua y montaña rusa.', 'rio_bravo_parque_atracciones.jpg'),
(2, 'Jardines', 'Zona tranquila con jardines y pequeños paseos.', 'jardines_parque_atracciones.jpg');

-- Atracciones Parque de Atracciones de Madrid
INSERT INTO atracciones (parque_id, nombre, descripcion, edad_minima, atraccion_imagen) VALUES
(2, 'Abismo', 'Montaña rusa con caída libre.', 12, 'abismo_ride.jpg'),
(2, 'El Tren de la Mina', 'Montaña rusa en el estilo del Oeste.', 10, 'tren_mina_ride.jpg'),
(2, 'La Aventura del Oeste', 'Atracción de agua con temática del Oeste.', 8, 'aventura_oeste_ride.jpg'),
(2, 'La Vuelta al Mundo', 'Gran rueda de observación con vistas panorámicas del parque.', 0, 'vuelta_mundo_ride.jpg');

-- Restaurantes Parque de Atracciones de Madrid
INSERT INTO restaurantes (parque_id, nombre, tipo_cocina, descripcion, restaurante_imagen) VALUES
(2, 'Restaurante Gran Avenida', 'Comida variada', 'Restaurante en la entrada con platos variados.', 'restaurante_gran_avenida.jpg'),
(2, 'Restaurante El Oeste', 'Comida del Oeste', 'Restaurante de comida rápida inspirado en el Oeste.', 'restaurante_oeste.jpg'),
(2, 'Restaurante Río Bravo', 'Comida rápida', 'Restaurante con vistas al río y hamburguesas.', 'restaurante_rio_bravo.jpg'),
(2, 'Restaurante Jardines', 'Comida mediterránea', 'Restaurante tranquilo con platos mediterráneos.', 'restaurante_jardines.jpg');

-- Zonas públicas PortAventura (id parque = 3)
INSERT INTO zonas_publicas (parque_id, nombre, descripcion, zona_publica_imagen) VALUES
(3, 'Entrada', 'Zona de acceso al parque con tiendas y servicios.', 'entrada_portaventura.jpg'),
(3, 'Mediterrània', 'Zona con temática mediterránea y ambiente relajado.', 'mediterrania_portaventura.jpg'),
(3, 'Furius Baco', 'Zona con montañas rusas y atracciones extremas.', 'furius_baco_portaventura.jpg'),
(3, 'Polynesia', 'Zona tropical con temática de la Polinesia y aguas termales.', 'polynesia_portaventura.jpg');

-- Atracciones PortAventura
INSERT INTO atracciones (parque_id, nombre, descripcion, edad_minima, atraccion_imagen) VALUES
(3, 'Shambhala', 'La montaña rusa más alta y rápida de Europa.', 12, 'shambhala_ride.jpg'),
(3, 'Furius Baco', 'Montaña rusa que acelera a más de 100 km/h en segundos.', 10, 'furius_baco_ride.jpg'),
(3, 'Dragon Khan', 'Montaña rusa con 8 inversiones extremas.', 12, 'dragon_khan_ride.jpg'),
(3, 'El Templo del Fuego', 'Atracción de simulación con temática maya.', 10, 'templo_fuego_ride.jpg');

-- Restaurantes PortAventura
INSERT INTO restaurantes (parque_id, nombre, tipo_cocina, descripcion, restaurante_imagen) VALUES
(3, 'Restaurante Mediterráneo', 'Cocina mediterránea', 'Restaurante con platos mediterráneos y mariscos.', 'restaurante_mediterraneo.jpg'),
(3, 'Restaurante Polynesia', 'Comida asiática', 'Restaurante con platos típicos de la Polinesia.', 'restaurante_polynesia.jpg'),
(3, 'Restaurante Furius Baco', 'Comida rápida', 'Restaurante en la zona de Furius Baco con comida rápida.', 'restaurante_furius_baco.jpg'),
(3, 'Restaurante Gran Buffet', 'Buffet libre', 'Buffet con una gran variedad de platos internacionales.', 'restaurante_gran_buffet.jpg');
