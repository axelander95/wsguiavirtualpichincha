DROP SCHEMA IF EXISTS db_guiavirtualpichincha;
CREATE SCHEMA db_guiavirtualpichincha;
USE db_guiavirtualpichincha;
DROP TABLE IF EXISTS tb_imagen_visita_sitio_turistico;
DROP TABLE IF EXISTS tb_visita_sitio_turistico;
DROP TABLE IF EXISTS tb_calificacion_sitio_turistico;
DROP TABLE IF EXISTS tb_comentario_sitio_turistico;
DROP TABLE IF EXISTS tb_sitio_turistico;
DROP TABLE IF EXISTS tb_categoria;
DROP TABLE IF EXISTS tb_usuario;
DROP TABLE IF EXISTS tb_canton;
DROP TABLE IF EXISTS tb_provincia;
DROP TABLE IF EXISTS tb_pais;
CREATE TABLE tb_pais (
	id_pais INT NOT NULL PRIMARY KEY,
    descripcion VARCHAR(50),
    estado BIT
);
CREATE TABLE tb_provincia (
	id_provincia INT NOT NULL PRIMARY KEY,
    id_pais INT NOT NULL,
    descripcion VARCHAR(50) NOT NULL,
    estado BIT NOT NULL,
    FOREIGN KEY (id_pais) REFERENCES tb_pais(id_pais)
);
CREATE TABLE tb_canton (
	id_canton INT NOT NULL PRIMARY KEY,
    id_provincia INT NOT NULL,
    descripcion VARCHAR(50),
    estado BIT NOT NULL,
    FOREIGN KEY (id_provincia) REFERENCES tb_provincia(id_provincia)
);
CREATE TABLE tb_usuario (
	id_usuario INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_canton INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    correo_electronico VARCHAR(100) NOT NULL,
    nombre_usuario VARCHAR(50) NOT NULL,
    contrasena TEXT NOT NULL,
    fecha_registro DATETIME NOT NULL,
    tipo_usuario CHAR(1),
    estado CHAR(1) NOT NULL,
    FOREIGN KEY (id_canton) REFERENCES tb_canton(id_canton)
);
CREATE TABLE tb_categoria (
	id_categoria INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(50) NOT NULL,
    estado BIT NOT NULL
);
CREATE TABLE tb_sitio_turistico (
	id_sitio_turistico INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_categoria INT NOT NULL,
    id_canton INT NOT NULL,
    descripcion VARCHAR(100) NOT NULL,
    imagen TEXT NOT NULL,
    latitud TEXT NOT NULL,
    longitud TEXT NOT NULL,
    sitio_web TEXT NULL,
    distintivo_q BIT NOT NULL,
    fecha_publicacion DATETIME NOT NULL,
    id_usuario INT NOT NULL,
    estado BIT,
    FOREIGN KEY (id_categoria) REFERENCES tb_categoria (id_categoria),
    FOREIGN KEY (id_canton) REFERENCES tb_canton(id_canton),
    FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario)
);
CREATE TABLE tb_comentario_sitio_turistico (
	id_comentario INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_sitio_turistico INT NOT NULL,
    id_usuario INT NOT NULL,
    estado CHAR(1),
    FOREIGN KEY (id_sitio_turistico) REFERENCES tb_sitio_turistico(id_sitio_turistico),
    FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario)
);
CREATE TABLE tb_calificacion_sitio_turistico (
	id_sitio_turistico INT NOT NULL,
    id_usuario INT NOT NULL,
    valor DECIMAL (2,2),
    PRIMARY KEY (id_sitio_turistico, id_usuario),
    FOREIGN KEY (id_sitio_turistico) REFERENCES tb_sitio_turistico(id_sitio_turistico),
    FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario)
);
CREATE TABLE tb_visita_sitio_turistico (
	id_visita_sitio_turistico INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_sitio_turistico INT NOT NULL,
    id_usuario INT NOT NULL,
    fecha_visita DATE,
    FOREIGN KEY (id_sitio_turistico) REFERENCES tb_sitio_turistico(id_sitio_turistico),
    FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario)
);
CREATE TABLE tb_imagen_visita_sitio_turistico (
	id_imagen_visita_sitio_turistico INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_visita_sitio_turistico INT NOT NULL,
    id_usuario INT NOT NULL,
    descripcion VARCHAR(50),
    estado CHAR(1),
    FOREIGN KEY (id_visita_sitio_turistico) REFERENCES tb_visita_sitio_turistico(id_visita_sitio_turistico),
    FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario)
);
INSERT INTO tb_pais (id_pais, descripcion, estado) VALUES (1, 'Ecuador', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (1, 1, 'Azuay', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (1, 1, 'Cuenca', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (2, 1, 'Bolívar', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (2, 2, 'Guaranda', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (3, 1, 'Cañar', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (3, 3, 'Azogues', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (4, 1, 'Carchi', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (4, 4, 'Tulcán', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (5, 1, 'Chimborazo', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (5, 5, 'Riobamba', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (6, 1, 'Cotopaxi', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (6, 6, 'Latacunga', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (7, 1, 'El Oro', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (7, 7, 'Machala', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (8, 1, 'Esmeraldas', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (8, 8, 'Esmeraldas', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (9, 1, 'Galápagos', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (9, 9, 'Puerto Baquerizo Moreno', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (10, 1, 'Guayas', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (10, 10, 'Guayaquil', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (11, 1, 'Imbabura', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (11, 11, 'Ibarra', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (12, 1, 'Loja', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (12, 12, 'Loja', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (13, 1, 'Los Ríos', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (13, 13, 'Babahoyo', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (14, 1, 'Manabí', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (14, 14, 'Portoviejo', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (15, 1, 'Morona Santiago', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (15, 15, 'Macas', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (16, 1, 'Napo', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (16, 16, 'Tena', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (17, 1, 'Orellana', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (17, 17, 'Francisco de Orellana', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (18, 1, 'Pastaza', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (18, 18, 'Puyo', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (19, 1, 'Pichincha', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (19, 19, 'Quito', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (20, 1, 'Santa Elena', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (20, 20, 'Santa Elena', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (21, 1, 'Santo Domingo de los Tsáchilas', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (21, 21, 'Santo Domingo', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (22, 1, 'Sucumbíos', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (22, 22, 'Nueva Loja', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (23, 1, 'Tungurahua', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (23, 23, 'Ambato', 1);
INSERT INTO tb_provincia (id_provincia, id_pais, descripcion, estado) VALUES (24, 1, 'Zamora Chinchipe', 1);
INSERT INTO tb_canton (id_canton, id_provincia, descripcion, estado) VALUES (24, 24, 'Zamora', 1);
